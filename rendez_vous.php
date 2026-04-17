<?php
// ==================== BDD ====================
// Paramètres de connexion AlwaysData
$host = "localhost"; 
$user = "root";
$password = "";
$dbname = "labo";
$port = 3306;           


$message = ""; // initialisation du message

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur BDD : " . $e->getMessage());
}

// ==================== AJOUT ====================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nomPatient']) && !empty($_POST['prenomPatient']) && !empty($_POST['heure'])) {
        try {
            // Adapter l'INSERT aux colonnes existantes de ta table
            $stmt = $pdo->prepare("INSERT INTO rendez_vous (nom, prenom, heure_rdv) VALUES (?, ?, ?)");
            $stmt->execute([
                $_POST['nomPatient'],
                $_POST['prenomPatient'],
                $_POST['heure']
            ]);
            $message = "Rendez-vous ajouté ✔️";
        } catch (Exception $e) {
            $message = "Erreur SQL : " . $e->getMessage();
        }
    } else {
        $message = "Tous les champs sont obligatoires ❌";
    }
}

// ==================== SUPPRESSION ====================
if (isset($_GET['delete'])) {
    $idToDelete = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM rendez_vous WHERE id = ?");
    $stmt->execute([$idToDelete]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rendez-vous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="text-center mb-4">Gestion des rendez-vous</h2>

    <!-- MESSAGE -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- FORMULAIRE -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-5">
                    <label>Nom patient</label>
                    <input type="text" name="nomPatient" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label>Prénom patient</label>
                    <input type="text" name="prenomPatient" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label>Heure</label>
                    <input type="time" name="heure" class="form-control" required>
                </div>
                <div class="col-md-12 mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLEAU -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Heure</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM rendez_vous ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nom'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['prenom'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['heure_rdv'] ?? '') ?></td>
                        <td>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce rendez-vous ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>