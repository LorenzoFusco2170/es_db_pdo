<?php
// SESSIONE
session_start();
require "database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dona.php");
    exit;
}

$nome    = trim($_POST["nome"]    ?? "");
$cognome = trim($_POST["cognome"] ?? "");
$email   = trim($_POST["email"]   ?? "");
$importo = $_POST["importo"] ?? "";
$data    = date("Y-m-d");

// validazione base
if ($nome === "" || $cognome === "" || $email === "" || $importo === "") {
    header("Location: dona.php");
    exit;
}

// CRUD OPERAZIONE CREATE
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

// SALVA DATI DONAZIONE IN SESSIONE
$_SESSION["ultima_donazione"] = [
    "nome"    => $nome,
    "cognome" => $cognome,
    "email"   => $email,
    "importo" => $importo,
    "data"    => $data
];

// INVIO EMAIL
$destinatario = "lorenzofusco483@gmail.com"; // metto email reale
$oggetto      = "Nuova donazione ricevuta - Vita Libera";
$corpo        = "Hai ricevuto una nuova donazione:\n\n"
              . "Nome:    $nome $cognome\n"
              . "Email:   $email\n"
              . "Importo: € $importo\n"
              . "Data:    $data\n\n"
              . "Accedi al pannello admin per gestire le donazioni.";
$headers      = "From: noreply@vitalibera.it\r\n"
              . "Reply-To: $email\r\n"
              . "Content-Type: text/plain; charset=UTF-8\r\n";

mail($destinatario, $oggetto, $corpo, $headers);

// redirezione alla pagina di conferma
header("Location: conferma.php");
exit;