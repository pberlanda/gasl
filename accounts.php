<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();
include 'securityUtils.php';

$action = htmlspecialchars($_SESSION['logged_in']);

//echo var_dump('ciao '.$action);
//echo "<script>console.log('$action')</script>";

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

// Creazione di un nuovo utente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
//    $nome = $_POST["nome"];
//    $cognome = $_POST["cognome"];
//    $username = $_POST["username"];
//    $password = $_POST["password"];
//    $email = $_POST["email"];
    
    //ottengo i dati da memorizzare
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $cognome = filter_input(INPUT_POST, 'cognome', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $tel1 = filter_input(INPUT_POST, '$tel1', FILTER_SANITIZE_STRING);
    $tel2 = filter_input(INPUT_POST, '$tel2', FILTER_SANITIZE_STRING);
    
    // controlla se lo username è già stato usato da un altro utente
    if (verificaUsernameUtilizzato($conn, $username)) {
        $error_message = "Lo username $username è già stato utilizzato!<br>Scegli un altro username";
        visualizzaErrore($error_message);
        exit;
    }
    
    // password con hash
    $hashedPassword = generaHashedPassword($password);
    
    // debug: test funzionamento insert
    /*echo "utente da inserire ".$id;
    echo "comando SQL ".$sql;*/
    // Esegui la query di inserimento
    $sql = "INSERT INTO accounts (nome, cognome, username, password, email, telefono_1, telefono_2)
            VALUES ('$nome', '$cognome', '$username', '$password', '$email', '$tel1', '$tel2')";
    mysqli_query($conn, $sql);
}

// Eliminazione di un utente
if (isset($_GET["delete"])) {
    // id dell'utente da eliminare
    $id = $_GET["delete"];
    
    // ottengo l'id dell'utente autenticato
    $loggedinUser = $_SESSION['id'];
    //echo "utente corrente ".$loggedinUser." utente da eliminare ".$id;
    
    // l'utente non può eliminare se stesso
    if ($id === $loggedinUser) {
        // l'utente sta cercando di eliminare se stesso. Gestisco l'errore con la pagina errori
        $error_message = "Non è possibile eliminare il proprio utente";
        //header('Location: error.php?message='.urldecode($error_message));
        visualizzaErrore($error_message);
        exit;
    }
    
    // Esegui la query di eliminazione
    $sql = "DELETE FROM accounts WHERE username='$id'";
    // debug. echo "comando SQL ".$sql;
    mysqli_query($conn, $sql);
}

// impostazioni per ordinamento
$order = isset($_GET['order']) ? $_GET['order'] : 'username'; // Ordina per username per impostazione predefinita
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'asc'; // Ordinamento ascendente per impostazione predefinita

// Query per selezionare tutti gli account con l'ordinamento desiderato
$sql = "SELECT * FROM accounts ORDER BY " . $order . " " . $direction;
//$sql = "SELECT * FROM accounts";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>GASL gestione utenti</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php require 'navbar.php';?>
    <div class="container mt-4">
        <h1 class="mt-4">Gestione utenti</h1>
        <h2 class="mt-4">Aggiungi un nuovo utente:</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cognome">Cognome:</label>
                        <input type="text" class="form-control" name="cognome" id="cognome" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" required onkeyup="verificaDisponibilitaUsername()"> <!-- verifica che il nome utente sia disponibile -->
                        <span id="username-error" class="text-danger"></span>
                    </div>
                    <div class="col-md-8">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" required onkeyup="verificaDisponibilitaEmail()"> <!-- verifica che l'email non sia già stata utilizzata -->
                        <span id="email-error" class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="tel1">Tel.:</label>
                        <input type="tel" class="form-control" name="tel1" id="tel1">
                    </div>
                    <div class="col-md-6">
                        <label for="tel2">Tel.:</label>
                        <input type="tel" class="form-control" name="tel2" id="tel2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" autocomplete="current-password" required>
                    </div>
                    <div class="col-md-8">
                        <label for="note">Note:</label>
                        <input type="text" class="form-control" name="note" id="note">
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Aggiungi</button>
        </form>

        <h2 class="mt-4">Elenco degli utenti:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <!--<th>Username</th>-->
                    <th>Username <a href="?order=username&amp;direction=asc">&uarr;</a> <a href="?order=username&amp;direction=desc">&darr;</a></th>
                    <th>Email</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Visualizza i dati degli utenti nella tabella
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . $row["cognome"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        // la riga commentata ha elimina. Sostituita da td contentente modifica ed elimina
//                      // echo "<td><a href='edit.php?id=" . $row["username"]. "' class='btn btn-primary btn-sm'>Modifica</a></td>";
                        echo "<td>";
                        echo "<a href='edit.php?id=" . $row["username"]. "' class='btn btn-primary btn-sm'>Modifica</a> <a href='?delete=" . $row["username"] . "' class='btn btn-danger btn-sm'>Elimina</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nessun utente trovato.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="controlli.js"></script>
</body>
</html>

<?php
// Chiudi la connessione al database
mysqli_close($conn);
?>