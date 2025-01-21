<?php
// Inclure l'autoloader de Composer pour charger les classes
require_once __DIR__ . '/../../../vendor/autoload.php';

// Importer les classes nécessaires
use App\Models\Teacher;
use App\Models\UserRepository;

// Démarrer la session pour accéder aux données de l'utilisateur connecté
session_start();

// Vérifier si l'enseignant est connecté
if (!isset($_SESSION['teacher_id'])) {
    // Rediriger vers la page de connexion si l'enseignant n'est pas connecté
    header('Location: login.php');
    exit();
}

// Récupérer l'ID de l'enseignant connecté depuis la session
$teacherId = $_SESSION['teacher_id'];

// Récupérer les informations de l'enseignant depuis la base de données
$teacherData = UserRepository::getUserById($teacherId);

// Créer une instance de la classe Teacher
$teacher = new Teacher(
    $teacherId,
    $teacherData['username'],
    $teacherData['email'],
    $teacherData['passwordHash'],
    $teacherData['role'],
    $teacherData['dateInscription'],
    $teacherData['photoProfil'],
    $teacherData['bio'],
    $teacherData['pays'],
    $teacherData['langueId'],
    $teacherData['statutId']
);

// Vérifier si un cours doit être supprimé
if (isset($_GET['delete_id'])) {
    $courseId = (int) $_GET['delete_id'];

    // Supprimer le cours en utilisant la méthode de la classe Teacher
    if ($teacher->deleteCourse($courseId)) {
        // Rediriger vers la même page pour éviter la soumission multiple du formulaire
        header('Location: delete_course.php');
        exit();
    } else {
        echo "Une erreur s'est produite lors de la suppression du cours.";
    }
}

// Récupérer les cours de l'enseignant
$myCourses = $teacher->getMyCourses();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Cours</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .course-list {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h1 {
            text-align: center;
            color: #343a40;
        }

        .btn-danger {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Mes Cours</h1>

        <div class="course-list">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($myCourses as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['titre']) ?></td>
                            <td><?= htmlspecialchars($course['description']) ?></td>
                            <td>
                                <a href="delete_course.php?delete_id=<?= $course['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>