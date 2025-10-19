# Segurança e migrações — Null-Bank

Este arquivo documenta as mudanças de segurança, migrações e operações executadas no repositório durante a modernização do projeto.

Resumo das ações realizadas
- Atualizei handlers PHP para usar prepared statements e `password_hash`/`password_verify` onde aplicável.
- Adicionei scripts de migração para re-hash de senhas legadas e para migrar funcionários para uma tabela `users`.
- Criei um ambiente Docker (serviço `nullbank-app` e `nullbank-db`) e remapeei a porta MySQL do host para `3307` para evitar conflitos locais.
- Adicionei `.gitignore` para evitar o versionamento de `vendor/`, `backups/` e arquivos sensíveis.

Backups
- Antes de qualquer operação destrutiva, foi criado um dump do banco original e salvo em `backups/` (não comitado). Mantenha esses dumps seguros fora do repositório público.

Migrações executadas (comandos e resultados)
- Re-hash das senhas em `funcionario`:
  - Arquivo: `php/migrate_passwords.php`
  - Execução: `php php/migrate_passwords.php`
  - Resultado: `Senhas atualizadas: 3` (3 senhas de funcionários re-hashadas)

- Migração de `funcionario` para `users`:
  - Arquivo: `php/migrate_funcionarios_to_users.php`
  - Execução: `php php/migrate_funcionarios_to_users.php`
  - Resultado: `Registros migrados: 3` (3 funcionários migrados para `users`)

- Re-hash das senhas de `possui` (clientes):
  - Arquivo: `php/migrate_possui_passwords.php`
  - Execução: `php php/migrate_possui_passwords.php`
  - Resultado: `Senhas atualizadas em possui: 2` (2 senhas de clientes re-hashadas)

Verificação estática e qualidade
- Instalei dependências de desenvolvimento e rodei PHPStan com stubs locais. Resultado: `[OK] No errors` no escopo analisado (`app`, `database`, `php`).

Notas importantes
- As triggers originais do SQL foram removidas do script de importação por causa de inconsistências e precisam ser reescritas e testadas manualmente antes de reativar em produção.
- Se houver necessidade de remover arquivos sensíveis do histórico do Git (ex.: backups com dados reais), use `git filter-repo` ou BFG e coordene o force-push com os colaboradores.

Recomendações finais
- Consolidar a autenticação em uma tabela `users` definitiva e remover autenticação direta de tabelas legadas.
- Habilitar HTTPS e proteções de produção (rate-limit, WAF, monitoramento de logs).

Se precisar, posso gerar um Pull Request com todas as mudanças e instruções de deploy.
# Segurança e Migração de Senhas

O projeto continha senhas em texto no banco (arquivo `modelagem/povoamento.sql`). Abaixo estão instruções práticas para migrar para hashes seguros e testar localmente.

Passos rápidos:

1. Configure o banco de dados no arquivo `php/conexao.php` (não comitar credenciais de produção).
2. Importe o SQL de `modelagem/povoamento.sql` se necessário.
3. Execute o script de migração de senhas:

```powershell
php php/migrate_passwords.php
```

O script irá re-hashar senhas que não parecem já estar armazenadas como hash (`$2y$` ou `$argon`).

Notas:
- Após a migração, logins serão validados com `password_verify` (arquivo `php/login.php`).
- Recomenda-se alterar o fluxo de reset de senha para enviar e-mails e forçar troca na primeira autenticação se a senha for gerada automaticamente.

Ordem recomendada para migração completa (opcional):

1. `php php/migrate_passwords.php` — re-hash em lote de senhas legadas.
2. `php php/migrate_funcionarios_to_users.php` — cria tabela `users` e copia funcionarios com roles.
3. Verificar logins em `pages/index.php` — `php/login.php` dará preferência à tabela `users`.

Observação: faça backup do banco antes de rodar os scripts.

Quick test (local)
1. Levante os containers: docker compose up -d
2. Rode os testes automáticos: powershell -NoProfile -ExecutionPolicy Bypass -File scripts/tests.ps1

Remoção do log temporário
- O arquivo `/tmp/cadastro_debug.log` é criado apenas para depuração local. Remova-o do container com: `docker exec -it nullbank-app rm /tmp/cadastro_debug.log` quando não for mais necessário.
