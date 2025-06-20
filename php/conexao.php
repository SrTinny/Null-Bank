<?php
$conexao = mysqli_connect("localhost", "root", "tinny123", "trabalhobd-2023_2-416855");

//checar conexão
if (!$conexao) {
    echo "" . mysqli_connect_error();
}
//echo "<h1> Conexão efetuada com sucesso!!</h1>";

mysqli_close($conexao);
