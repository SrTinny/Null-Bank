<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contas</title>
</head>
<body>
    <h1>Contas</h1>
    @if(isset($contas) && count($contas))
        <ul>
        @foreach($contas as $c)
            <li>Conta {{ $c->numero }} - Saldo: R$ {{ $c->saldo }}</li>
        @endforeach
        </ul>
    @else
        <p>Nenhuma conta encontrada.</p>
    @endif
</body>
</html>
