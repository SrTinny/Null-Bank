## Testes com HttpClient (PowerShell)

Add-Type -AssemblyName System.Net.Http

function Get-Snippet($content, $len=300) {
    if (-not $content) { return "" }
    return $content.Substring(0,[math]::Min($len,$content.Length)) -replace "\r?\n"," "
}

$results = @()

function Do-GET-HttpClient($url) {
    $handler = New-Object System.Net.Http.HttpClientHandler
    $handler.AllowAutoRedirect = $true
    $handler.CookieContainer = New-Object System.Net.CookieContainer
    $client = New-Object System.Net.Http.HttpClient($handler)
    try {
        $resp = $client.GetAsync($url).Result
        $body = $resp.Content.ReadAsStringAsync().Result
        return @{ status = [int]$resp.StatusCode; snippet = Get-Snippet $body }
    } catch {
        return @{ error = $_.Exception.Message }
    } finally {
        $client.Dispose()
        $handler.Dispose()
    }
}

function Do-POST-HttpClient-Follow($url, $form) {
    $handler = New-Object System.Net.Http.HttpClientHandler
    $handler.AllowAutoRedirect = $false
    $handler.CookieContainer = New-Object System.Net.CookieContainer
    $client = New-Object System.Net.Http.HttpClient($handler)
    try {
        # Build form content as application/x-www-form-urlencoded string
        $pairs = @()
        foreach ($k in $form.Keys) {
            $encKey = [System.Uri]::EscapeDataString([string]$k)
            $encVal = [System.Uri]::EscapeDataString([string]$form[$k])
            $pairs += "$encKey=$encVal"
        }
        $bodyString = $pairs -join '&'
        $content = New-Object System.Net.Http.StringContent($bodyString, [System.Text.Encoding]::UTF8, 'application/x-www-form-urlencoded')

        $req = $client.PostAsync($url, $content).Result
        $status = [int]$req.StatusCode

        $location = $null
        if ($req.Headers.Location) { $location = $req.Headers.Location.OriginalString }

        $bodySnippet = ""
        # If 302 and Location present, follow with same handler (cookie container preserved)
        if ($status -ge 300 -and $status -lt 400 -and $location) {
            # normalize location to absolute
            if ($location.StartsWith("../")) { $location = $location -replace '^\.\./','' }
            if ($location.StartsWith('/')) { $followUrl = "http://localhost:8000" + $location } else { $followUrl = "http://localhost:8000/" + $location }
            $follow = $client.GetAsync($followUrl).Result
            $body = $follow.Content.ReadAsStringAsync().Result
            $bodySnippet = Get-Snippet $body
            return @{ status = $status; location = $location; snippet = $bodySnippet }
        }

        # Otherwise return body of request
        $body = $req.Content.ReadAsStringAsync().Result
        $bodySnippet = Get-Snippet $body
        return @{ status = $status; location = $location; snippet = $bodySnippet }
    } catch {
        return @{ error = $_.Exception.Message }
    } finally {
        $client.Dispose(); $handler.Dispose()
    }
}

# 1) GET index
$g = Do-GET-HttpClient 'http://localhost:8000/pages/index.php'
if ($g.error) { $results += "GET /pages/index.php: ERROR - $($g.error)" } else { $results += "GET /pages/index.php: $($g.status) | Snippet: $($g.snippet)" }

# 2) POST login gerente
$p1 = Do-POST-HttpClient-Follow 'http://localhost:8000/php/login.php' @{ matricula_cpf='1'; senha='senha123' }
if ($p1.error) { $results += "POST login (gerente): ERROR - $($p1.error)" } else { $results += "POST login (gerente): $($p1.status) -> $($p1.location) | Snippet: $($p1.snippet)" }

# 3) POST login cliente
$p2 = Do-POST-HttpClient-Follow 'http://localhost:8000/php/login.php' @{ matricula_cpf='carlos123'; senha='senha123' }
if ($p2.error) { $results += "POST login (cliente): ERROR - $($p2.error)" } else { $results += "POST login (cliente): $($p2.status) -> $($p2.location) | Snippet: $($p2.snippet)" }

