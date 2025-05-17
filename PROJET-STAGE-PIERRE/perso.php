<?php
session_start();
include("_conf.php");

if (!isset($_SESSION['Sid'])) {

    exit();
}

$num_utilisateur = $_SESSION['Sid'];
$message = "";

// Récupérer les infos actuelles de l'utilisateur
$sql = "SELECT email FROM utilisateur WHERE num = ?";
$stmt = $connexion->prepare($sql);
$stmt->execute([$num_utilisateur]);
$utilisateur = $stmt->fetch();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour de l'email
    if (!empty($_POST['email'])) {
        $nouvel_email = $_POST['email'];
        $stmt = $connexion->prepare("UPDATE utilisateur SET email = ? WHERE num = ?");
        $stmt->execute([$nouvel_email, $num_utilisateur]);
        $message .= "Email mis à jour.<br>";
    }

    // Changement de mot de passe
    if (!empty($_POST['ancien_mdp']) && !empty($_POST['nouveau_mdp'])) {
        $ancien_mdp = md5($_POST['ancien_mdp']);
        $nouveau_mdp = md5($_POST['nouveau_mdp']);

        // Vérification de l'ancien mot de passe
        $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE num = ? AND motdepasse = ?");
        $stmt->execute([$num_utilisateur, $ancien_mdp]);
        if ($stmt->rowCount() > 0) {
            // Ancien mot de passe correct, on met à jour
            $stmt = $connexion->prepare("UPDATE utilisateur SET motdepasse = ? WHERE num = ?");
            $stmt->execute([$nouveau_mdp, $num_utilisateur]);
            $message .= "Mot de passe mis à jour.<br>";
        } else {
            $message .= "<span style='color:red'>Ancien mot de passe incorrect.</span><br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 15px;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Mes informations</h2>
    
    <?php if (!empty($message)) : ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" value="<?= htmlspecialchars($utilisateur['email']) ?>">

        <label for="ancien_mdp">Ancien mot de passe :</label>
        <input type="password" name="ancien_mdp" id="ancien_mdp">

        <label for="nouveau_mdp">Nouveau mot de passe :</label>
        <input type="password" name="nouveau_mdp" id="nouveau_mdp">

        <input type="submit" value="Mettre à jour">
    </form>

    <a href="accueil.php">Retour à l'accueil</a>
</div>
</body>
</html>
