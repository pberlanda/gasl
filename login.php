<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();
include 'securityUtils.php';

// gestione errori: se le credenziali sono errate visualizza un messaggio di errore nel form
$error_message = "";

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

    // Verifica le credenziali: se corretta passa a home.php e chiude
    // altrimenti rimane nel form di logi ma mostra un errore
    if (verifyCredentials($username, $password)) {
        // Autentica l'utente
        $_SESSION['logged_in'] = true;
        
        // Salva le informazioni dell'utente nella sessione
        // mantengo la dicitura id, al posto di username, per sicurezza. Evito di fare sapere che id si riferisce a username
        $_SESSION['id'] = $username;
        
        header('Location: home.php');
        exit;
    } else {
        $error_message = "username o password non corretti";
        //header('Location: error.php?message='.urlencode($error_message));
        //visualizzaErrore($error_message);
        //exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GASL Gestione Alternanza Scuola Lavoro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #eaeae1;
        }
        .login-form {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #ffffff
        }
    </style>
</head>
<body>    
      <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <form class="login-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <!-- Aggiungi i campi del form -->
                    <div class="form-group">
                        <h1 class="text-center">GASL</h1>
                        <h3 class="text-center">Gestione Alternanza Scuola Lavoro</h3>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                    </div>
                    <?php if (!$error_message == "") : ?>
                    <div  id="error_message" class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Aggiungi le librerie JavaScript di Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <!-- fa sparire il messaggio di errore dopo qualche secondo -->
    <script>
        // trovo il riferimento al messaggio di errore
        var errorMessage = document.getElementById("error_message");
        
        // il messaggio scompare in dissolvenza dopo 5 secondi
        setTimeout(function() {
            errorMessage.style.opacity='0';
            errorMessage.style.height='0';
            errorMessage.style.padding='0';
        }, 5000);
    </script>
</body>
</html>
