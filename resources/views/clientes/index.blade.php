<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Null-Bank — Clientes</title>
    <link rel="icon" type="image/svg+xml" href="/imagens/favicon.svg">
    <link rel="stylesheet" href="/estilos/styles.css">
</head>
<body>
    <header class="nb-header">
        <div class="container nb-header-inner">
            <a class="nb-brand" href="/pages/index.php">
                <img src="/imagens/logo.svg" alt="Null-Bank" class="nb-logo" height="36">
                <span class="nb-title">Null-Bank</span>
            </a>
            <nav class="nb-nav">
                <a href="/pages/index.php">Início</a>
                <a href="/pages/cadastro.php">Cadastrar</a>
                <a href="/pages/cliente.php">Minha Conta</a>
                <a href="/pages/gerente.php">Gerente</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1 class="page-title">Clientes</h1>

        @if(isset($clientes) && $clientes->count())
            <ul class="clientes-list">
            @foreach($clientes as $c)
                <li class="cliente-item">
                    <div class="cliente-nome">{{ $c->nome }}</div>
                    <div class="cliente-meta">CPF: <span class="cpf">{{ $c->cpf }}</span></div>
                </li>
            @endforeach
            </ul>
            <div class="pagination">
                {{ $clientes->links() }}
            </div>
        @else
            <p class="muted">Nenhum cliente encontrado.</p>
        @endif
    </main>

</body>
</html>
