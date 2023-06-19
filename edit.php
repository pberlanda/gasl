<?php
session_start();
include 'securityUtils.php';

// gestione errori
// anzichè usare la funzione in secirityYtils che reindirizza alla pagna error.php dedicata,
// visualizzo un msg nella pagina
$error = "";

// Verifica se l'utente è autenticato
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Connessione al database
$servername = "localhost";
$dbusername = "root";
$password = "";
$dbname = "gasl";

$conn = mysqli_connect($servername, $dbusername, $password, $dbname);

// Controllo della connessione
if (!$conn) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Recupera l'ID dell'utente dalla query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // ID non fornito, reindirizza alla pagina degli utenti
    header('Location: accounts.php');
    exit;
}

// Esegui la modifica dell'utente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Recupera i dati del modulo di modifica
//    $nome = $_POST["nome"];
//    $cognome = $_POST["cognome"];
//    $username = $_POST["username"];
//    $email = $_POST["email"];

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $cognome = filter_input(INPUT_POST, 'cognome', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    //$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); per ora non modifico la password... TODO procedura reset password
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $tel1 = filter_input(INPUT_POST, 'tel1', FILTER_SANITIZE_STRING);
    $tel2 = filter_input(INPUT_POST, 'tel2', FILTER_SANITIZE_STRING);
    
    // verifica se username è già stato utilizzato
//    if (verificaUsernameUtilizzato($conn, $username)) {
//        $error_message = "Il nome utente $username è già utilizzato!";
//        visualizzaErrore($error_message);
//        exit;
//    }

    // Esegui l'aggiornamento dell'utente nel database
    $sql = "UPDATE accounts SET nome='$nome', cognome='$cognome', username='$username', email='$email', telefono_1='$tel1', telefono_2='$tel2' WHERE username='$id'";
    mysqli_query($conn, $sql);

    // Reindirizza alla pagina degli utenti dopo l'aggiornamento
    header('Location: accounts.php');
    exit;
}

// Query per selezionare l'utente da modificare
$sql = "SELECT * FROM accounts WHERE username='$id'";
$result = mysqli_query($conn, $sql);

// Verifica se l'utente esiste nel database
if (mysqli_num_rows($result) == 0) {
    // Utente non trovato, reindirizza alla pagina degli utenti
    header('Location: accounts.php');
    exit;
}

// Recupera i dati dell'utente
$row = mysqli_fetch_assoc($result);
$nome = $row["nome"];
$cognome = $row["cognome"];
$username = $row["username"];
$email = $row["email"];
$tel1 = $row["telefono_1"];
$tel2 = $row["telefono_2"];
?>

<!-- HTML per la pagina di modifica dell'utente -->
<!DOCTYPE html>
<html>
<head>
    <title>Modifica utente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php require 'navbar.php'; ?>
    <div class="container">
        <h1 class="mt-4">Modifica utente</h1>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] . '?id=' . $id; ?>" class="mb-4">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cognome">Cognome:</label>
                        <input type="text" class="form-control" name="cognome" id="cognome" value="<?php echo $cognome; ?>" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-8">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="tel1">Tel.</label>
                        <input type="tel" class="form-control" name="tel1" id="tel1" value="<?php echo $tel1;?>">
                    </div>
                    <div class="col-md-2">
                        <label for="tel2">Tel.</label>
                        <input type="tel" class="form-control" name="tel2" id="tel2" value="<?php echo $tel2;?>">
                    </div>
                </div>
                
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Salva modifiche</button>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Chiudi la connessione al database
mysqli_close($conn);
?>
