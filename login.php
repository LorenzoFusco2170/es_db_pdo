<?php
// avvia la sessione per poter salvare i dati dell'utente dopo il login
session_start();
require "database.php";

// se l'utente è già loggato non ha senso mostrargli il login, lo mandiamo direttamente alla gestione
if (isset($_SESSION["utente"])) {
    header("Location: gestione_donazioni.php");
    exit;
}

// credenziali admin definite come costanti per facilità di modifica
define("ADMIN_USER", "admin");
define("ADMIN_PASS", "1234");

$errore = "";

// controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // legge e pulisce i valori inviati dal form
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $errore = "Compila tutti i campi.";
    } elseif ($username === ADMIN_USER && $password === ADMIN_PASS) {
        // le credenziali sono corrette: salva i dati dell'utente in sessione
        $_SESSION["utente"] = "admin";
        $_SESSION["ruolo"]  = "admin";
        $_SESSION["nome"]   = "Amministratore";
        // reindirizza alla pagina protetta
        header("Location: gestione_donazioni.php");
        exit;
    } else {
        $errore = "Username o password non corretti.";
    }
}

// mostra un messaggio di errore se l'utente ha tentato di accedere a una pagina protetta senza login
if (empty($errore) && isset($_GET["errore"]) && $_GET["errore"] === "accesso_negato") {
    $errore = "Devi effettuare il login come admin per accedere a quella pagina.";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Vita Libera</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }

        header {
            background-color: #bb1e1e;
            color: white;
            padding: 24px 20px 20px;
            text-align: center;
        }
        header h1 { font-size: 2rem; margin-bottom: 6px; color: white; }
        header p  { font-size: 1rem; opacity: .85; color: white; }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }

        .form-container h2 {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 22px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            font-size: .9rem;
            color: #555;
            margin-bottom: 5px;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: .95rem;
            box-sizing: border-box;
        }
        .form-container input:focus { outline: none; border-color: #bb1e1e; }

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
            transition: background-color .3s ease;
        }
        .form-container button:hover { background-color: #a01919; }

        .errore {
            background: #fdecea;
            border-left: 4px solid #bb1e1e;
            color: #c0392b;
            padding: 10px 14px;
            border-radius: 5px;
            margin-bottom: 18px;
            font-size: .9rem;
        }

        .home-button {
            display: inline-block;
            margin-top: 24px;
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

<header>
    <h1> Area Riservata</h1>
    <p>Accesso consentito solo agli amministratori</p>
</header>

<main>
    <div class="form-container">
        <h2>Login Admin</h2>

        <?php if ($errore): ?>
            <!-- mostra il messaggio di errore se le credenziali sono errate o mancanti -->
            <div class="errore"> <?= htmlspecialchars($errore) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <!-- value ripopola il campo se il form viene reinviato con errori -->
            <input type="text" id="username" name="username"
                   value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required autofocus>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit"> Accedi</button>
        </form>
    </div>

    <a href="index.html" class="home-button"> Torna alla Home</a>
</main>

<footer>
    <p>&copy; 2026 Associazione Vita Libera</p>
</footer>

</body>
</html>