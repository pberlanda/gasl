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
} else {
    echo "ciao, connesso al DB";
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Inserisci username e password!');
}

echo "<br>ecco i valori passati dal form". " username: ". $_POST["username"]." password: ".$_POST["password"]."<br>";

// ottieni i valori immessi dall'utente per username e password
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// usernmae e password devono essere immessi
if (!isset($username, $password)){
    exit('Inserisci nome utente e password '.$username." ".$password);
}

// verifica la validità del valore di username
if ($username !== null) {
    // verifica la validfità di username
    if (filter_var($username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9_]+$/")))) {
        // usernmae valido
        echo "username immesso " . $username;
    } else {
        echo "username non valido";
    }
}

// verifica che la password sia stata inviata correttamente
if ($password !== null) {
    // sanificazione password
    $sanitizedPassword = filter_var($password, FILTER_SANITIZE_STRING);
    
    // questa è la pwd sanificata
    echo "password saniificata " . $sanitizedPassword;
    
    // creazione hash della password
    $hashedPassword = password_hash($sanitizedPassword, PASSWORD_DEFAULT);
    
    // questo è l'hash della password
    echo "hash della password".$hashedPassword;
}