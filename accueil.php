<?php
session_start();

// 🔐 Sécurité : accès uniquement si connecté
if (!isset($_SESSION['id_patient'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>

<h1>Bienvenue <?= htmlspecialchars($_SESSION['utilisateur']) ?></h1>

<a href="logout.php">Se déconnecter</a>

</body>
</html>