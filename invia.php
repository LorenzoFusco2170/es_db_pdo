<?php

    $host = "localhost";
    $dbname = "fuscodb";
    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $user,
            $pass
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $email = $_POST["email"];
            $importo = $_POST["importo"];
            $data = $_POST["data"];

            $sql = "INSERT INTO donazioni (nome, cognome, email, importo, data)
                VALUES (:nome, :cognome, :email, :importo, :data)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nome" => $nome,
                ":cognome" => $cognome,
                ":email" => $email,
                ":importo" => $importo,
                ":data" => $data
            ]);

            $to = "email@example.com";
            $subject = "Nuova donazione";
            $message = "Nuova donazione ricevuta:\n"
                 . "Nome: $nome $cognome\n"
                 . "Email: $email\n"
                 . "Importo: € $importo\n"
                 . "Data: $data";
            $headers = "From: $email";

            mail($to, $subject, $message, $headers);

            echo "
            <h2>Grazie per la tua donazione!</h2>
            <p>Email inviata correttamente e donazione salvata nel database.</p>
            <a href='dona.html'>Torna alla pagina donazioni</a>
            ";
        }
        
    } catch (PDOException $e) {
        die("Errore di connessione: " . $e->getMessage());
    }
?>