<?php
session_start();

// Paramètres de connexion AlwaysData
$host = "localost"; 
$user = "root";
$password = "";
$dbname = "labo";
$port = 3306;           


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

$message = "";

// TRAITEMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    /* ===== INSCRIPTION ===== */
    if ($action === 'inscription') {

        $nom    = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email  = trim($_POST['email'] ?? '');
        $mdp    = $_POST['mdp'] ?? '';

        if (empty($nom) || empty($prenom) || empty($email) || empty($mdp)) {
            $message = "❌ Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "❌ Email invalide.";
        } else {

            $check = $pdo->prepare("SELECT id FROM patient WHERE email = ?");
            $check->execute([$email]);

            if ($check->fetch()) {
                $message = "❌ Email déjà utilisé.";
            } else {

                $hash = password_hash($mdp, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO patient (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $hash]);

                $message = "✅ Inscription réussie !";
            }
        }
    }

    /* ===== CONNEXION ===== */
    elseif ($action === 'connexion') {

        $email = trim($_POST['email'] ?? '');
        $mdp   = $_POST['mdp'] ?? '';

        if (empty($email) || empty($mdp)) {
            $message = "❌ Tous les champs sont obligatoires.";
        } else {

            $stmt = $pdo->prepare("SELECT id, nom, mot_de_passe FROM patient WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($mdp, $user['mot_de_passe'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];

                header("Location: index.php");
                exit;

            } else {
                $message = "❌ Email ou mot de passe incorrect.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion / Inscription</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h2 class="text-center mb-4">Espace Patient</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>

        <!-- Onglets -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login">Connexion</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#register">Inscription</button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- CONNEXION -->
            <div class="tab-pane fade show active" id="login">
                <form method="post">
                    <input type="hidden" name="action" value="connexion">

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
                    </div>

                    <button class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>

            <!-- INSCRIPTION -->
            <div class="tab-pane fade" id="register">
                <form method="post">
                    <input type="hidden" name="action" value="inscription">

                    <div class="mb-3">
                        <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
                    </div>

                    <button class="btn btn-success w-100">S'inscrire</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>