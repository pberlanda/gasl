<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();
include 'securityUtils.php';

// Verifica se l'utente è autenticato
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gasl";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Controllo della connessione
if (!$conn) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Operazione di creazione di un nuovo utente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    
    // password con hash
    $hashedPassword = generaHashedPassword($password);
    
    // debug: test funzionamento insert
    /*echo "utente da inserire ".$id;
    echo "comando SQL ".$sql;*/
    // Esegui la query di inserimento
    $sql = "INSERT INTO accounts (nome, cognome, username, password, email)
            VALUES ('$nome', '$cognome', '$username', '$password', '$email')";
    mysqli_query($conn, $sql);
}

// Operazione di eliminazione di un utente
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
        header('Location: error.php?message='.urldecode($error_message));
        exit;
    }
    
    // debug: test funzionamento delete
    /*echo "utente da aliminare ".$id;
    echo "comando SQL ".$sql;*/

    // Esegui la query di eliminazione
    $sql = "DELETE FROM accounts WHERE username='$id'";
    // debug. echo "comando SQL ".$sql;
    mysqli_query($conn, $sql);
}

// Query per selezionare tutti gli accounts
$sql = "SELECT * FROM accounts";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>App CRUD - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php require 'navbar.php';?>
    <div class="container">
        <h1 class="mt-4">App CRUD - Home</h1>

        <h2 class="mt-4">Aggiungi un nuovo utente:</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" id="nome">
            </div>
            <div class="form-group">
                <label for="cognome">Cognome:</label>
                <input type="text" class="form-control" name="cognome" id="cognome">
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Aggiungi</button>
        </form>

        <h2 class="mt-4">Elenco degli utenti:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Username</th>
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
                        echo "<td><a href='?delete=" . $row["username"] . "' class='btn btn-danger btn-sm'>Elimina</a></td>";
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
</body>
</html>

<?php
// Chiudi la connessione al database
mysqli_close($conn);
?>