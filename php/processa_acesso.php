<?php
    session_start();

    if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] == 'nao'){
        header('Location: ../pages/index.php?autenticaco=erro');
    }
?>