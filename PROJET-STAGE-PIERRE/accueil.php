<?php
session_start();
include "_conf.php";

function afficherErreurConnexion() {
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>Erreur de connexion</title>
        <style>
            body {
                margin: 0;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background: white;
                font-family: Arial, sans-serif;
            }
            .container {
                text-align: center;
            }
            button {
                margin-top: 20px;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <p>Login ou mot de passe incorrect</p>
             <a href="index.php"><button>Réessayer</button></a>
        </div>
    </body>
    </html>';
    exit();
}


if (isset($_POST['send_deco'])) {
    session_destroy();

    exit();
}


if (isset($_POST['send_con'])) {
    $login = $_POST['login'];
    $mdp = md5($_POST['mdp']);

    if ($connexion = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD)) {
        $requete = "SELECT * FROM utilisateur WHERE login='$login' and motdepasse='$mdp'";
        $resultat = mysqli_query($connexion, $requete);
        if ($donnees = mysqli_fetch_assoc($resultat)) {
            $_SESSION['Sid'] = $donnees['num'];
            $_SESSION['Slogin'] = $donnees['login'];
            $_SESSION['Sprenom'] = $donnees['prenom'];
            $_SESSION['Stype'] = $donnees['type'];
            header("Location: index.php"); 
            exit();
        } else {
            afficherErreurConnexion();
        }
    } else {
        echo "Erreur de connexion à la base de données";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
<style>
	body {
            font-family: Arial, sans-serif;
            margin: 40px;
        
		}

        .header {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            margin: 0;
        }

        .deco-form input {
            padding: 5px 10px;
        }

        .carte-container {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .carte {
            width: 30%;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: center;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }

        .carte a {
            display: block;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .login-form {
            max-width: 300px;
        }

        .login-form input {
            margin: 5px 0;
        }
	.carte-container-prof {
    display: flex;
    justify-content: center; 
    gap: 0px; 
    margin-top: 30px;
    flex-wrap: nowrap; 
}

.carte-container-prof .carte {
    width: 280px;
    margin: 0; 
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    text-align: center;
}

body {
    font-family: Arial, sans-serif;
    margin: 40px;
    background-color: #f4f4f9;
    color: #333;
}

h2, .header {
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

a {
    text-decoration: none;
    color: #007BFF;
}

a:hover {
    color: #0056b3;
}

.login-form {
    max-width: 400px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.login-form input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.login-form input[type="submit"] {
    background-color: #007BFF;
    color: #fff;
    border: none;
    cursor: pointer;
}

.login-form input[type="submit"]:hover {
    background-color: #0056b3;
}

.deco-form {
    text-align: center;
}

.deco-form input {
    padding: 10px 20px;
    background-color: #FF5722;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.deco-form input:hover {
    background-color: #d84e1d;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.carte-container {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
}

.carte {
    width: 30%;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #fff;
    text-align: center;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.carte a {
    display: block;
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 16px;
}

.carte p {
    font-size: 14px;
    color: #666;
}

.error-message {
    color: red;
    font-size: 16px;
    text-align: center;
}

textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    resize: vertical;
}

textarea:focus {
    outline: none;
    border-color: #007BFF;
}

.welcome-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.welcome-section h2 {
    margin: 0;
    font-size: 22px;
    color: #333;
}

.header {
    font-size: 20px;
    margin-bottom: 10px;
}


	</style>
</head>
<body>

<?php
if (isset($_SESSION['Sid'])) {
    $partie = ($_SESSION['Stype'] == 1) ? "Partie Prof :" : "Partie Élève :";

    echo '<div class="header"><strong style="display:block; text-align:center;">Accueil</strong><br><span style="display:block;">' . $partie . '</span></div>';
    echo '<div class="welcome-section"><h2>Bienvenue ' . $_SESSION['Sprenom'] . '</h2></div>';

    if ($_SESSION['Stype'] == 1) {
        // Partie prof
        echo '<div class="carte-container-prof">
                <div class="carte">
                    <a href="liste_complète.php">Liste de tous les comptes rendus</a>
                    <p>Voir tous les comptes rendus des élèves</p>
                </div>
                <div class="carte">
                    <a href="liste_eleves.php">Liste des élèves</a>
                    <p>Consulter la liste des élèves</p>
                </div>
              </div>';
    } else {
        // Partie élève
        echo '<div class="carte-container">
                <div class="carte">
                    <a href="liste_comptes_rendus.php">Liste compte rendus</a>
                    <p> </p>
                </div>
                <div class="carte">
                    <a href="creer_modifier.php">Créer un compte rendus</a>
                    <p> </p>
                </div>
                <div class="carte">
                    <a href="commentaires.php">Commentaires</a>
                    <p> </p>
                </div>
                <div class="carte">
                    <a href="perso.php">Page personnelle</a>
                    <p>Accédez à votre page personnelle.</p>
                </div>
              </div>';
    }

    
    echo '<br><br><form method="post" action="accueil.php" class="deco-form">
            <input type="submit" value="Se déconnecter" name="send_deco">
          </form>';
} else {
    
    ?>
    <form method="post" action="accueil.php" class="login-form">
        login : <input type="text" name="login"><br>
        mot de passe : <input type="password" name="mdp"><br>
        <input type="submit" name="send_con" value="OK"><br>
    </form>
    <a href="oubli.php" class="btn">Mot de passe oublié ?</a>
    <?php
}
?>

</body>
</html>
