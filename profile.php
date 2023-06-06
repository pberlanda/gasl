<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

session_start();

// se l'utente non è loggato lo mando alla pagina di login

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}