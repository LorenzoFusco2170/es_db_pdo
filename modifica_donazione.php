<?php

require "database.php";

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM donazioni WHERE id=?");
$stmt->execute([$id]);

$d = $stmt->fetch();

if($_SERVER["REQUEST_METHOD"]=="POST"){

$sql="UPDATE donazioni
SET nome=?, email=?, importo=?
WHERE id=?";

$stmt=$pdo->prepare($sql);

$stmt->execute([
$_POST["nome"],
$_POST["email"],
$_POST["importo"],
$id
]);

header("Location: gestione_donazioni.php");

}

?>

<h2>Modifica Donazione</h2>

<form method="POST">

Nome
<input name="nome" value="<?= $d["nome"] ?>">

Email
<input name="email" value="<?= $d["email"] ?>">

Importo
<input name="importo" value="<?= $d["importo"] ?>">

<button type="submit">Salva</button>

</form>