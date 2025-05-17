<?php
session_start();
include "_conf.php"; // Ici, $connexion est un objet PDO

if (!isset($_SESSION['Sid'])) {
    exit();
}

try {
    $sql = "SELECT num, prenom, nom FROM utilisateur WHERE type = 0 ORDER BY prenom, nom";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des élèves : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des élèves</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
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
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            color: #0056b3;
        }
        
        
    </style>
</head>
<body>

<h2>Liste des élèves</h2>

<table>
    <tr>
        <th>Prénom</th>
        <th>Nom</th>
        
    </tr>

    <?php foreach ($eleves as $eleve) : ?>
        <tr>
            <td><?= htmlspecialchars($eleve['prenom']) ?></td>
            <td><?= htmlspecialchars($eleve['nom']) ?></td>
        </tr>
    <?php endforeach; ?>

</table>

<br><div class="liens">
        <a href="liste_complète.php">Voir la liste des compte-rendus</a><br><br>
        <a href="accueil.php">Retourner à l'accueil</a>
    </div>
</body>
</html>
