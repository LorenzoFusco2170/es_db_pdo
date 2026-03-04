<?php
    //LO SCRIPT è GIUSTO MA SU ONLINE GDB NON FA METTERE 2 LINGUAGGI (HTML E PHP) NELLO STESSO PROGETTO


    //file di connessione al database
    //indirizzo del server dove si trova il database
    $host = "localhost";

    //nome del database da utilizzare
    $dbname = "email_informatica";

    //username per accedere
    $user = "root";

    //password per accedere
    $pass = "";

    //try/catch per gestire eventuali errori di connessione
    try {
        //crea l'oggetto PDO per la connessione al db
        //specifica host e nome del db
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $user,
            $pass
        );

        //try catch per gestione errori
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        //in caso di errore viene mostrato il messaggio con die
        die("Errore di connessione al database: " . $e->getMessage());
    }
?>