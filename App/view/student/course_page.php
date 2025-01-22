<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Student;
use App\Models\CoursRepository;
use App\Models\EvaluationRepository;
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../views/auth/login.php');
    exit();
}

$user = $_SESSION['user'];
$studentId = $user->getId(); 

$courseId = (int)$_GET['course_id'] ?? null;

if (!$courseId) {
    die("ID du cours non spécifié.");
}

$course=new CoursRepository();
$student = new Student($user);

$courseDetails=$course->getCourseById($courseId);

if (!$courseDetails) {
    die("Cours non trouvé.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_course'])) {
    if ($student->getCompletedCourses($studentId, $courseId)) {
        $successMessage = "Le cours a été marqué comme terminé !";
    } else {
        $errorMessage = "Erreur lors de la mise à jour du cours.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_evaluation'])) {
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';

    if ($rating && EvaluationRepository::addEvaluation($studentId, $courseId, $rating, $comment)) {
        $successMessage = "Votre évaluation a x enregistrée !";
    } else {
        $errorMessage = "Erreur lors de l'enregistrement de l'évaluation.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($courseDetails['titre']) ?> - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .course-content {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-complete {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-complete:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
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



       <div class="container mt-4">
        <h1><?= htmlspecialchars($courseDetails['titre']) ?></h1>

        <!-- Messages de succès ou d'erreur -->
        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <!-- Contenu du cours -->
        <div class="course-content">
            <h2>Description du cours</h2>
            <p><?= htmlspecialchars($courseDetails['description']) ?></p>
            <p><strong>contenu :</strong> <?= htmlspecialchars($courseDetails['contenu']) ?></p>
        </div>

        <!-- Bouton "Terminer le cours" -->
        <form method="POST" class="mb-4">
            <button type="submit" name="complete_course" class="btn-complete">Terminer le cours</button>
        </form>

        <!-- Formulaire d'évaluation -->
        <h2>Évaluer ce cours</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="rating" class="form-label">Note (1-5)</label>
                <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Commentaire (optionnel)</label>
                <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="submit_evaluation" class="btn btn-primary">Soumettre l'évaluation</button>
        </form>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></body>
      </html>
      &tg