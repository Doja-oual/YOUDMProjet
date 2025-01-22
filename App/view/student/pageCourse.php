<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; // Composer autoloader

session_start();

use App\Models\CoursRepository;
use App\Models\UserRepository;
use App\Models\InscriptionRepository;

// Verify if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../../views/auth/login.php');
    exit();
}

$user = $_SESSION['user'];
$studentId = $user->getId(); 

$activeCourses = CoursRepository::getActiveCourses();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscrire'])) {
    $courseId = $_POST['course_id'];
    
    $isAlreadyEnrolled = UserRepository::isStudentEnrolled($studentId, $courseId);
    
    if (!$isAlreadyEnrolled) {
        if (InscriptionRepository::addInscription($studentId, $courseId)) {
            $successMessage = "Inscription réussie !";
        } else {
            $errorMessage = "Erreur lors de l'inscription.";
        }
    } else {
        $errorMessage = "Vous êtes déjà inscrit à ce cours.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours Actifs - Youdemy</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
    <style>
        /* Custom Styles */
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
        .btn-inscrire {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-inscrire:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Header -->
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
                            <a class="nav-link active" href="pageCourse.php">Cours</a>
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

    <!-- Main Content -->
    <main class="dashboard">
        <div class="container mt-4">
            <h1>Cours Actifs</h1>

            <!-- Success or error messages -->
            <?php if (isset($successMessage)) : ?>
                <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
            <?php endif; ?>

            <!-- List of active courses -->
            <?php if ($activeCourses) : ?>
                <div class="row">
                    <?php foreach ($activeCourses as $course) : ?>
                        <div class="col-md-4">
                            <div class="course-card">
                                <h3><?= htmlspecialchars($course['titre']) ?></h3>
                                <p><?= htmlspecialchars($course['description']) ?></p>
                                <p><strong>Enseignant :</strong> <?= htmlspecialchars($course['enseignant_nom']) ?></p>
                                <p><strong>Catégorie :</strong> <?= htmlspecialchars($course['categorie_nom']) ?></p>
                                <form method="POST">
                                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                    <button type="submit" name="inscrire" class="btn-inscrire">S'inscrire</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-center">Aucun cours actif disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>