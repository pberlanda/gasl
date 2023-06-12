<?php
// carica i parametri di connessione dal file XML
$config = simplexml_load_file('config.xml');

$servername = $config->database->dbhost;
$dbusername = $config->database->dbusername;
$dbpassword = $config->database->dbpassword;
$dbname = $config->database->dbname;

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

// Controllo della connessione
if (!$conn) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Controlla se l'email è stata registrata da un alro utente
$username = $_GET["username"];
$email = $_GET["email"];
// esegue la query: cerca un utente iverso da quello corrente con la stessa email
//$sql = "SELECT * FROM accounts WHERE username<>'$username' AND email= '$email'";
$sql = "SELECT * FROM accounts WHERE email= '$email'";
$result = mysqli_query($conn, $sql);

$response = array();
if (mysqli_num_rows($result) > 0) {
    $response["available"] = false; // email non è disponibile
} else {
    $response["available"] = true; // email è disponibile
}

echo json_encode($response);
?>