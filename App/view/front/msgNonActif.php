<?php
session_start(); // Démarrer la session pour stocker des messages temporaires
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\User;
use App\Models\UserRepository;




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation du Compte Enseignant - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css"> 
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Activation du Compte Enseignant</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <i class="fas fa-user-circle"></i>
                </div>
                <button class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <a href="logout.php">Déconnexion</a>
                </button>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="container mt-4">
            <div class="alert alert-info">
                <h4 class="alert-heading">Votre compte est en attente d'activation</h4>
                <p>
                Bonjour <br>
                    Votre demande de création de compte enseignant a été reçue avec succès. 
                    Notre équipe administrative traite actuellement votre demande, et votre compte sera activé dans un délai 
                    maximum de <strong>24 heures</strong>.</p>
                <hr>
                <p class="mb-0">
                    Si vous avez des questions ou besoin d'une assistance supplémentaire, 
                    veuillez contacter l'administrateur à <a href="mailto:admin@youdemy.com">admin@youdemy.com</a>.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <p>&copy; 2023 Youdemy. Tous droits réservés.</p>
            </div>
            <div class="footer-right">
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-shield-alt"></i> Politique de confidentialité</a></li>
                    <li><a href="#"><i class="fas fa-file-contract"></i> Conditions d'utilisation</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>