# Null-Bank

Null-Bank é um projeto didático de um sistema bancário (PHP + MySQL). O repositório contém o frontend/server em PHP procedural (páginas em `pages/` e handlers em `php/`) e scripts auxiliares para migração, além de um scaffold inicial para migração futura para Laravel.

## Estrutura principal

- `pages/` — páginas PHP/HTML do frontend
- `php/` — handlers e scripts PHP (login, migração de senhas, helpers)
- `modelagem/` — esquema SQL e povoamento
- `docker-compose.yml` e `docker/` — ambiente Docker para app + MySQL

## Como rodar (recomendado: Docker)

1. Abra PowerShell no diretório do projeto (onde está `docker-compose.yml`).
2. Construir imagens e subir containers:

```powershell
docker compose build
docker compose up -d
```

3. Verifique os containers:

```powershell
docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
```

4. Acesse a aplicação no navegador: `http://localhost:8000/pages/index.php`

5. O MySQL está mapeado para a porta `3307` do host. Exemplo de conexão via cliente MySQL:

```powershell
mysql -h 127.0.0.1 -P 3307 -u root -p
# senha: tinny123
USE nullbank;
SHOW TABLES;
```

## Credenciais de teste

- Funcionário (Gerente): matrícula `1` / senha `senha123`  → redireciona para `/pages/gerente.php`
- Cliente: login `carlos123` / senha `senha123` → redireciona para `/pages/cliente.php`

> Observação: as senhas podem ter sido migradas para hashes; os scripts de migração estão incluídos e as credenciais acima foram verificadas neste ambiente.

## Scripts úteis

- `php/migrate_passwords.php` — re-hash em `funcionario` (texto → hash)
- `php/migrate_funcionarios_to_users.php` — migra funcionários para `users`
- `php/migrate_possui_passwords.php` — re-hash em `possui` (clientes)

Executar dentro do container da app:

```powershell
docker exec -u root nullbank-app bash -lc "php php/migrate_possui_passwords.php"
```

## Notas de segurança

- Use `password_hash`/`password_verify` para todas as senhas (já aplicado nos handlers principais).
- Não coloque arquivos de backup ou `vendor/` no repositório público (já adicionado `.gitignore`).
- Em produção, habilite HTTPS, limite de tentativas de login e monitore logs de autenticação.

## Próximos passos

- Consolidar autenticação em uma tabela `users` única e migrar os logins legados.
- Reimplementar triggers com testes (originalmente removidos por incompatibilidades no SQL importado).
- Migrar o projeto para Laravel se desejar usar migrations/seeders e um fluxo mais moderno.


