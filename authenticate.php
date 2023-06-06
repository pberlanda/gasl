<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

session_start();

$DB_HOST = 'localhost';
$DB_USR = 'root';
$DB_PWD = '';
$DB_NAME = 'gasl';

$con = mysqli_connect($DB_HOST, $DB_USR,  $DB_PWD, $DB_NAME);

if (mysqli_connect_errno()){
    exit('connessione fallita al db'.mysqli_connect_errno());
}

/*if (!isset($_POST['username'], $_POST['password'])) {
    exit('Inserisci username e password!');
}*/

// test
//echo "<br>ecco i valori passati dal form". " username: ". $_POST["username"]." password: ".$_POST["password"]."<br>";

// ottieni i valori immessi dall'utente per username e password
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// test
//echo "<br>ecco i valori sanitizzati passati dal form". " username: ". $username." password: ".$password."<br>";

// username e password devono essere immessi
if (!isset($username, $password)){
    //exit('Inserisci nome utente e password '.$username." ".$password);
}

// verifica la validità del valore di username
if ($username !== null) {
    // verifica la validfità di username
    if (filter_var($username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9_]+$/")))) {
        // usernmae valido
        //echo "username immesso: " . $username;
    } else {
        //echo "username non valido";
    }
}

// verifica che la password sia stata inviata correttamente
if ($password !== null) {
    // sanificazione password
    $sanitizedPassword = filter_var($password, FILTER_SANITIZE_STRING);
    
    // test: questa è la pwd sanificata
    //echo "<br>password sanificata: " . $sanitizedPassword;
    
    // creazione hash della password
    $hashedPassword = password_hash($sanitizedPassword, PASSWORD_DEFAULT);
    
    // test: questo è l'hash della password
    //echo "<br>hash della password: ".$hashedPassword;
}
// controllo se esiste un account con il nome utente immesso. Controllo che la password sia corretta
if ($stmt = $con->prepare('SELECT username, password FROM accounts WHERE username = ?')) {
    
    //echo "<br>questo è il valore di username che sto verificando ".$username;
    
    // bind dei parametri (s per stirng, i per int b per blob)
    // esegue la query
    // salva i risultati
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    
    // se ci sono righe nel result set l'account esiste
    // in caso di errore punta alla pagina dedicata
    if ($stmt->num_rows()>0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        
        // controllo della password
        if (password_verify($password, $hashedPassword)) {
            
            // password verificata.
            //echo "<br>password verificata!";
            
            //Ora rigenro la sessione e aggiorno e variabili di sessione
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;
            // qui punta alla pagina principale
            header('Location: home.php');
        } else {
            header("Location: error.php");
            exit();
        }
    }
}

// ok abbiamo finito, chiudo la connessione al db
$con->close();