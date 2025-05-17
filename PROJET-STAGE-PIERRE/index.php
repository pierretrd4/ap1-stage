<?php
session_start();

$deconnexionMessage = "";

if (isset($_POST['send_deco'])) {
    session_destroy();
    $deconnexionMessage = "Vous êtes déconnecté";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        /* Style global */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 15px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            color: #0056b3;
        }

        .message {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <form method="post" action="accueil.php" class="login-form">
        <h2>Connexion</h2>
        <?php if ($deconnexionMessage): ?>
            <div class="message"><?= $deconnexionMessage ?></div>
        <?php endif; ?>

        <label for="login">Login :</label>
        <input type="text" name="login" id="login" required>

        <label for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" required>

        <input type="submit" name="send_con" value="Se connecter">

        <a href="oubli.php">Oubli de mot de passe</a>
    </form>

</body>
</html>
