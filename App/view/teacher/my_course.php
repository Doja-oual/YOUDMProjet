<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Teacher;
use App\Models\CoursRepository;

// Démarrer la session pour accéder aux données de l'utilisateur connecté
session_start();

// Vérifier si l'enseignant est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'enseignant n'est pas connecté
    header('Location: ../front/Auth.php');
    exit();
}


// Récupérer l'ID de l'enseignant connecté depuis la session
$teacherId = $_SESSION["user"]->getId();

$teacher = new Teacher(
    $teacherId,
    $_SESSION["user"]->getUsername(),
    $_SESSION["user"]->getEmail(),
    $_SESSION["user"]->getPasswordHash(),
    $_SESSION["user"]->getRole(),
    $_SESSION["user"]->getDateInscription(),
    $_SESSION["user"]->getPhotoProfil(),
    $_SESSION["user"]->getBio(),
    $_SESSION["user"]->getPays(),
    $_SESSION["user"]->getLangueId(),
    $_SESSION["user"]->getStatutId()
);
// Récupérer les cours de l'enseignant
$courseRepository = new CoursRepository();
$courses = $courseRepository->getCoursesByTeacherId($teacherId);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-course'])) {
    $courseId = $_POST['courseId'];
    $teacher->deleteCourse($courseId);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .course-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .course-card h3 {
            color: #2F80ED;
            font-weight: 700;
        }

        .btn-edit {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(47, 128, 237, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Mes Cours</h1>
        <?php if (empty($courses)) : ?>
            <div class="alert alert-info">Vous n'avez pas encore créé de cours.</div>
        <?php else : ?>
            <?php foreach ($courses as $course) : ?>
                <div class="course-card">
                    <h3><?= htmlspecialchars($course['titre']) ?></h3>
                    <p><?= htmlspecialchars($course['description']) ?></p>
                    <p><strong>Niveau :</strong> <?= htmlspecialchars($course['niveau']) ?></p>
                    <p><strong>Durée :</strong> <?= htmlspecialchars($course['duree']) ?> minutes</p>
                    <p><strong>Prix :</strong> <?= htmlspecialchars($course['prix']) ?> €</p>
                    <form action="" method="post">
                        <a href="edit_course.php?id=<?= $course['id'] ?>" class="btn btn-edit">Modifier</a>
                        <input type="hidden" name="courseId" value="<?= $course['id'] ?>">
                        <button class="btn btn-edit" type="submit" name="delete-course">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>