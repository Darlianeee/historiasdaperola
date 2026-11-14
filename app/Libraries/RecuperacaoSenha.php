
<?php

// Classe responsável por criar e validar links de redefinição de senha.
class RecuperacaoSenha
{
    // Define que o link ficará válido por 30 minutos.
    const VALIDADE_EM_SEGUNDOS = 1800;

    // Converte o tempo de validade de segundos para minutos.
    public static function validadeEmMinutos()
    {
        return (int) (self::VALIDADE_EM_SEGUNDOS / 60);
    }

    // Cria um token para identificar a pessoa e validar o link de recuperação.
    public static function gerarToken($pessoa)
    {
        $dados = (int) $pessoa->pess_id . '.' . (time() + self::VALIDADE_EM_SEGUNDOS);

        // Junta os dados da pessoa com uma assinatura de segurança.
        return self::base64url($dados) . '.' . self::assinar($dados, $pessoa->pess_senha);
    }

    // Verifica se o token é válido e identifica a pessoa que solicitou a recuperação.
    public static function pessoaDoToken($token, $pessoaModel)
    {
        $token = (string) $token;

        // Verifica se o token foi informado e se possui um tamanho permitido.
        if ($token === '' || strlen($token) > 300) {
            return false;
        }

        // Separa as partes do token.
        $partes = explode('.', $token);

        // Verifica se o token possui as duas partes esperadas.
        if (count($partes) !== 2) {
            return false;
        }

        // Decodifica os dados que estão no token.
        $dados = self::desfazerBase64url($partes[0]);

        // Confere se os dados possuem o formato correto.
        if ($dados === false || !preg_match('/^(\d+)\.(\d+)$/', $dados, $achou)) {
            return false;
        }

        // Verifica se o prazo de validade do link já terminou.
        if ((int) $achou[2] < time()) {
            return false;
        }

        // Busca os dados da pessoa pelo seu ID.
        $pessoa = $pessoaModel->buscarPorId((int) $achou[1]);

        // Verifica se a pessoa existe e se a conta está ativa.
        if (!$pessoa || $pessoa->pess_status !== 'Ativo') {
            return false;
        }

        // Gera novamente a assinatura para comparar com a recebida.
        $esperada = self::assinar($dados, $pessoa->pess_senha);

        // Retorna a pessoa se a assinatura for válida ou false caso contrário.
        return hash_equals($esperada, $partes[1]) ? $pessoa : false;
    }

    // Monta o endereço completo do link de redefinição de senha.
    public static function link($token)
    {
        $config = require APP . '/Controllers/configuracao_email.php';
        $base = rtrim((string) ($config['url_site'] ?? ''), '/');

        // Usa o endereço padrão do sistema quando a URL não estiver configurada.
        if ($base === '') {
            $base = URL;
        }

        return $base . '/paginas/redefinir_senha?token=' . $token;
    }

    // Cria o link de recuperação e envia o e-mail para a pessoa.
    public static function enviarLink($pessoa)
    {
        try {
            // Gera o link, define o prazo de validade e obtém o nome da pessoa.
            $link = self::link(self::gerarToken($pessoa));
            $minutos = self::validadeEmMinutos();
            $nome = (string) $pessoa->pess_nome;

            // Monta a mensagem em texto simples que será enviada por e-mail.
            $texto = "Olá, {$nome}!\r\n\r\n"
                . "Recebemos um pedido para criar uma nova senha na sua conta do Histórias na Pérola.\r\n\r\n"
                . "Para escolher a nova senha, abra o link abaixo. Ele vale por {$minutos} minutos "
                . "e só pode ser usado uma vez:\r\n\r\n"
                . $link . "\r\n\r\n"
                . "Se você não fez esse pedido, ignore este e-mail. Sua senha continua a mesma.\r\n";

            // Monta a versão em HTML da mensagem que será enviada.
            $html = '<div style="font-family:Arial,sans-serif;max-width:520px;margin:0 auto;color:#333;line-height:1.5">'
                . '<h2 style="color:#4c6123;margin-bottom:8px">Redefinição de senha</h2>'
                . '<p>Olá, ' . Html::e($nome) . '!</p>'
                . '<p>Recebemos um pedido para criar uma nova senha na sua conta do Histórias na Pérola.</p>'
                . '<p style="margin:28px 0">'
                . '<a href="' . Html::e($link) . '" style="background:#c99a22;color:#ffffff;'
                . 'text-decoration:none;font-weight:bold;padding:12px 24px;border-radius:4px;'
                . 'display:inline-block">Criar nova senha</a></p>'
                . '<p>O link vale por ' . $minutos . ' minutos e só pode ser usado uma vez. '
                . 'Se o botão não funcionar, copie e cole este endereço no navegador:</p>'
                . '<p style="word-break:break-all;font-size:13px">' . Html::e($link) . '</p>'
                . '<p style="color:#777;font-size:13px">Se você não fez esse pedido, ignore este e-mail. '
                . 'Sua senha continua a mesma.</p>'
                . '</div>';

            // Envia o e-mail para o endereço cadastrado da pessoa.
            return (new Email())->enviar($pessoa->emai_nome, 'Redefinição de senha', $texto, $html);
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível preparar ou enviar o e-mail.
            error_log('Erro ao preparar o e-mail de redefinição: ' . $erro->getMessage());
            return false;
        }
    }

    // Internos

    // Cria uma assinatura de segurança usando os dados e o hash da senha.
    private static function assinar($dados, $hashDaSenha)
    {
        return hash_hmac('sha256', $dados . '|' . $hashDaSenha, self::chave());
    }

    // Busca a chave secreta usada para validar os tokens.
    private static function chave()
    {
        $config = require APP . '/Controllers/configuracao_email.php';
        $chave = (string) ($config['chave_token'] ?? '');

        // Verifica se a chave possui o tamanho mínimo necessário.
        if (strlen($chave) < 32) {
            throw new RuntimeException(
                'Defina "chave_token" (mínimo de 32 caracteres) em app/Controllers/configuracao_email.php.'
            );
        }

        return $chave;
    }

    // Codifica os dados em Base64 para serem utilizados no link.
    private static function base64url($texto)
    {
        return rtrim(strtr(base64_encode($texto), '+/', '-_'), '=');
    }

    // Desfaz a codificação Base64 para recuperar os dados originais.
    private static function desfazerBase64url($texto)
    {
        return base64_decode(strtr($texto, '-_', '+/'), true);
    }
}
