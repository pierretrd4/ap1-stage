<?php
session_start();
include("_conf.php");

if (!isset($_SESSION['Sid'])) {
    exit();
}

$erreur = "";
$description = "";
$date = date('Y-m-d'); // Par défaut : aujourd'hui
$num_utilisateur = $_SESSION['Sid'];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $description = $_POST['description'];
    $date = $_POST['date'];
    $datetime = date('Y-m-d H:i:s');

    
    $sql = "SELECT num FROM cr WHERE DATE(date) = ? AND num_utilisateur = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$date, $num_utilisateur]);
    $cr = $stmt->fetch();

    if ($cr) {
        
        $sql = "UPDATE cr SET description = ?, datetime = ? WHERE num = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$description, $datetime, $cr['num']]);
    } else {
        
        $sql = "INSERT INTO cr (date, description, vu, datetime, num_utilisateur) VALUES (?, ?, 0, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$date, $description, $datetime, $num_utilisateur]);
    }

    exit();
}

if (!empty($_GET['date'])) {
    $date = $_GET['date'];
    $sql = "SELECT description FROM cr WHERE DATE(date) = ? AND num_utilisateur = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$date, $num_utilisateur]);
    $cr = $stmt->fetch();

    if ($cr) {
        $description = $cr['description'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer / Modifier un Compte-Rendu</title>
</head>
<body>
    <h2>Créer / Modifier un Compte-Rendu</h2>

    <?php if ($erreur): ?>
        <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="date">Date :</label><br>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars($date) ?>" required><br><br>

        <label>Description :</label><br>
        <textarea name="description" rows="6" cols="50" required><?= htmlspecialchars($description) ?></textarea><br><br>

        <input type="submit" value="Sauvegarder">
    </form>

    <p><a href="liste_comptes_rendus.php">Accéder à la liste des comptes rendus</a></p>
    <p><a href="accueil.php">Retourner à l'accueil</a></p>

    <script>
    document.getElementById('date').addEventListener('change', function () {
        const selectedDate = this.value;
        window.location.href = "creer_modifier.php?date=" + selectedDate;
    });
    </script>
    <style>
    /* Même CSS que celui que tu avais */
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
</body>
</html>
