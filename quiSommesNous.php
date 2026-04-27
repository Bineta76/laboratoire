<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Health North</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <!-- IMAGE -->
    <div class="text-center">
        <img src="assets/labo.jpg" class="img-fluid rounded shadow" alt="Laboratoire">
    </div>

    <h3 class="text-center mt-4">Bienvenue à Health North</h3>

    <p class="text-center">
        Depuis 1920, Health North révolutionne la prise de rendez-vous dans toute la région Hauts-de-France.
        Notre plateforme connecte les patients avec plus de 500 professionnels de santé répartis dans 75 centres médicaux.
    </p>

    <!-- FEATURES -->
    <div class="row text-center mt-4">
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5>Prise de RDV simplifiée</h5>
                <p>Réservez votre rendez-vous 24h/24 et 7j/7 sans attendre.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5>Large réseau médical</h5>
                <p>Accédez à plus de 500 professionnels de santé.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5>Rappels automatiques</h5>
                <p>Recevez des notifications pour vos rendez-vous.</p>
            </div>
        </div>
    </div>

    <h2 class="text-center mt-5">Health North en chiffres</h2>

    <div class="row text-center mt-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h4>500+</h4>
                <p>Professionnels</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h4>75</h4>
                <p>Centres</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark p-3">
                <h4>100 000+</h4>
                <p>Patients</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white p-3">
                <h4>1M+</h4>
                <p>Rendez-vous</p>
            </div>
        </div>
    </div>

    <h2 class="text-center mt-5">Nos centres partenaires</h2>

    <ul class="list-group mt-3">
        <li class="list-group-item">Clinique Laforêt</li>
        <li class="list-group-item">Hôpital Central</li>
        <li class="list-group-item">Clinique du Parc</li>
    </ul>

    <h2 class="text-center mt-5">Actualités</h2>

    <div class="card p-4 shadow">
        <p>
            Health North est un leader européen des analyses médicales.
        </p>

        <p>
            Suite à une fusion récente, le groupe renforce son positionnement en Europe.
        </p>

        <p><strong>Services proposés :</strong></p>

        <ul>
            <li>Chirurgie ambulatoire</li>
            <li>Imagerie médicale</li>
            <li>Médecine reproductive</li>
            <li>Biologie médicale</li>
            <li>Tests spécialisés</li>
            <li>Hospitalisation</li>
        </ul>
    </div>

    <!-- FOOTER -->
    <div class="mt-5">
        <?php
        if (file_exists('includes/footer.php')) {
            include 'includes/footer.php';
        }
        ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>