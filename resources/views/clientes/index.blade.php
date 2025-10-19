<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clientes</title>
</head>
<body>
    <h1>Clientes</h1>
    @if(isset($clientes) && count($clientes))
        <ul>
        @foreach($clientes as $c)
            <li>{{ $c->nome }} ({{ $c->cpf }})</li>
        @endforeach
        </ul>
    @else
        <p>Nenhum cliente encontrado.</p>
    @endif
</body>
</html>
