<?php
// Connessione al database
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gasl";

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