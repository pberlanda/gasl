<?php

// trova l'utente corrente
$currentUsername = $_SESSION['id'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="home.php">GASL: Gestione Alternanza Scuola Lavoro</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="accounts.php">Utenti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pagina2.php">Pagina 2</a>
                </li>
                <!-- Aggiungi altre voci di menu per le tue pagine -->
            </ul>
        </div>

        <div class="navbar-nav ml-auto">
            <span class="navbar-text mr-3">
                Benvenuto, <?php echo $currentUsername; ?>
            </span>
            <a class="btn btn-danger" href="logout.php">Logout</a>
        </div>
    </div>
</nav>
