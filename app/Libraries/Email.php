
<?php

// Classe responsável por enviar e-mails pelo servidor SMTP.
class Email
{
    private $config;
    private $conexao = null;
    private $ultimoErro = '';

    // Carrega as configurações do servidor de e-mail.
    public function __construct()
    {
        $this->config = require APP . '/Controllers/configuracao_email.php';
    }

    // Retorna a mensagem do último erro que aconteceu ao enviar um e-mail.
    public function ultimoErro()
    {
        return $this->ultimoErro;
    }

    // Envia um e-mail com uma versão em texto e outra em HTML.
    public function enviar($destinatario, $assunto, $texto, $html)
    {
        $this->ultimoErro = '';

        try {
            // Limpa os endereços de e-mail antes de utilizá-los.
            $remetente = $this->limparEndereco($this->config['remetente'] ?? '');
            $destinatario = $this->limparEndereco($destinatario);

            // Verifica se os endereços de e-mail são válidos.
            if (
                !filter_var($remetente, FILTER_VALIDATE_EMAIL)
                || !filter_var($destinatario, FILTER_VALIDATE_EMAIL)
            ) {
                throw new RuntimeException('Endereço de e-mail inválido.');
            }

            // Conecta ao servidor e realiza a autenticação.
            $this->conectar();
            $this->autenticar();

            // Informa ao servidor quem está enviando e quem vai receber o e-mail.
            $this->comando('MAIL FROM:<' . $remetente . '>', [250]);
            $this->comando('RCPT TO:<' . $destinatario . '>', [250, 251]);
            $this->comando('DATA', [354]);

            // Monta o conteúdo completo da mensagem.
            $mensagem = $this->montarMensagem($remetente, $destinatario, $assunto, $texto, $html);

            // Linha que começa com ponto precisa de outro ponto na frente (regra do SMTP).
            $mensagem = preg_replace('/^\./m', '..', $mensagem);

            // Envia a mensagem e aguarda a confirmação do servidor.
            $this->escrever($mensagem . "\r\n.\r\n");
            $this->esperar([250]);

            return true;
        } catch (Throwable $erro) {
            // Guarda o erro e registra a mensagem no log do PHP.
            $this->ultimoErro = $erro->getMessage();
            error_log('Falha ao enviar e-mail: ' . $erro->getMessage());
            return false;
        } finally {
            // Fecha a conexão mesmo quando acontece algum erro.
            $this->fechar();
        }
    }

    // ---------------------------------------------------------------
    // Conexão
    // ---------------------------------------------------------------

