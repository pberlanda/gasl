<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();
include 'securityUtils.php';

// Funzione per verificare le credenziali dell'utente
function verifyCredentials($username, $password) {
    // Esempio di verifica delle credenziali nel database
    // Connessione al database
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "gasl";

    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }
    
    // recupera l'hash della password memorizzata
    //$passwordMemorizzata = password_hash($password, PASSWORD_DEFAULT);

    // Esegue una query per ottenere l'utente corrispondente alle credenziali
    $query = "SELECT * FROM accounts WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Verifica se l'utente esiste nel database
    if (mysqli_num_rows($result) > 0) {
        return true; // Credenziali corrette
    } else {
        return false; // Credenziali errate
    }

    // Chiude la connessione al database
    mysqli_close($conn);
}

// Verifica se l'utente è già autenticato
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: home.php');
    exit;
}

// Verifica le credenziali dell'utente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //$username = $_POST['username'];
    //$password = $_POST['password'];
    // ottengo username e password in sicurezza
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Verifica le credenziali
    if (verifyCredentials($username, $password)) {
        // Autentica l'utente
        $_SESSION['logged_in'] = true;
        
        // Salva le informazioni dell'utente nella sessione
        // mantengo la dicitura id, al posto di username, per sicurezza. Evito di fare sapere che id si riferisce a username
        $_SESSION['id'] = $username;
        
        header('Location: home.php');
        exit;
    } else {
        $error_message = 'Credenziali non valide. Riprova.';
        header('Location: error.php?message='.urlencode($error_message));
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GASL Gestione Alternanza Scuola Lavoro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">App CRUD - Login</h1>

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="username">Nome utente:</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Accedi</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
