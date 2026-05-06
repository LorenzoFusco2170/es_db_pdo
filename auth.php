<?php
//da mettere in ogni pagina per agli admin

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["utente"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php?errore=accesso_negato");
    exit;
}