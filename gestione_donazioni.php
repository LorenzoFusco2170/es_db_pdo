<?php
require_once "database.php";

$stmt = $pdo->query("SELECT * FROM donazioni");
$stmt->execute();
$donazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Donazioni - Vita Libera</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /*reset e base*/
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /*header (come le altre pagine)*/
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

        /*contenuto principale*/
        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px 60px;
        }

        /*card che contiene tabella*/
        .table-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.10);
            overflow: hidden;
        }

        .table-card-header {
            background-color: #f0f0f0;
            padding: 16px 24px;
            border-bottom: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-card-header h2 {
            font-size: 1.1rem;
            color: #555;
        }

        .badge {
            background-color: #bb1e1e;
            color: white;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        /*tabella*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #bb1e1e;
            color: white;
        }

        thead th {
            padding: 14px 18px;
            text-align: left;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background-color 0.15s ease;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover { background-color: #fdf4f4; }

        tbody td {
            padding: 13px 18px;
            font-size: 0.95rem;
            color: #444;
        }

        /*colonna importo*/
        td.importo {
            font-weight: bold;
            color: #bb1e1e;
        }

        /*azioni*/
        .action-link {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .action-link.modifica {
            background-color: #e8a020;
            color: white;
            margin-right: 6px;
        }
        .action-link.modifica:hover { background-color: #c98a10; }

        .action-link.elimina {
            background-color: #bb1e1e;
            color: white;
        }
        .action-link.elimina:hover { background-color: #a01919; }

        /*messaggio tabella vuota*/
        .empty-msg {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }

        /*bottone torna indietro (stile uguale a home-button delle altre pagine)*/
        .home-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            background-color: #bb1e1e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-button:hover { background-color: #a01919; }

        /*footer (stile uguale alle altre pagine)*/
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
    <h1 id="test2">Gestione Donazioni</h1>
    <p>Elenco di tutte le donazioni ricevute</p>
</header>

<main>
    <div class="table-card">
        <div class="table-card-header">
            <h2>Donazioni registrate</h2>
            <span class="badge"><?= count($donazioni) ?> totale</span>
        </div>

        <?php if (count($donazioni) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Importo (€)</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donazioni as $d): ?>
                    <!--converte caratteri speciali e impedisce al browser di interpretare il testo come fosse uno script, garantisce sicurezza contro attacchi xss-->
                <tr>
                    <td>#<?= htmlspecialchars($d["id"]) ?></td>
                    <td><?= htmlspecialchars($d["nome"]) ?></td>
                    <td><?= htmlspecialchars($d["email"]) ?></td>
                    <td class="importo">€ <?= number_format((float)$d["importo"], 2, ',', '.') ?></td>
                    <td>
                        <!--richiama le pagine elimina e modifica_donazione e svolge il codice che contengono ogni volta che si preme il bottone-->
                        <a class="action-link modifica" href="modifica_donazione.php?id=<?= $d["id"] ?>">Modifica</a>
                        <a class="action-link elimina"  href="elimina_donazione.php?id=<?= $d["id"] ?>"
                           onclick="return confirm('Sei sicuro di voler eliminare questa donazione?')">Elimina</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="empty-msg">Nessuna donazione trovata.</p>
        <?php endif; ?>
    </div>

    <a href="dona.html" class="home-button">Torna alla pagina donazioni</a>
</main>

<footer>
    <p>&copy; 2026 Associazione Vita Libera</p>
</footer>

</body>
</html>