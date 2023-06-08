<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

// Funzione per generare l'hash della password
function generaHashedPassword($password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
}

// Funzione per verificare la corrispondenza della password
function verificaPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// verifica se username già utilizzato
function verificaUsernameUtilizzato($conn, $username) {
    // esegue una query per verificare se esiste un utente con lo stesso username
    $sql = "SELECT * FROM accounts WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function visualizzaErrore($error_msg) {
    header('Location: error.php?message=' . urldecode($error_msg));
}
// TODO Altre funzioni? utente, santize ecc??? da fare
