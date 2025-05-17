<?php 
function motDePasse($longueur) {
    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!+()*-/";
    $Chaine = str_shuffle($Chaine);
    $Chaine = substr($Chaine, 0, $longueur);
    return $Chaine;
}

require_once("_conf_web.php");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .email-form {
            max-width: 400px;
            width: 90%;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .email-form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .email-form input[type="email"],
        .email-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .email-form input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .email-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php
if (!isset($_POST['email'])) {
    ?>
    <form method="post" class="email-form">
        <h2>Mot de passe oublié</h2>
        <label for="email">Saisir votre email :</label><br>
        <input type="email" name="email" required><br>
        <input type="submit" value="OK" name="bouton_email">
    </form>
    <?php
} else {
    echo '<div class="email-form">';
    $lemail = $_POST['email'];
    echo "<div class='message'>Formulaire envoyé avec l'email : <strong>$lemail</strong></div>";

    if ($connexion = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD)) {
        $requete = "SELECT * FROM utilisateur WHERE email='$lemail'";
        $resultat = mysqli_query($connexion, $requete);

        $login = 0;
        while ($donnees = mysqli_fetch_assoc($resultat)) {
            $login = $donnees['login'];
        }

        if ($login != 0) {
            $newmotdepasse = motDePasse(15);
            $mdphache = md5($newmotdepasse);
            $requete = "UPDATE utilisateur SET motdepasse = '$mdphache' WHERE email = '$lemail'";
            mysqli_query($connexion, $requete);

            $message = "Bonjour, voici votre nouveau mot de passe : $newmotdepasse";
            mail($lemail, 'Mot de passe oublié', $message);
            echo "<div class='message'><strong>Un nouveau mot de passe a été envoyé à votre adresse email.</strong></div>";
        } else {
            echo "<div class='message' style='color:red;'>Email non trouvé dans la base.</div>";
        }
    } else {
        echo "<div class='message' style='color:red;'>Erreur de connexion à la base de données.</div>";
    }

    echo '</div>';
}
?>

</body>
</html>
