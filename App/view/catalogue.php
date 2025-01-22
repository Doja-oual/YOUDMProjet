<?php
// Inclure les classes nécessaires
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\CoursRepository;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; 

$courses = CoursRepository::getCoursesWithPagination($page, $perPage);

$totalCourses = CoursRepository::countAllCourses();

// Calculer le nombre total de pages
$totalPages = ceil($totalCourses / $perPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des cours - Youdemy</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        /* Utilisez les mêmes styles que la page d'accueil */
        :root {
            --primary-color: #2F80ED;
            --secondary-color: #F2994A;
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

        .catalogue-section {
            padding: 60px 0;
            background: var(--background-color);
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

        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .pagination .page-link:hover {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--primary-color);">
            <div class="container">
                <a class="navbar-brand" href="home.php">Youdemy</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="catalogue.php">Catalogue</a>
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

    <!-- Section du catalogue -->
    <section class="catalogue-section">
        <div class="container">
            <h2 class="text-center mb-4">Catalogue des cours</h2>
            <div class="row">
                <?php if ($courses): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['titre']) ?></h5>
                                    <p class="card-text">Enseignant : <?= htmlspecialchars($course['enseignant_nom']) ?></p>
                                    <p class="card-text">Catégorie : <?= htmlspecialchars($course['categorie_nom']) ?></p>
                                    <p class="card-text">Prix : <?= htmlspecialchars($course['prix']) ?> €</p>
                                    <a href="#" class="btn btn-primary">S'inscrire</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Aucun cours disponible pour le moment.</p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="catalogue.php?page=<?= $page - 1 ?>" aria-label="Précédent">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="catalogue.php?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="catalogue.php?page=<?= $page + 1 ?>" aria-label="Suivant">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </section>

    <!-- Pied de page -->
    <footer style="background: var(--text-color); color: var(--light-text-color); padding: 20px 0; text-align: center;">
        <div class="container">
            <p>&copy; 2024 Youdemy. Tous droits réservés.</p>
            <p>
                <a href="#" style="color: var(--light-text-color);">Politique de confidentialité</a> |
                <a href="#" style="color: var(--light-text-color);">Conditions d'utilisation</a> |
                <a href="#" style="color: var(--light-text-color);">Mentions légales</a>
            </p>
        </div>
    </footer>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>