<!DOCTYPE html>
<html>
<head>
    <title>Errore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .error-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Errore</h1>
        <?php
        // Ottieni il messaggio di errore dalla query string
        $error_message = $_GET['message'];

        // Mostra il messaggio di errore
        echo $error_message;
        ?>
        <p>L'app è in fase di sviluppo.<br>Riprova più tardi o contatta l'amministratore di sistema.</p>
    </div>
</body>
</html>
