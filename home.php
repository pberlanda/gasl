<?php
session_start();
include './securityUtils.php';

// Verifica se l'utente è autenticato
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Ottieni il nome dell'utente corrente
$currentUsername = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <!-- Aggiungi le librerie di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require 'navbar.php';?>
    <!-- Contenuto principale della pagina -->
    <div class="container mt-4">
        <h1>Contenuto della Home Page</h1>
        <!-- Aggiungi il contenuto specifico della tua home page -->
    </div>

</body>
</html>
