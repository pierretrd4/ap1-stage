<?php
$serveurBDD = "localhost";
$userBDD = "root";
$mdpBDD = "";
$nomBDD = "projet-stage-pierre";

// Connexion à la base de données avec PDO
try {
    $connexion = new PDO("mysql:host=$serveurBDD;dbname=$nomBDD;charset=utf8", $userBDD, $mdpBDD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gérer les erreurs de façon appropriée
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
