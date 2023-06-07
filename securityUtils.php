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

// TODO Altre funzioni? utente, santize ecc??? da fare