    // Estabelece a conexão com o servidor de e-mail.
    private function conectar()
    {
        // Lê os dados de conexão definidos no arquivo de configuração.
        $host = (string) ($this->config['host'] ?? '');
        $porta = (int) ($this->config['porta'] ?? 587);
        $seguranca = strtolower((string) ($this->config['seguranca'] ?? 'tls'));
        $verificar = ($this->config['verificar_certificado'] ?? true) !== false;

        // Verifica se o endereço do servidor foi informado.
        if ($host === '') {
            throw new RuntimeException('Servidor SMTP não configurado.');
        }

        // Define as opções de segurança da conexão.
        $ssl = [
            'verify_peer' => $verificar,
            'verify_peer_name' => $verificar,
            'allow_self_signed' => !$verificar,
            'peer_name' => $host,
            'SNI_enabled' => true
        ];

        // Procura um arquivo de certificados para validar a conexão.
        $certificados = $this->localizarCertificados();

        if ($verificar && $certificados !== null) {
            $ssl['cafile'] = $certificados;
        }

        // Cria as configurações da conexão segura.
        $contexto = stream_context_create(['ssl' => $ssl]);

        // "ssl" = porta 465 (já começa criptografado). "tls" = porta 587 (STARTTLS).
        $protocolo = $seguranca === 'ssl' ? 'ssl' : 'tcp';

        // Tenta conectar ao servidor SMTP.
        $this->conexao = @stream_socket_client(
            $protocolo . '://' . $host . ':' . $porta,
            $codigoErro,
            $mensagemErro,
            15,
            STREAM_CLIENT_CONNECT,
            $contexto
        );

        // Informa o erro caso não consiga estabelecer a conexão.
        if (!$this->conexao) {
            throw new RuntimeException(
                'Não foi possível conectar a ' . $host . ':' . $porta .
                    ' (' . $codigoErro . ': ' . $mensagemErro . ').'
            );
        }

        // Define o tempo máximo de espera por uma resposta.
        stream_set_timeout($this->conexao, 15);

        // Aguarda a resposta inicial e informa o nome do computador.
        $this->esperar([220]);
        $this->comando('EHLO ' . $this->nomeLocal(), [250]);

        // Ativa a segurança TLS quando essa opção está configurada.
        if ($seguranca === 'tls') {
            $this->comando('STARTTLS', [220]);

            $ativou = @stream_socket_enable_crypto(
                $this->conexao,
                true,
                STREAM_CRYPTO_METHOD_TLS_CLIENT
            );

            // Verifica se a conexão segura foi ativada.
            if ($ativou !== true) {
                $detalhe = error_get_last()['message'] ?? '';
                throw new RuntimeException(
                    'Falha ao ativar a conexão segura (TLS). ' . $detalhe . ' ' .
                        'Se for erro de certificado no XAMPP, aponte openssl.cafile no php.ini ' .
                        'ou, só em ambiente local, use \'verificar_certificado\' => false ' .
                        'em configuracao_email.php.'
                );
            }

            // Depois do STARTTLS o servidor espera um novo EHLO.
            $this->comando('EHLO ' . $this->nomeLocal(), [250]);
        }
    }

    // Faz o login no servidor SMTP usando o usuário e a senha configurados.
    private function autenticar()
    {
        $usuario = (string) ($this->config['usuario'] ?? '');
        $senha = (string) ($this->config['senha'] ?? '');

        // Servidores de teste locais podem funcionar sem login.
        if ($usuario === '') {
            return;
        }

        // Envia o usuário e a senha codificados para autenticação.
        $this->comando('AUTH LOGIN', [334]);
        $this->comando(base64_encode($usuario), [334], 'usuário SMTP');
        $this->comando(base64_encode($senha), [235], 'senha SMTP');
    }

    // Encerra a conexão com o servidor de e-mail.
    private function fechar()
    {
        if (is_resource($this->conexao)) {
            @fwrite($this->conexao, "QUIT\r\n");
            @fclose($this->conexao);
        }

        $this->conexao = null;
    }

    // Procura o arquivo de certificados confiáveis (necessário no Windows/XAMPP).
    private function localizarCertificados()
    {
        // Lista os possíveis locais onde o arquivo de certificados pode estar.
        $candidatos = [
            $this->config['cafile'] ?? '',
            ini_get('openssl.cafile'),
            ini_get('curl.cainfo'),
            'C:\\xampp\\apache\\bin\\curl-ca-bundle.crt',
            'C:\\xampp\\php\\extras\\ssl\\cacert.pem'
        ];

        // Retorna o primeiro arquivo encontrado.
        foreach ($candidatos as $arquivo) {
            if ($arquivo && is_file($arquivo)) {
                return $arquivo;
            }
        }

        return null;
    }

