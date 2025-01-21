<?php
require_once __DIR__. '/../../../vendor/autoload.php';

use App\Models\Teacher;
use App\Models\CoursRepository;
use App\Models\User; // Importation de la classe User

// Créer une instance de la classe Teacher (simulée pour l'exemple)
$teacher = new Teacher(
    1, // ID de l'enseignant
    'TeacherName', // Nom de l'enseignant
    'teacher@example.com', // Email de l'enseignant
    'hashed_password', // Mot de passe hashé
    User::ROLE_ENSEIGNANT, // Rôle (enseignant)
    '2023-01-01', // Date d'inscription
    'profile.jpg', // Photo de profil
    'Bio de l\'enseignant', // Bio
    'Pays', // Pays
    1, // Langue ID
    1 // Statut ID
);

// Récupérer les statistiques de l'enseignant
$totalCourses = CoursRepository::getTotalCoursesByTeacher($teacher->getId());
$totalStudents = CoursRepository::getTotalStudentsByTeacher($teacher->getId());
$mostPopularCourse = CoursRepository::getMostPopularCourseByTeacher($teacher->getId());

session_start();
$userId = $_SESSION["user"]->getId(); 
// echo $userId; 
// Récupérer les cours de l'enseignant
$myCourses = $teacher->getMyCourses();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Enseignant - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Styles pour les cartes de statistiques */
        .stat-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-card h5 {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 2rem;
            font-weight: bold;
            color: #343a40;
            margin: 0;
        }

        /* Styles pour les conteneurs de graphiques */
        .chart-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Tableau de bord Enseignant</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <i class="fas fa-user-circle"></i>
                    <!-- <span><?= $teacher->getProfile()['name'] ?></span> -->
                </div>
                <button class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <a href="#">Déconnexion</a>
                </button>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Youdemy Enseignant</h3>
        <ul class="sidebar-menu">
            <!-- Accueil -->
            <li>
                <a href="?page=dashboard">
                    <i class="fas fa-home"></i> <span>Accueil</span>
                </a>
            </li>

            <!-- Gestion des cours -->
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
                        <a href="course_statistics.php">
                            <i class="fas fa-chart-line"></i> <span>Statistiques des cours</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Profil -->
            <li>
                <a href="update_profile.php">
                    <i class="fas fa-user-edit"></i> <span>Mettre à jour le profil</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <!-- Cartes de Statistiques -->
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Nombre total de cours</h5>
                    <p><?= $totalCourses ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Nombre d'étudiants</h5>
                    <p><?= $totalStudents ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Cours le plus populaire</h5>
                    <p><?= $mostPopularCourse ?></p>
                </div>
            </div>
        </div>

        <!-- Liste des cours -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="chart-container">
                    <h4>Mes Cours</h4>
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
                                    <td><?= $course['title'] ?></td>
                                    <td><?= $course['description'] ?></td>
                                    <td>
                                        <a href="update_course.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="delete_course.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-danger">
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

    <!-- Scripts JavaScript -->
    <script>
        // Script pour gérer les sous-menus de la sidebar
        document.addEventListener("DOMContentLoaded", function () {
            const submenuToggles = document.querySelectorAll(".has-submenu > a");

            submenuToggles.forEach((toggle) => {
                toggle.addEventListener("click", function (e) {
                    e.preventDefault(); // Empêcher le lien de rediriger
                    const parent = this.parentElement;

                    // Fermer tous les autres sous-menus ouverts
                    submenuToggles.forEach((otherToggle) => {
                        if (otherToggle !== toggle) {
                            otherToggle.parentElement.classList.remove("active");
                        }
                    });

                    // Ouvrir/fermer le sous-menu actuel
                    parent.classList.toggle("active");
                });
            });
        });
    </script>
</body>
</html>