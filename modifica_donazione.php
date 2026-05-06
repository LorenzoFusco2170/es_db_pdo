<?php
// LOGIN + SESSIONE
require_once "auth.php";
require "database.php";

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) { header("Location: gestione_donazioni.php"); exit; }

// CRUD OPERAZIONE READ
$stmt = $pdo->prepare("SELECT * FROM donazioni WHERE id = ?");
$stmt->execute([$id]);
$d = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$d) { header("Location: gestione_donazioni.php"); exit; }

$errore = "";

// CRUD OPERAZIONE UPDATE 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome    = trim($_POST["nome"]    ?? "");
    $cognome = trim($_POST["cognome"] ?? "");
    $email   = trim($_POST["email"]   ?? "");
    $importo = $_POST["importo"] ?? "";

    if ($nome === "" || $email === "" || $importo === "") {
        $errore = "Compila tutti i campi obbligatori.";
    } else {
        $stmt = $pdo->prepare("UPDATE donazioni SET nome=?, cognome=?, email=?, importo=? WHERE id=?");
        $stmt->execute([$nome, $cognome, $email, $importo, $id]);
        header("Location: gestione_donazioni.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Donazione - Vita Libera</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }

        .admin-bar { background:#222; color:#eee; text-align:center; padding:10px; font-size:.9rem; }
        .admin-bar a { color:#ff9999; font-weight:bold; text-decoration:none; margin:0 10px; }
        .admin-bar a:hover { text-decoration:underline; }

        header { background-color:#bb1e1e; color:white; padding:24px 20px 20px; text-align:center; }
        header h1 { font-size:2rem; margin-bottom:6px; }
        header p  { opacity:.85; }

        main { display:flex; flex-direction:column; align-items:center; padding:40px 20px 60px; }

        .form-container { width:100%; max-width:500px; background:#f9f9f9; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,.1); }

        .form-container h2 { font-size:1.1rem; color:#555; margin-bottom:22px; padding-bottom:10px; border-bottom:2px solid #e0e0e0; }
        .form-container h2 span { background-color:#bb1e1e; color:white; border-radius:20px; padding:3px 10px; font-size:.8rem; font-weight:bold; margin-left:8px; vertical-align:middle; }

        .form-container label { display:block; font-weight:bold; font-size:.9rem; color:#555; margin-bottom:5px; }
        .form-container input { width:100%; padding:10px; margin-bottom:18px; border-radius:5px; border:1px solid #ccc; font-size:.95rem; box-sizing:border-box; }
        .form-container input:focus { outline:none; border-color:#bb1e1e; }
        .form-container button { width:100%; padding:12px; background-color:#bb1e1e; color:white; border:none; border-radius:5px; font-size:1rem; font-weight:bold; cursor:pointer; transition:background-color .3s; }
        .form-container button:hover { background-color:#a01919; }

        .errore { background:#fdecea; border-left:4px solid #bb1e1e; color:#c0392b; padding:10px 14px; border-radius:5px; margin-bottom:18px; font-size:.9rem; }

        .home-button { display:inline-block; margin-top:24px; padding:12px 24px; background-color:#bb1e1e; color:white; text-decoration:none; border-radius:5px; font-weight:bold; transition:background-color .3s; }
        .home-button:hover { background-color:#a01919; }

        footer { background-color:#222; color:#ccc; text-align:center; padding:20px; font-size:.9rem; }
    </style>
</head>
<body>

<div class="admin-bar">
    👤 <strong><?= htmlspecialchars($_SESSION["nome"]) ?></strong> (admin) &nbsp;|&nbsp;
    <a href="gestione_donazioni.php"> Gestisci Donazioni</a>
    <a href="logout.php"> Logout</a>
</div>

<header>
    <h1>Modifica Donazione</h1>
    <p>Aggiorna i dati della donazione selezionata</p>
</header>

<main>
    <div class="form-container">
        <h2>Dati donazione <span>#<?= htmlspecialchars($d["id"]) ?></span></h2>

        <?php if ($errore): ?>
            <div class="errore"> <?= htmlspecialchars($errore) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="nome">Nome: *</label>
            <input type="text" id="nome" name="nome"
                   value="<?= htmlspecialchars($_POST["nome"] ?? $d["nome"]) ?>" required>

            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome"
                   value="<?= htmlspecialchars($_POST["cognome"] ?? ($d["cognome"] ?? "")) ?>">

            <label for="email">Email: *</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST["email"] ?? $d["email"]) ?>" required>

            <label for="importo">Importo (€): *</label>
            <input type="number" id="importo" name="importo"
                   value="<?= htmlspecialchars($_POST["importo"] ?? $d["importo"]) ?>"
                   required min="1" step="0.01">

            <button type="submit">💾 Salva modifiche</button>
        </form>
    </div>

    <a href="gestione_donazioni.php" class="home-button">← Torna all'elenco</a>
</main>

<footer>
    <p>&copy; 2026 Associazione Vita Libera</p>
</footer>
</body>
</html>