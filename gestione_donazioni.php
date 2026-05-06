<?php
// include il file che controlla se l'utente è loggato come admin
// se non lo è, viene rimandato automaticamente al login
require_once "auth.php";
require_once "database.php";

// recupera tutte le donazioni dal database ordinate dalla più recente
$stmt = $pdo->query("SELECT * FROM donazioni ORDER BY id DESC");
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
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }

        .admin-bar { background:#222; color:#eee; text-align:center; padding:10px; font-size:.9rem; }
        .admin-bar a { color:#ff9999; font-weight:bold; text-decoration:none; margin:0 10px; }
        .admin-bar a:hover { text-decoration:underline; }

        header { background-color: #bb1e1e; color: white; padding: 24px 20px 20px; text-align: center; }
        header h1 { font-size: 2rem; margin-bottom: 6px; color: white; }
        header p  { opacity: .85; color: white; }

        main { max-width: 960px; margin: 40px auto; padding: 0 20px 60px; }

        .table-card { background:#fff; border-radius:10px; box-shadow:0 4px 16px rgba(0,0,0,.10); overflow:hidden; }

        .table-card-header {
            background:#f0f0f0;
            padding:16px 24px;
            border-bottom:2px solid #ddd;
            display:flex;
            align-items:center;
            justify-content:space-between;
        }
        .table-card-header h2 { font-size:1.1rem; color:#555; }
        .badge { background-color:#bb1e1e; color:white; border-radius:20px; padding:4px 12px; font-size:.85rem; font-weight:bold; }

        table { width:100%; border-collapse:collapse; }
        thead tr { background-color:#bb1e1e; color:white; }
        thead th { padding:14px 18px; text-align:left; font-size:.85rem; letter-spacing:.05em; text-transform:uppercase; }

        tbody tr { border-bottom:1px solid #eee; transition:background-color .15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background-color:#fdf4f4; }
        tbody td { padding:13px 18px; font-size:.95rem; color:#444; }
        td.importo { font-weight:bold; color:#bb1e1e; }

        .action-link { display:inline-block; padding:5px 12px; border-radius:4px; font-size:.82rem; font-weight:bold; text-decoration:none; transition:background-color .2s; }
        .action-link.modifica { background-color:#e8a020; color:white; margin-right:6px; }
        .action-link.modifica:hover { background-color:#c98a10; }
        .action-link.elimina  { background-color:#bb1e1e; color:white; }
        .action-link.elimina:hover  { background-color:#a01919; }

        .empty-msg { text-align:center; padding:40px; color:#999; font-style:italic; }

        .totale-bar { background:#fff8f8; border-top:2px solid #eee; padding:14px 24px; text-align:right; font-size:1rem; color:#555; }
        .totale-bar strong { color:#bb1e1e; font-size:1.1rem; }

        .home-button { display:inline-block; margin-top:30px; padding:12px 24px; background-color:#bb1e1e; color:white; text-decoration:none; border-radius:5px; font-weight:bold; transition:background-color .3s; }
        .home-button:hover { background-color:#a01919; }

        footer { background-color:#222; color:#ccc; text-align:center; padding:20px; font-size:.9rem; }
    </style>
</head>
<body>

<!-- barra admin: mostra il nome dell'utente loggato letto dalla sessione -->
<div class="admin-bar">
    👤 Sei loggato come <strong><?= htmlspecialchars($_SESSION["nome"]) ?></strong> (<?= htmlspecialchars($_SESSION["ruolo"]) ?>)
    &nbsp;|&nbsp;
    <a href="dona.php"> Pagina Donazioni</a>
    <a href="logout.php"> Logout</a>
</div>

<header>
    <h1>Gestione Donazioni</h1>
    <p>Elenco di tutte le donazioni ricevute</p>
</header>

<main>
    <div class="table-card">
        <div class="table-card-header">
            <h2>Donazioni registrate</h2>
            <!-- count() conta quante donazioni sono state recuperate dal database -->
            <span class="badge"><?= count($donazioni) ?> totale</span>
        </div>

        <?php if (count($donazioni) > 0):
            // array_column estrae solo la colonna "importo" e array_sum ne fa la somma
            $totale = array_sum(array_column($donazioni, "importo"));
        ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Importo (€)</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donazioni as $d): ?>
                <tr>
                    <!-- htmlspecialchars evita che eventuali caratteri speciali nel db causino problemi html -->
                    <td>#<?= htmlspecialchars($d["id"]) ?></td>
                    <td><?= htmlspecialchars($d["nome"]) ?></td>
                    <td><?= htmlspecialchars($d["cognome"] ?? "") ?></td>
                    <td><?= htmlspecialchars($d["email"]) ?></td>
                    <td class="importo">€ <?= number_format((float)$d["importo"], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($d["data"] ?? "") ?></td>
                    <td>
                        <!-- i link passano l'id della donazione tramite query string per identificarla -->
                        <a class="action-link modifica" href="modifica_donazione.php?id=<?= $d["id"] ?>">✏ Modifica</a>
                        <a class="action-link elimina"  href="elimina_donazione.php?id=<?= $d["id"] ?>"
                           onclick="return confirm('Eliminare la donazione #<?= $d["id"] ?>?')">✕ Elimina</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="totale-bar">
            Totale raccolto: <strong>€ <?= number_format($totale, 2, ',', '.') ?></strong>
        </div>
        <?php else: ?>
            <p class="empty-msg">Nessuna donazione trovata.</p>
        <?php endif; ?>
    </div>

    <a href="dona.php" class="home-button"> Torna alla pagina donazioni</a>
</main>

<footer>
    <p>&copy; 2026 Associazione Vita Libera</p>
</footer>
</body>
</html>