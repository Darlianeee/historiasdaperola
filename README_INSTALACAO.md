# Histórias na Pérola — implementação parcial integrada ao MySQL

## Instalação no XAMPP (Windows)
1. Copie a pasta `historiasdaperola-main` para `C:\xampp\htdocs\`.
2. Inicie Apache e MySQL no XAMPP. Acesse `http://localhost/phpmyadmin`.
3. Crie o banco `bd_historias` (collation `utf8mb4_general_ci`) e importe **`bd/bd_historias.sql`**. O SQL recebido do usuário é a base de referência desta versão.
4. Faça backup antes de aplicar `bd/migracao_001_email_unico.sql`. Primeiro procure e resolva e-mails duplicados, depois execute a migração.
5. Acesse `http://localhost/historiasdaperola-main/`. Alterou o nome da pasta? Mude a constante `URL` em `app/configuracao.php` ou defina `HISTORIAS_URL`.
6. Configuração MySQL por padrão: `127.0.0.1:3306`, banco `bd_historias`, usuário `root`, senha vazia. Para outra configuração, use variáveis de ambiente `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`. Configure credenciais seguras fora do desenvolvimento local.
7. Habilite no PHP as extensões `pdo_mysql`, `fileinfo` e `mbstring` (esta última é recomendada por partes do sistema original). Ative Apache `mod_rewrite` e `AllowOverride All`.

## Conta administrativa
O arquivo SQL fornecido inclui uma pessoa com perfil `Administrador` e hash de senha já existente. **A senha original é desconhecida e não foi redefinida.** Para definir uma nova senha sua, execute no terminal do XAMPP: `C:\xampp\php\php.exe -r "echo password_hash('SUA_SENHA_NOVA_FORTE', PASSWORD_DEFAULT), PHP_EOL;"` e execute no phpMyAdmin o SQL `UPDATE pessoa SET pess_senha='HASH_GERADO' WHERE pess_id=2;`, substituindo `HASH_GERADO` e conferindo o ID da conta antes. Não publique nem reutilize senhas.

## Integrações concretas nesta revisão
- Conexão PDO centralizada, consultas preparadas e `utf8mb4`.
- Cadastro de usuário comum com hash e validação; login/logout com sessão; login separado para administrador.
- Controle de acesso centralizado no roteador; verificação de propriedade ao excluir comentários.
- Perfil do usuário com nome/e-mail reais, edição e troca de senha; imagem de perfil opcional.
- Catálogo consultado do MySQL; página da história por ID, idiomas e comentários persistentes.
- Cadastro, atualização e exclusão transacional de histórias; lista real de perfis e edição de status/perfil por administrador.
- Lista e leitura de notificações do usuário, se houver registros correspondentes no banco.
- Proteção CSRF nos formulários integrados.

## Limitações declaradas / próximas tarefas
- A execução real não foi validada contra MariaDB neste ambiente; foi realizada análise estática e lint PHP.
- Avaliações por nota, resposta administrativa a comentários, interface administrativa completa de notificações e recuperação de senha por e-mail ainda carecem de integração e testes.
- Algumas telas herdadas permanecem demonstrativas (incluindo telas administrativas antigas de comentários, notificações e perfil do administrador). Não trate essas telas como finalizadas.
- Fluxos que ainda não têm formulário funcional devem ser verificados manualmente no XAMPP.
- O dump fornecido não contém histórias publicadas, então cadastre conteúdo pela área administrativa para testar a listagem.
- Verifique a compatibilidade do BLOB das imagens com o tamanho das imagens cadastradas.
- Execute testes funcionais reais de criação de conta, login, cadastro/edição/exclusão de história, edição de perfil, comentários e bloqueio de acesso não autorizado.

## Segurança
Não exponha esta instalação à internet sem revisar todos os formulários e rotas antigos, limitar tentativas de login, ativar HTTPS, definir cabeçalhos seguros e validar o processo de recuperação de senha.
