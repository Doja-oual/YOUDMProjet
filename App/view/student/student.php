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
    <title>Tableau de bord étudiant - Youdemy</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Lien vers le fichier CSS personnalisé -->
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">Youdemy</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Mes cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Certifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light" href="../front/logout.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Section principale -->
    <main class="dashboard">
        <div class="container">
            <!-- Bienvenue -->
            <section class="welcome-section">
                <h1>Bienvenue, <span class="student-name">Mohamed</span> !</h1>
                <p>Commencez votre parcours d'apprentissage dès aujourd'hui.</p>
            </section>

            <!-- Cours en cours -->
            <section class="ongoing-courses">
                <h2>Mes cours en cours</h2>
                <div class="row">
                    <!-- Cours 1 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 1">
                            <div class="card-body">
                                <h5 class="card-title">Développement Web</h5>
                                <p class="card-text">Apprenez à créer des sites web modernes avec HTML, CSS et JavaScript.</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                </div>
                                <a href="#" class="btn btn-primary mt-3">Continuer</a>
                            </div>
                        </div>
                    </div>
                    <!-- Cours 2 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 2">
                            <div class="card-body">
                                <h5 class="card-title">Marketing Digital</h5>
                                <p class="card-text">Maîtrisez les stratégies de marketing en ligne pour booster votre entreprise.</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                                </div>
                                <a href="#" class="btn btn-primary mt-3">Continuer</a>
                            </div>
                        </div>
                    </div>
                    <!-- Cours 3 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 3">
                            <div class="card-body">
                                <h5 class="card-title">Data Science</h5>
                                <p class="card-text">Explorez les données et apprenez à utiliser Python pour l'analyse de données.</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                </div>
                                <a href="#" class="btn btn-primary mt-3">Continuer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Certifications -->
            <section class="certifications">
                <h2>Mes certifications</h2>
                <div class="row">
                    <!-- Certification 1 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Certification 1">
                            <div class="card-body">
                                <h5 class="card-title">Certification HTML/CSS</h5>
                                <p class="card-text">Certification en développement web de base.</p>
                                <a href="#" class="btn btn-primary">Voir la certification</a>
                            </div>
                        </div>
                    </div>
                    <!-- Certification 2 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Certification 2">
                            <div class="card-body">
                                <h5 class="card-title">Certification Marketing Digital</h5>
                                <p class="card-text">Certification en stratégies de marketing en ligne.</p>
                                <a href="#" class="btn btn-primary">Voir la certification</a>
                            </div>
                        </div>
                    </div>
                    <!-- Certification 3 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Certification 3">
                            <div class="card-body">
                                <h5 class="card-title">Certification Python</h5>
                                <p class="card-text">Certification en programmation Python pour la data science.</p>
                                <a href="#" class="btn btn-primary">Voir la certification</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recommandations de cours -->
            <section class="recommended-courses">
                <h2>Recommandations de cours</h2>
                <div class="row">
                    <!-- Cours 1 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 1">
                            <div class="card-body">
                                <h5 class="card-title">Intelligence Artificielle</h5>
                                <p class="card-text">Découvrez les bases de l'IA et du machine learning.</p>
                                <a href="#" class="btn btn-primary">Commencer</a>
                            </div>
                        </div>
                    </div>
                    <!-- Cours 2 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 2">
                            <div class="card-body">
                                <h5 class="card-title">Cybersécurité</h5>
                                <p class="card-text">Apprenez à protéger les systèmes contre les cyberattaques.</p>
                                <a href="#" class="btn btn-primary">Commencer</a>
                            </div>
                        </div>
                    </div>
                    <!-- Cours 3 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 3">
                            <div class="card-body">
                                <h5 class="card-title">Gestion de projet</h5>
                                <p class="card-text">Maîtrisez les outils et techniques de gestion de projet.</p>
                                <a href="#" class="btn btn-primary">Commencer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Pied de page -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Youdemy. Tous droits réservés.</p>
            <p>
                <a href="#">Politique de confidentialité</a> |
                <a href="#">Conditions d'utilisation</a> |
                <a href="#">Mentions légales</a>
            </p>
        </div>
    </footer>
    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>