<?php
// LOGIN + SESSIONE 
require_once "auth.php";
require "database.php";

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) { header("Location: gestione_donazioni.php"); exit; }

// CRUD OPERAZIONE DELETE 
$stmt = $pdo->prepare("DELETE FROM donazioni WHERE id = ?");
$stmt->execute([$id]);

header("Location: gestione_donazioni.php");
exit;