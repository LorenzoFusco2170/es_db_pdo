<?php
// questo file va incluso all'inizio di ogni pagina accessibile solo agli admin.
// controlla se la sessione è attiva e se l'utente ha il ruolo "admin".
// se non è loggato o non è admin, lo manda alla pagina di login.

if (session_status() === PHP_SESSION_NONE) {
    // avvia la sessione solo se non è già stata avviata
    session_start();
}

// verifica che la variabile di sessione esista e che il ruolo sia admin
if (!isset($_SESSION["utente"]) || $_SESSION["ruolo"] !== "admin") {
    // reindirizza al login con un parametro che spiega il motivo
    header("Location: login.php?errore=accesso_negato");
    exit;
}