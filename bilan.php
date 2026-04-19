<?php
session_start();

// ======================
// CONNEXION PDO UNIQUE
// ======================
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=labo;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}

// ======================
// FLASH MESSAGE
// ======================
function flash($message, $type = 'info') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

// ======================
// SUPPRESSION
// ======================
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);

    $stmt = $pdo->prepare("DELETE FROM bilan WHERE id = ?");
    $stmt->execute([$id]);

    flash("✅ Compte rendu supprimé avec succès", "success");

    header("Location: bilan.php");
    exit;
}

// ======================
// AJOUT
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenu = trim($_POST['contenu'] ?? '');

    if (!empty($contenu)) {
        $stmt = $pdo->prepare("INSERT INTO bilan (contenu) VALUES (?)");
        $stmt->execute([$contenu]);

        flash("✅ Compte rendu ajouté avec succès", "success");

        header("Location: bilan.php");
        exit;
    } else {
        flash("⚠️ Le contenu est vide", "warning");
    }
}

// ======================
// RECUPERATION
// ======================
$stmt = $pdo->query("SELECT id, contenu, date_creation FROM bilan ORDER BY id DESC");
$bilanListe = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Rendu Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<?php include 'includes/header.php'; ?>

<div class="container mt-5">

    <h1 class="mb-4">🩺 Gestion des comptes rendus</h1>

    <!-- FLASH -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
            <?= $_SESSION['flash']['message'] ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- FORMULAIRE -->
    <div class="card mb-4">
        <div class="card-header">Ajouter un compte rendu</div>
        <div class="card-body">
            <form method="post">
                <textarea name="contenu" class="form-control mb-3" rows="4" required></textarea>
                <button class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- LISTE -->
    <?php if (!empty($bilanListe)): ?>
        <?php foreach ($bilanListe as $row): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Compte rendu #<?= htmlspecialchars($row['id']) ?></h5>

                    <p><?= nl2br(htmlspecialchars($row['contenu'])) ?></p>

                    <small class="text-muted">
                        <?= htmlspecialchars($row['date_creation']) ?>
                    </small>

                    <br><br>

                    <a href="?supprimer=<?= urlencode($row['id']) ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Supprimer ce compte rendu ?');">
                        Supprimer
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">Aucun compte rendu disponible.</p>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>