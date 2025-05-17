<?php
session_start();
include("_conf.php");

if (!isset($_SESSION['Sid'])) {
    exit();
}

$num_utilisateur = $_SESSION['Sid'];

$sql = "SELECT * FROM cr WHERE num_utilisateur = ?";
$stmt = $connexion->prepare($sql);
$stmt->execute([$num_utilisateur]);
$comptes_rendus = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Comptes-Rendus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
            color: #333;
        }

        h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
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
            background-color: #fff;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            color: #0056b3;
        }

      
    </style>
</head>
<body>

    <h2>Liste des Comptes-Rendus</h2>

    <table>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Modifier</th>
        </tr>

        <?php foreach ($comptes_rendus as $cr): ?>
        <tr>
            <td><?= htmlspecialchars($cr['date']) ?></td>
            <td><?= nl2br(htmlspecialchars($cr['description'])) ?></td>
            <td><a href="creer_modifier.php?num=<?= $cr['num'] ?>">Modifier</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="liens">
        <a href="creer_modifier.php">Créer un nouveau compte-rendu</a><br><br>
        <a href="accueil.php">Retourner à l'accueil</a>
    </div>

</body>
</html>
