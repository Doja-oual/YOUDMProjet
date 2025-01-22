<?php
// Include the class definition for the $user object
require_once __DIR__ . '/../../../vendor/autoload.php'; // Composer autoloader

// Start the session after the class is loaded
session_start();

use App\Models\CoursRepository;
use App\Models\UserRepository;
use App\Models\InscriptionRepository;

// Verify if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../../views/auth/login.php');
    exit();
}

// Retrieve the User object from the session
$user = $_SESSION['user'];

// Retrieve the student ID from the $user object
// Adjust this based on your $user object's structure
$studentId = $user->getId(); // Example: if $user has a getId() method
// OR
// $studentId = $user['id']; // Example: if $user is an associative array
// OR
// $studentId = $user->id; // Example: if $user is an object with a public property

// Retrieve all active courses
$activeCourses = CoursRepository::getActiveCourses();

// Handle course enrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscrire'])) {
    $courseId = $_POST['course_id'];
    
    // Verify if the student is already enrolled in this course
    $isAlreadyEnrolled = UserRepository::isStudentEnrolled($studentId, $courseId);
    
    if (!$isAlreadyEnrolled) {
        // Add the enrollment
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>