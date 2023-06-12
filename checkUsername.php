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

// Controlla se l'username esiste già nel database
$username = $_GET["username"];
$sql = "SELECT * FROM accounts WHERE username='$username'";
$result = mysqli_query($conn, $sql);

$response = array();
if (mysqli_num_rows($result) > 0) {
    $response["available"] = false; // L'username non è disponibile
} else {
    $response["available"] = true; // L'username è disponibile
}

echo json_encode($response);
?>