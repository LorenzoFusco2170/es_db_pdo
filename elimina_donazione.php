<?php

require "database.php";

$id = $_GET["id"];

$stmt = $pdo->prepare("DELETE FROM donazioni WHERE id=?");

$stmt->execute([$id]);

header("Location: gestione_donazioni.php");