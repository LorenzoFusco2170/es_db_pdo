<?php
// avvia la sessione per poterla poi eliminare
session_start();

// rimuove tutte le variabili salvate nella sessione
session_unset();

// distrugge completamente la sessione sul server
session_destroy();

// riporta l'utente alla home dopo il logout
header("Location: index.html");
exit;