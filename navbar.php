<?php

// trova l'utente corrente
$currentUsername = $_SESSION['id'];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="home.php">GASL</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

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

            <div class="navbar-nav ml-auto">
                <span class="navbar-text mr-3">
                    Benvenuto, <?php echo $currentUsername; ?>
                </span>
                <a class="btn btn-danger" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
