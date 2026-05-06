<?php
// avvia la sessione per controllare se l'utente è già loggato come admin
session_start();

// controlla se l'utente è loggato con ruolo admin per personalizzare l'interfaccia
$loggato = isset($_SESSION["utente"]) && $_SESSION["ruolo"] === "admin";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dona Ora - Vita Libera</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; }

        header {
            background-color: #bb1e1e;
            color: white;
            padding: 24px 20px 20px;
            text-align: center;
        }
        header h1 { font-size: 2rem; margin-bottom: 6px; color: white; }
        header h2 { font-size: 1rem; opacity: .85; color: white; font-weight: normal; }

        .admin-bar {
            background: #222;
            color: #eee;
            text-align: center;
            padding: 10px;
            font-size: .9rem;
        }
        .admin-bar a {
            color: #ff9999;
            font-weight: bold;
            text-decoration: none;
            margin: 0 10px;
        }
        .admin-bar a:hover { text-decoration: underline; }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,.1);
        }

        .form-container input,
        .form-container label,
        .form-container button { width: 100%; }

        .form-container input {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .form-container input:focus { outline: none; border-color: #bb1e1e; }

        .form-container button {
            padding: 12px;
            background-color: #bb1e1e;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .form-container button:hover { background-color: #a01919; }

        .donation-image {
            width: 100%;
            max-width: 600px;
            border-radius: 10px;
            display: block;
            margin: 30px auto;
            box-shadow: 0 0 10px rgba(0,0,0,.2);
        }

        #thankYouMsg { text-align: center; font-size: 18px; color: #4CAF50; }

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
    <!-- barra admin visibile solo se l'utente è loggato: personalizzazione dell'interfaccia in base ai permessi -->
    <div class="admin-bar">
        👤 Sei loggato come <strong><?= htmlspecialchars($_SESSION["nome"]) ?></strong> (admin)
        &nbsp;|&nbsp;
        <a href="gestione_donazioni.php"> Gestisci Donazioni</a>
        <a href="logout.php"> Logout</a>
    </div>
<?php endif; ?>

<header>
    <h1>Dona Ora</h1>
    <h2 id="test2">Sostieni la nostra causa con una donazione</h2>
</header>

<main>
    <div class="form-container">
        <!-- il form invia i dati a invia.php che li salva nel database e manda l'email -->
        <form id="donationForm" action="invia.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="importo">Importo (€):</label>
            <input type="number" id="importo" name="importo" required min="1" step="0.01">

            <button type="submit">Invia Donazione</button>
        </form>
        <p id="thankYouMsg" style="display:none;margin-top:20px;">Grazie per la tua generosità!</p>
    </div>

    <img src="https://www.ilfilo-smi.it/wp-content/uploads/Dipendenza-da-sostanze-stupefacenti-1030x773.jpg"
         alt="Persona in difficoltà" class="donation-image">

    <a href="index.html" class="home-button">Torna alla Home</a>

    <!-- questo bottone porta al login: solo dopo aver inserito le credenziali admin si accede alla gestione -->
    <a href="login.php" class="home-button"> Area Admin</a>
</main>

<footer>
    <p style="text-align:center;">&copy; 2026 Associazione Vita Libera</p>
</footer>

<script>
    // mostra il messaggio di ringraziamento quando il form viene inviato
    document.getElementById('donationForm').addEventListener('submit', function() {
        document.getElementById('thankYouMsg').style.display = 'block';
    });
</script>
</body>
</html>