<?php
// avvia la sessione per leggere i dati della donazione appena effettuata
session_start();

// se non ci sono dati in sessione significa che l'utente ha aperto questa pagina direttamente
// senza passare dal form: lo rimandiamo alla pagina di donazione
if (!isset($_SESSION["ultima_donazione"])) {
    header("Location: dona.php");
    exit;
}

// legge i dati salvati in sessione da invia.php
$d = $_SESSION["ultima_donazione"];

// cancella i dati dalla sessione dopo averli letti: servivano solo per questo messaggio una tantum
unset($_SESSION["ultima_donazione"]);

// controlla se l'utente è admin per mostrare eventualmente la barra di amministrazione
$loggato = isset($_SESSION["utente"]) && $_SESSION["ruolo"] === "admin";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grazie! - Vita Libera</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }

        .admin-bar { background:#222; color:#eee; text-align:center; padding:10px; font-size:.9rem; }
        .admin-bar a { color:#ff9999; font-weight:bold; text-decoration:none; margin:0 10px; }
        .admin-bar a:hover { text-decoration:underline; }

        header { background-color: #bb1e1e; color: white; padding: 24px 20px 20px; text-align: center; }
        header h1 { font-size: 2rem; margin-bottom: 6px; }
        header p  { opacity: .85; }

        main { display: flex; flex-direction: column; align-items: center; padding: 40px 20px 60px; }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,.1);
            padding: 36px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .card .icona { font-size: 3rem; margin-bottom: 12px; }
        .card h2 { color: #4CAF50; margin-bottom: 12px; }

        .riepilogo {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            text-align: left;
            font-size: .95rem;
            line-height: 1.9;
        }
        .riepilogo strong { color: #bb1e1e; }

        .home-button {
            display: inline-block;
            margin-top: 20px;
            margin-right: 8px;
            padding: 12px 24px;
            background-color: #bb1e1e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color .3s ease;
        }
        .home-button:hover { background-color: #a01919; }

        footer { background-color: #222; color: #ccc; text-align: center; padding: 20px; font-size: .9rem; }
    </style>
</head>
<body>

<?php if ($loggato): ?>
    <!-- barra admin visibile solo se l'utente è loggato -->
    <div class="admin-bar">
        👤 <strong><?= htmlspecialchars($_SESSION["nome"]) ?></strong> (admin) &nbsp;|&nbsp;
        <a href="gestione_donazioni.php"> Gestisci Donazioni</a>
        <a href="logout.php"> Logout</a>
    </div>
<?php endif; ?>

<header>
    <h1>Grazie di cuore!</h1>
    <p>La tua donazione è stata registrata con successo</p>
</header>

<main>
    <div class="card">
        <div class="icona">Fatto</div>
        <h2>Donazione ricevuta con successo!</h2>
        <p>Grazie <strong><?= htmlspecialchars($d["nome"]) ?></strong>, il tuo contributo fa la differenza.</p>

        <!-- riepilogo con i dati passati tramite sessione da invia.php -->
        <div class="riepilogo">
            <strong>Nome:</strong> <?= htmlspecialchars($d["nome"]) ?> <?= htmlspecialchars($d["cognome"]) ?><br>
            <strong>Email:</strong> <?= htmlspecialchars($d["email"]) ?><br>
            <!-- number_format formatta il numero con 2 decimali e separatori italiani -->
            <strong>Importo:</strong> € <?= number_format((float)$d["importo"], 2, ',', '.') ?><br>
            <strong>Data:</strong> <?= htmlspecialchars($d["data"]) ?>
        </div>

        <p style="font-size:.9rem;color:#666;">
            Riceverai una conferma all'indirizzo <em><?= htmlspecialchars($d["email"]) ?></em>.
        </p>

        <a href="index.html" class="home-button"> Torna alla Home</a>
        <a href="dona.php"   class="home-button"> Dona ancora</a>
    </div>
</main>

<footer>
    <p>&copy; 2026 Associazione Vita Libera</p>
</footer>
</body>
</html>