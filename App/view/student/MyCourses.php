<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\User;
use App\Models\Student;
use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\InscriptionRepository;

session_start();

if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ../../views/auth/login.php');
    exit();
}

$user = $_SESSION['user'];

if (!($user instanceof User)) {
    die("Erreur : L'objet dans la session n'est pas une instance de User.");
}

$student = new Student($user);

$enrolledCourses = $student->getMyCourse($student->getId());

$completedCourses = $student->getCompletedCoursesByTeacher($student->getId());
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord étudiant - Youdemy</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
    <style>
        /* Styles personnalisés */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .course-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .course-card h3 {
            margin-top: 0;
        }
        .progress {
            height: 20px;
            margin-bottom: 10px;
        }
        .progress-bar {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="home.php">Youdemy</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="student.php">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pageCourse.php">Cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="MyCourses.php">Mes cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Cirtificat.php">Certifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light" href="../front/logout.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenu principal -->
    <main class="dashboard">
        <div class="container mt-4">
            <!-- Section de bienvenue -->
            <section class="welcome-section">
                <h1>Bienvenue, <span class="student-name"><?= htmlspecialchars($student->getUsername()) ?></span> !</h1>
                <p>Voici vos cours en cours et vos cours terminés.</p>
            </section>

            <!-- Cours en cours -->
            <section class="ongoing-courses">
                <h2>Mes cours en cours</h2>
                <div class="row">
                    <?php if (!empty($enrolledCourses)) : ?>
                        <?php foreach ($enrolledCourses as $course) : ?>
                            <div class="col-md-4">
                                <div class="course-card">
                                    <h3><?= htmlspecialchars($course['titre']) ?></h3>
                                    <p><?= htmlspecialchars($course['description']) ?></p>
                                    <a href="course_page.php?course_id=<?= $course['id'] ?>" class="btn btn-primary mt-3">Continuer</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Aucun cours en cours pour le moment.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Cours terminés -->
            <section class="completed-courses">
                <h2>Mes cours terminés</h2>
                <div class="row">
                    <?php if (!empty($completedCourses)) : ?>
                        <?php foreach ($completedCourses as $course) : ?>
                            <div class="col-md-4">
                                <div class="course-card">
                                    <h3><?= htmlspecialchars($course['titre']) ?></h3>
                                    <p><?= htmlspecialchars($course['description']) ?></p>
                                    <p><strong>Enseignant :</strong> <?= htmlspecialchars($course['enseignant_nom']) ?></p>
                                    <p><strong>Date de fin :</strong> <?= htmlspecialchars($course['date_fin']) ?></p>
                                    <a href="#" class="btn btn-success mt-3">Voir le certificat</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Aucun cours terminé pour le moment.</p>
                    <?php endif; ?>
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

    <!-- Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>