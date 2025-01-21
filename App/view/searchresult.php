<?php
// Inclure les classes nécessaires
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\CoursRepository;

// Récupérer le mot-clé de recherche depuis l'URL
$keyword = $_GET['keyword'] ?? '';

// Rechercher les cours correspondants
$results = CoursRepository::searchCourses($keyword);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Youdemy</title>
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

        /* Section des résultats de recherche */
        .search-results-section {
            padding: 60px 0;
            background: var(--background-color);
        }

        .search-results-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            color: var(--text-color);
        }

        .card {
            margin-bottom: 20px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background: var(--light-text-color);
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .card-text {
            font-size: 0.9rem;
            color: #666;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--light-text-color);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
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
            .search-results-section h2 {
                font-size: 1.5rem;
            }

            .card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Youdemy</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
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

    <!-- Section des résultats de recherche -->
    <section class="search-results-section">
        <div class="container">
            <h2>Résultats de recherche pour "<?= htmlspecialchars($keyword) ?>"</h2>
            <div class="row">
                <?php if ($results): ?>
                    <?php foreach ($results as $course): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['titre']) ?></h5>
                                    <p class="card-text">Enseignant : <?= htmlspecialchars($course['enseignant_nom']) ?></p>
                                    <p class="card-text">Catégorie : <?= htmlspecialchars($course['categorie_nom']) ?></p>
                                    <p class="card-text">Prix : <?= htmlspecialchars($course['prix']) ?> €</p>
                                    <a href="login.php" class="btn btn-primary">S'inscrire</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Aucun résultat trouvé pour "<?= htmlspecialchars($keyword) ?>".</p>
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