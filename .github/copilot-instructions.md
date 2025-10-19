Null-Bank — Instruções para agentes (Copilot)

Resumo rápido

- Projeto: Null-Bank
- Stack: PHP (procedural), MySQL, frontend em PHP/HTML/CSS. Há um scaffold de migração para Laravel em `app/` e `database/migrations/`.
- Principais locais:
  - Conexão DB: `php/conexao.php`
  - Login: `php/login.php`
  - Handlers: `php/gerente_actions.php`, `pages/cadastro.php`
  - Esquema SQL: `modelagem/ScriptNullBank.sql` e `modelagem/povoamento.sql`
  - Docker compose: `docker-compose.yml`

O que fazer automaticamente

- Prefira segurança: use prepared statements (`mysqli` ou PDO) e `password_hash`/`password_verify` para senhas.
- Ao editar handlers, preserve transações para operações multi-tabela (veja `pages/cadastro.php`).
- Não remova o arquivo `modelagem/ScriptNullBank.sql`; trate-o como fonte de verdade do esquema.

Exemplos úteis

- Conexão padrão: incluir `php/conexao.php` e usar `$conn->prepare(...)`.
- Rodar scripts de migração localmente: `php php/migrate_passwords.php` e `php php/migrate_funcionarios_to_users.php`.

Notas finais

- Antes de executar scripts de migração em produção, sempre faça backup do banco.
- Se adicionar ou renomear tabelas, atualize também `modelagem/` e o scaffold Laravel, se presente.