# 4) GET cadastro page
$c = Do-GET-HttpClient 'http://localhost:8000/pages/cadastro.php'
if ($c.error) { $results += "GET /pages/cadastro.php: ERROR - $($c.error)" } else { $results += "GET /pages/cadastro.php: $($c.status) | Snippet: $($c.snippet)" }

# 5) DB check: count rows in possui (use bash -lc to avoid escaping issues)
try {
    $args = @('exec','-i','nullbank-db','mysql','-uroot','-ptinny123','-D','nullbank','-se',"SELECT COUNT(*) FROM possui;")
    $dbout = & docker @args
    $results += "DB possui count: " + $dbout.Trim()
} catch {
    $results += "DB check failed: " + $_.Exception.Message
}

# Print results
$results -join "`n"

# 6) Testar POST de cadastro (criar cliente de teste com CPF único)
try {
    # Gerar CPF de 11 dígitos aleatórios para teste (não é CPF válido, apenas 11 dígitos para caber na coluna)
    $rand = -join ((1..11) | ForEach-Object { Get-Random -Minimum 0 -Maximum 10 })
    $cpf = $rand
    $form = @{ cpf=$cpf; nome='Teste'; rg='0000000'; orgao_emissor='SSP'; uf='SP'; telefone='999999999'; tipo='Residencial'; endereco_nome='Rua Teste'; numero='1'; bairro='Centro'; cep='00000-000'; cidade='Cidade'; estado='SP'; enderecocol='Casa'; email="$cpf@test.local" }
    $p = Do-POST-HttpClient-Follow 'http://localhost:8000/pages/cadastro.php' $form
    if ($p.error) { $results += "POST cadastro: ERROR - $($p.error)" } else { $results += "POST cadastro: $($p.status) | Snippet: $($p.snippet)" }

    # verificar inserção no DB (usar bash -lc para escapar apropriadamente)
    $args = @('exec','-i','nullbank-db','mysql','-uroot','-ptinny123','-D','nullbank','-se',"SELECT COUNT(*) FROM cliente WHERE cpf = '$cpf';")
    $check = & docker @args
    $results += "DB cliente criado (cpf=$cpf) count: " + $check.Trim()
} catch {
    $results += "POST cadastro failed: " + $_.Exception.Message
}

# 6b) Testar cadastro duplicado: tentar criar o mesmo CPF novamente e verificar resposta de erro
try {
    $pDup = Do-POST-HttpClient-Follow 'http://localhost:8000/pages/cadastro.php' $form
    if ($pDup.error) { $results += "POST cadastro duplicate: ERROR - $($pDup.error)" } else { $results += "POST cadastro duplicate: $($pDup.status) | Snippet: $($pDup.snippet)" }
} catch {
    $results += "POST cadastro duplicate failed: " + $_.Exception.Message
}

# 7) Simular transação (INSERT direto) e verificar incremento
try {
    # contar transações atuais
    $args = @('exec','-i','nullbank-db','mysql','-uroot','-ptinny123','-D','nullbank','-se',"SELECT COUNT(*) FROM transacao;")
    $before = (& docker @args) | Out-String
    $before = $before.Trim()
    # inserir transação de depósito para conta 1001
    $insertArgs = @('exec','-i','nullbank-db','mysql','-uroot','-ptinny123','-D','nullbank','-se',"INSERT INTO transacao (tipo, data_hora, valor, conta_numero) VALUES ('deposito', NOW(), 123.45, 1001);")
    & docker @insertArgs
    $after = (& docker @args) | Out-String
    $after = $after.Trim()
    $results += "Transacao count before: $before, after: $after"
} catch {
    $results += "DB transacao failed: " + $_.Exception.Message
}

# Print final results with tests
$results -join "`n"
