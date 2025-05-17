<?php
session_start();
include "_conf.php";

$pdo = $connexion;

$sql = "SELECT cr.num, cr.date, cr.description, utilisateur.nom, utilisateur.prenom
        FROM cr
        JOIN utilisateur ON cr.num_utilisateur = utilisateur.num
        ORDER BY cr.date DESC";

try {
    $stmt = $pdo->query($sql);
    $comptes_rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Erreur requête : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des comptes rendus</title>
    <style>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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

        .error-message {
            color: red;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 class="header">Liste des comptes rendus</h2>

    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Date</th>
                <th>Description</th>
                <th>Fait par</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($comptes_rendus) > 0): ?>
                <?php foreach ($comptes_rendus as $cr): ?>
                    <tr>
                        <td><?= htmlspecialchars($cr['num']) ?></td>
                        <td><?= htmlspecialchars($cr['date']) ?></td>
                        <td><?= nl2br(htmlspecialchars($cr['description'])) ?></td>
                        <td><?= htmlspecialchars($cr['prenom']) . ' ' . htmlspecialchars($cr['nom']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="error-message">Aucun compte rendu trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
	<br><div class="liens">
        <a href="liste_eleves.php">Voir seulement la liste des élèves</a><br><br>
        <a href="accueil.php">Retourner à l'accueil</a>
    </div>
</body>
</html>
