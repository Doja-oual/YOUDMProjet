<?php
// Inclure les classes nécessaires
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\CoursRepository;

// Récupérer les cours gratuits
$freeCourses = CoursRepository::getFreeCoursesWithDetailsGratuit();

// Récupérer les cours actifs
$activeCourses = CoursRepository::getActiveCoursesWithDetails();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Plateforme de cours en ligne</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        /* Couleurs principales */
        :root {
            --primary-color: #2F80ED; /* Bleu Youdemy */
            --secondary-color: #F2994A; /* Orange */
            --text-color: #333;
            --light-text-color: #fff;
            --background-color: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        /* En-tête */
        header {
            background: var(--primary-color);
            color: var(--light-text-color);
            padding: 20px 0;
        }

        header .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }

        header .nav-link {
            color: var(--light-text-color);
            margin: 0 10px;
            font-weight: 500;
        }

        header .nav-link:hover {
            color: var(--secondary-color);
        }

        header .btn-light {
            background: var(--light-text-color);
            color: var(--primary-color);
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        header .btn-light:hover {
            background: var(--secondary-color);
            color: var(--light-text-color);
        }

        /* Barre de recherche */
        header .search-bar {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 8px 15px;
            margin-left: 20px;
        }

        header .search-bar input {
            background: transparent;
            border: none;
            color: var(--light-text-color);
            outline: none;
            margin-left: 10px;
            width: 200px;
        }

        header .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        header .search-bar i {
            color: var(--light-text-color);
        }

        /* Section principale */
        .main-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 100px 0;
            color: var(--light-text-color);
        }

        .main-section .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .main-section .text-content {
            flex: 1;
            max-width: 50%;
            padding-right: 20px;
        }

        .main-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .main-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .main-section .btn-primary {
            background: var(--light-text-color);
            color: var(--primary-color);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .main-section .btn-primary:hover {
            background: var(--secondary-color);
            color: var(--light-text-color);
        }

        .main-section .image-content {
            flex: 1;
            max-width: 50%;
            text-align: center;
        }

        .main-section img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Section des cours gratuits */
        .free-courses-section {
            padding: 60px 0;
            background: var(--background-color);
        }

        .free-courses-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            color: var(--text-color);
        }

        .free-courses-section .card {
            background: var(--light-text-color);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .free-courses-section .card:hover {
            transform: translateY(-10px);
        }

        .free-courses-section .card img {
            border-radius: 15px 15px 0 0;
        }

        .free-courses-section .card-body {
            padding: 20px;
        }

        .free-courses-section .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .free-courses-section .card-text {
            font-size: 0.9rem;
            color: #666;
        }

        .free-courses-section .btn-primary {
            background: var(--primary-color);
            color: var(--light-text-color);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .free-courses-section .btn-primary:hover {
            background: var(--secondary-color);
        }

        /* Section des cours actifs */
        .active-courses-section {
            padding: 60px 0;
            background: var(--background-color);
        }

        .active-courses-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            color: var(--text-color);
        }

        .active-courses-section .card {
            background: var(--light-text-color);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .active-courses-section .card:hover {
            transform: translateY(-10px);
        }

        .active-courses-section .card-body {
            padding: 20px;
        }

        .active-courses-section .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .active-courses-section .card-text {
            font-size: 0.9rem;
            color: #666;
        }

        .active-courses-section .btn-primary {
            background: var(--primary-color);
            color: var(--light-text-color);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .active-courses-section .btn-primary:hover {
            background: var(--secondary-color);
        }

        /* Pied de page */
        footer {
            background: var(--text-color);
            color: var(--light-text-color);
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: var(--light-text-color);
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--secondary-color);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .main-section .container {
                flex-direction: column;
                text-align: center;
            }

            .main-section .text-content,
            .main-section .image-content {
                max-width: 100%;
                padding-right: 0;
            }

            .main-section .image-content {
                margin-top: 30px;
            }

            header .search-bar {
                margin-left: 0;
                margin-top: 10px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Youdemy</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Barre de recherche -->
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <form action="searchresult.php" method="GET">
                            <input type="text" name="keyword" placeholder="Rechercher des cours...">
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </form>
                    </div>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pour les entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pour les universités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pour les gouvernements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light" href="register.php">Inscrivez-vous gratuitement</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Section principale -->
    <section class="main-section">
        <div class="container">
            <!-- Contenu texte -->
            <div class="text-content">
                <h1>Nouvelle année. De grands objectifs. Des économies plus importantes.</h1>
                <p>Atteignez vos objectifs professionnels grâce à un accès illimité d'un an à plus de 1000 programmes d'apprentissage de Google, Microsoft, IBM et bien d'autres encore, avec une réduction de 65%.</p>
                <a href="#" class="btn btn-primary">Économiser</a>
                <a href="catalogue.php" class="btn btn-secondary">Voir le catalogue complet</a>

            </div>
            <!-- Image -->
            <div class="image-content">
                <img src="https://th.bing.com/th/id/OIP.S2JVcWkwudJBDVHtJME3dAHaHa?rs=1&pid=ImgDetMain" alt="Image de promotion Youdemy">
            </div>
        </div>
    </section>

    <!-- Section des cours gratuits -->
    <section class="free-courses-section">
        <div class="container">
            <h2>Commencez à apprendre avec des cours gratuits</h2>
            <p class="text-center mb-4">Découvrez les cours en ligne gratuits, proposés par les meilleures universités et entreprises au monde.</p>
            <div class="row">
                <?php if ($freeCourses): ?>
                    <?php foreach ($freeCourses as $course): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="../../public/assets/image/imageCourse.png" class="card-img-top" alt="image">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['cours_titre']) ?></h5>
                                    <p class="card-text">Enseignant : <?= htmlspecialchars($course['enseignant_nom']) ?></p>
                                    <p class="card-text">Catégorie : <?= htmlspecialchars($course['categorie_nom']) ?></p>
                                    <p class="card-text">Prix : <?= htmlspecialchars($course['prix']) ?> €</p>
                                    <a href="login.php" class="btn btn-primary">S'inscrire</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Aucun cours gratuit disponible pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section des cours actifs -->
    <section class="active-courses-section">
        <div class="container">
            <h2>Cours de youdemy</h2>
            <div class="row">
                <?php if ($activeCourses): ?>
                    <?php foreach ($activeCourses as $course): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['cours_titre']) ?></h5>
                                    <p class="card-text">Enseignant : <?= htmlspecialchars($course['enseignant_nom']) ?></p>
                                    <p class="card-text">Catégorie : <?= htmlspecialchars($course['categorie_nom']) ?></p>
                                    <a href="login.php" class="btn btn-primary">S'inscrire</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Aucun cours actif disponible pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

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