    // Identifica o nome do computador usado na comunicação com o servidor.
    private function nomeLocal()
    {
        $nome = preg_replace('/[^A-Za-z0-9.-]/', '', (string) ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        return $nome !== '' ? $nome : 'localhost';
    }

    // ---------------------------------------------------------------
    // Conversa com o servidor
    // ---------------------------------------------------------------

    // Envia os dados para o servidor SMTP.
    private function escrever($dados)
    {
        $restante = $dados;

        // Continua enviando enquanto ainda houver dados pendentes.
        while ($restante !== '') {
            $escrito = fwrite($this->conexao, $restante);

            // Verifica se houve algum problema durante o envio.
            if ($escrito === false || $escrito === 0) {
                throw new RuntimeException('Falha ao enviar dados ao servidor SMTP.');
            }

            $restante = (string) substr($restante, $escrito);
        }
    }

    // Envia um comando e confere se a resposta tem um dos códigos esperados.
    // $descricao evita que usuário e senha apareçam em mensagens de erro.
    private function comando($linha, array $codigosEsperados, $descricao = null)
    {
        $this->escrever($linha . "\r\n");

        try {
            return $this->esperar($codigosEsperados);
        } catch (RuntimeException $erro) {
            throw new RuntimeException(($descricao ?? $linha) . ': ' . $erro->getMessage());
        }
    }

    // Lê a resposta do servidor (pode ter várias linhas: "250-..." e termina em "250 ...").
    private function esperar(array $codigosEsperados)
    {
        $resposta = '';

        // Lê as linhas enviadas pelo servidor.
        while (($linha = fgets($this->conexao, 515)) !== false) {
            $resposta .= $linha;

            // Para a leitura quando chega à última linha da resposta.
            if (!isset($linha[3]) || $linha[3] !== '-') {
                break;
            }
        }

        // Informa quando o servidor não envia nenhuma resposta.
        if ($resposta === '') {
            throw new RuntimeException('O servidor SMTP não respondeu a tempo.');
        }

        // Obtém o código da resposta recebida.
        $codigo = (int) substr($resposta, 0, 3);

        // Verifica se o código recebido está entre os esperados.
        if (!in_array($codigo, $codigosEsperados, true)) {
            throw new RuntimeException('Resposta inesperada do servidor SMTP: ' . trim($resposta));
        }

        return $resposta;
    }

    // ---------------------------------------------------------------
    // Montagem da mensagem
    // ---------------------------------------------------------------

    // Organiza o remetente, destinatário, assunto e conteúdo do e-mail.
    private function montarMensagem($remetente, $destinatario, $assunto, $texto, $html)
    {
        // Obtém o nome do remetente, o domínio do e-mail e um identificador da mensagem.
        $nome = (string) ($this->config['nome_remetente'] ?? '');
        $dominio = (string) substr((string) strrchr($remetente, '@'), 1);
        $limite = 'hp_' . bin2hex(random_bytes(12));

        // Define como o nome e o endereço do remetente aparecerão no e-mail.
        $de = $nome !== ''
            ? $this->codificarCabecalho($nome) . ' <' . $remetente . '>'
            : $remetente;

        // Monta os cabeçalhos e os conteúdos em texto e HTML.
        $linhas = [
            'Date: ' . date('r'),
            'From: ' . $de,
            'To: ' . $destinatario,
            'Subject: ' . $this->codificarCabecalho($assunto),
            'Message-ID: <' . bin2hex(random_bytes(16)) . '@' . $dominio . '>',
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $limite . '"',
            '',
            '--' . $limite,
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
            '',
            rtrim(chunk_split(base64_encode($texto))),
            '--' . $limite,
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
            '',
            rtrim(chunk_split(base64_encode($html))),
            '--' . $limite . '--'
        ];

        // Junta todas as partes para formar a mensagem completa.
        return implode("\r\n", $linhas);
    }

    // Texto com acento no cabeçalho precisa ser codificado (=?UTF-8?B?...?=).
    private function codificarCabecalho($texto)
    {
        // Remove quebras de linha para evitar problemas nos cabeçalhos.
        $texto = str_replace(["\r", "\n"], ' ', (string) $texto);

        // Retorna o texto normalmente quando não possui caracteres especiais.
        if (preg_match('/^[\x20-\x7E]*$/', $texto)) {
            return $texto;
        }

        // Codifica o texto para permitir o uso de acentos e caracteres especiais.
        return '=?UTF-8?B?' . base64_encode($texto) . '?=';
    }

    // Impede que o endereço tenha caracteres que possam alterar os cabeçalhos do e-mail.
    private function limparEndereco($endereco)
    {
        return str_replace(["\r", "\n", '<', '>'], '', trim((string) $endereco));
    }
}
