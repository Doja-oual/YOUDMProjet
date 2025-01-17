


<?php
// teacher.php

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ../../views/auth/login.php');
    exit();
}

// Récupérer les informations de l'utilisateur
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Tableau de bord Admin</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <i class="fas fa-user-circle"></i>
                    <span>Admin</span>
                </div>
                <button class="btn btn-logout" >
                <i class="fas fa-sign-out-alt"></i><a  href="../front/logout.php">Déconnexion</a>
                </button>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Youdemy Admin</h3>
        <a href="index.html"><i class="fas fa-home"></i> Accueil</a>
        <a href="gestion-utilisateurs.html"><i class="fas fa-users"></i> Gestion des utilisateurs</a>
        <a href="gestion-cours.html"><i class="fas fa-book"></i> Gestion des cours</a>
        <a href="gestion-categories.html"><i class="fas fa-tags"></i> Gestion des catégories</a>
        <a href="statistiques.html"><i class="fas fa-chart-line"></i> Statistiques</a>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Nombre total de cours</h5>
                    <p>1,234</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Nombre d'étudiants</h5>
                    <p>5,678</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Nombre d'enseignants</h5>
                    <p>123</p>
                </div>
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

    <script src="scripts.js"></script>
</body>
</html>