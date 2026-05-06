<?php
// avvia la sessione per poter salvare i dati della donazione e passarli a conferma.php
session_start();
require "database.php";

// se qualcuno arriva su questa pagina senza aver inviato il form, lo rimandiamo indietro
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dona.php");
    exit;
}

// legge e pulisce i dati inviati dal form
$nome    = trim($_POST["nome"]    ?? "");
$cognome = trim($_POST["cognome"] ?? "");
$email   = trim($_POST["email"]   ?? "");
$importo = $_POST["importo"] ?? "";

// la data viene generata automaticamente dal server nel momento dell'invio
$data = date("Y-m-d");

// controlla che nessun campo obbligatorio sia vuoto
if ($nome === "" || $cognome === "" || $email === "" || $importo === "") {
    header("Location: dona.php");
    exit;
}

// inserisce la nuova donazione nel database usando una query preparata
// le query preparate proteggono da attacchi sql injection
$sql  = "INSERT INTO donazioni (nome, cognome, email, importo, data)
         VALUES (:nome, :cognome, :email, :importo, :data)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":nome"    => $nome,
    ":cognome" => $cognome,
    ":email"   => $email,
    ":importo" => $importo,
    ":data"    => $data
]);

// salva i dati della donazione nella sessione per mostrarli nella pagina di conferma
// questo evita di dover rifare una query al database solo per mostrare il riepilogo
$_SESSION["ultima_donazione"] = [
    "nome"    => $nome,
    "cognome" => $cognome,
    "email"   => $email,
    "importo" => $importo,
    "data"    => $data
];

// invia una email di notifica all'amministratore con i dati della donazione ricevuta
$destinatario = "email@example.com"; // sostituire con l'email reale dell'amministratore
$oggetto      = "Nuova donazione ricevuta - Vita Libera";
$corpo        = "Hai ricevuto una nuova donazione:\n\n"
              . "Nome:    $nome $cognome\n"
              . "Email:   $email\n"
              . "Importo: € $importo\n"
              . "Data:    $data\n\n"
              . "Accedi al pannello admin per gestire le donazioni.";

// intestazioni email: mittente e tipo di contenuto
$headers = "From: noreply@vitalibera.it\r\n"
         . "Reply-To: $email\r\n"
         . "Content-Type: text/plain; charset=UTF-8\r\n";

mail($destinatario, $oggetto, $corpo, $headers);

// reindirizza alla pagina di conferma che leggerà i dati dalla sessione
header("Location: conferma.php");
exit;