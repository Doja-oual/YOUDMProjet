<?php
session_start(); // Démarrer la session pour stocker des messages temporaires
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Teacher;
use App\Models\UserRepository;

// Vérifier si l'enseignant est connecté
    // if (!isset($_SESSION['teacher_id'])) {
    //     header('Location: ho;.php');
    //     exit();
    // }

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

// Gérer la suppression du cours
if (isset($_GET['delete_id'])) {
    $courseId = (int)$_GET['delete_id'];
    if ($teacher->deleteCourse($courseId)) {
        $_SESSION['message'] = "Cours supprimé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression du cours.";
    }
    header('Location: delete_course.php');
    exit();
}

// Récupérer tous les cours de l'enseignant
$courses = $teacher->getMyCourses();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Cours - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css"> 
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Supprimer un Cours</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <i class="fas fa-user-circle"></i>
                    <span><?= htmlspecialchars($teacherData['username']) ?></span>
                </div>
                <button class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <a href="logout.php">Déconnexion</a>
                </button>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Youdemy Enseignant</h3>
        <ul class="sidebar-menu">
            <li>
                <a href="?page=dashboard">
                    <i class="fas fa-home"></i> <span>Accueil</span>
                </a>
            </li>
            <li class="has-submenu">
                <a href="#">
                    <i class="fas fa-book"></i> <span>Gestion des cours</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="add_course.php">
                            <i class="fas fa-plus-circle"></i> <span>Ajouter un cours</span>
                        </a>
                    </li>
                    <li>
                        <a href="my_courses.php">
                            <i class="fas fa-list"></i> <span>Mes cours</span>
                        </a>
                    </li>
                    <li>
                        <a href="delete_course.php">
                            <i class="fas fa-trash"></i> <span>Supprimer un cours</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="update_profile.php">
                    <i class="fas fa-user-edit"></i> <span>Mettre à jour le profil</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="container mt-4">
            <h1>Supprimer un Cours</h1>

            <!-- Afficher un message de confirmation ou d'erreur -->
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-info">
                    <?= $_SESSION['message'] ?>
                </div>
                <?php unset($_SESSION['message']); // Supprimer le message après l'affichage ?>
            <?php endif; ?>

            <div class="mb-4">
                <h2>Liste des Cours</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course) : ?>
                            <tr>
                                <td><?= htmlspecialchars($course['id']) ?></td>
                                <td><?= htmlspecialchars($course['titre']) ?></td>
                                <td><?= htmlspecialchars($course['description']) ?></td>
                                <td>
                                    <a href="delete_course.php?delete_id=<?= $course['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <p>&copy; 2023 Youdemy. Tous droits réservés.</p>
            </div>
            <div class="footer-right">
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-shield-alt"></i> Politique de confidentialité</a></li>
                    <li><a href="#"><i class="fas fa-file-contract"></i> Conditions d'utilisation</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const submenuToggles = document.querySelectorAll(".has-submenu > a");

            submenuToggles.forEach((toggle) => {
                toggle.addEventListener("click", function (e) {
                    e.preventDefault();
                    const parent = this.parentElement;

                    submenuToggles.forEach((otherToggle) => {
                        if (otherToggle !== toggle) {
                            otherToggle.parentElement.classList.remove("active");
                        }
                    });

                    parent.classList.toggle("active");
                });
            });
        });
    </script>
</body>
</html>