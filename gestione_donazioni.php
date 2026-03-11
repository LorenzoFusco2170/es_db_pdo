<?php

require_once "database.php";

$stmt = $pdo->query("SELECT * FROM donazioni");
$stmt->execute();

$donazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
<title>Gestione Donazioni</title>
</head>

<body>

<h1>Elenco Donazioni</h1>

<table border="1">

<tr>
<th>ID</th>
<th>Nome</th>
<th>Email</th>
<th>Importo</th>
<th>Azioni</th>
</tr>

<?php foreach($donazioni as $d){ ?>

<tr>

<td><?= $d["id"] ?></td>
<td><?= $d["nome"] ?></td>
<td><?= $d["email"] ?></td>
<td><?= $d["importo"] ?></td>

<td>

<a href="modifica_donazione.php?id=<?= $d["id"] ?>">Modifica</a>

|

<a href="elimina_donazione.php?id=<?= $d["id"] ?>">Elimina</a>

</td>

</tr>

<?php } ?>

</table>

<br>

<a href="dona.html">Torna alla pagina donazioni</a>

</body>
</html>