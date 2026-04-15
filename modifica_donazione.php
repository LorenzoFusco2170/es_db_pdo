<?php
require "database.php";

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM donazioni WHERE id=?");
$stmt->execute([$id]);
$d = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE donazioni SET nome=?, email=?, importo=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST["nome"],
        $_POST["email"],
        $_POST["importo"],
        $id
    ]);
    header("Location: gestione_donazioni.php");
    exit;
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* ── header (uguale alle altre pagine) ── */
        header {
            background-color: #bb1e1e;
            color: white;
            padding: 24px 20px 20px;
            text-align: center;
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 6px;
        }

        header p {
            font-size: 1rem;
            opacity: 0.85;
        }

        /* ── layout centrato ── */
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
        }

        /* card form */
        .form-container {
            width: 100%;
            max-width: 500px;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            font-size: 1.15rem;
            color: #555;
            margin-bottom: 22px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        /* badge ID donazione */
        .form-container h2 span {
            background-color: #bb1e1e;
            color: white;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: 8px;
            vertical-align: middle;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 0.95rem;
            transition: border-color 0.2s ease;
        }

        .form-container input:focus {
            outline: none;
            border-color: #bb1e1e;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #bb1e1e;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #a01919;
        }

        /* bottone torna indietro */
        .home-button {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 24px;
            background-color: #bb1e1e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-button:hover { background-color: #a01919; }

        /*footer*/
        footer {
            background-color: #222;
            color: #ccc;
            text-align: center;
            padding: 37px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<header>
    <h1>Modifica Donazione</h1>
    <p>Modifica la donazione selezionata</p>
</header>

<main>
    <div class="form-container">
        <h2>Dati donazione <span>#<?= htmlspecialchars($d["id"]) ?></span></h2>

        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($d["nome"]) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($d["email"]) ?>" required>

            <label for="importo">Importo (€):</label>
            <input type="number" id="importo" name="importo" value="<?= htmlspecialchars($d["importo"]) ?>" required min="1" step="0.01">

            <button type="submit">Applica modifiche</button>
        </form>
    </div>

    <a href="gestione_donazioni.php" class="home-button">Torna all'elenco donazioni</a>
</main>

<footer>
    <p>&copy; 2026 Associazione Vita Libera</p>
</footer>

</body>
</html>