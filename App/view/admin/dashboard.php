<?php
// Importer les classes nécessaires
require_once __DIR__. '/../../../vendor/autoload.php';

use App\Models\Admin;
use App\Models\User;
use App\Models\UserRepository;
use App\Models\CoursRepository;



$totalCourses = CoursRepository::getTotalCourses();
$totalStudents = UserRepository::getTotalStudents();
$totalTeachers = UserRepository::getTotalTeachers();

$coursesByMonth = CoursRepository::getCoursesByMonth();
$usersDistribution = UserRepository::getUsersDistribution();

$months = [];
$coursesData = [];
foreach ($coursesByMonth as $course) {
    $months[] = date('M', mktime(0, 0, 0, $course['month'], 10)); // Convertir le numéro du mois en nom (Jan, Fév, etc.)
    $coursesData[] = $course['total'];
}

$usersLabels = [];
$usersData = [];
foreach ($usersDistribution as $user) {
    $usersLabels[] = $user['role'];
    $usersData[] = $user['total'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Youdemy</title>
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
                <h1>Tableau de bord Admin</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <i class="fas fa-user-circle"></i>
                    <span>Admin</span>
                </div>
                <button class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <a href="../front/logout.php">Déconnexion</a>
                </button>
            </div>
        </div>
    </header>

    <div class="sidebar">
        <h3>Youdemy Admin</h3>
        <ul class="sidebar-menu">
            <!-- Accueil -->
            <li>
                <a href="dashboard.php">
                    <i class="fas fa-home"></i> <span>Accueil</span>
                </a>
            </li>

            <!-- Gestion des utilisateurs -->
            <li class="has-submenu">
                <a href="#">
                    <i class="fas fa-users"></i> <span>Gestion des utilisateurs</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="Valide_teacher.php">
                            <i class="fas fa-check-circle"></i> <span>Valider les enseignants</span>
                        </a>
                    </li>
                    <li>
                        <a href="list_students.php">
                            <i class="fas fa-user-graduate"></i> <span>Liste des étudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="list_teachers.php">
                            <i class="fas fa-chalkboard-teacher"></i> <span>Liste des enseignants</span>
                        </a>
                    </li>
                    <li>
                        <a href="user_gestion.php">
                            <i class="fas fa-cogs"></i> <span>Gérer les utilisateurs</span>
                        </a>
                    </li>
                </ul>
            </li>
                 <li class="has-submenu">
    <a href="#">
        <i class="fas fa-tags"></i> <span>Gestion des tags</span>
        <i class="fas fa-chevron-down dropdown-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="list_tags.php">
                <i class="fas fa-list"></i> <span>Liste des tags</span>
            </a>
        </li>
        <li>
            <a href="add_tags.php">
                <i class="fas fa-plus-circle"></i> <span>Ajouter un tag</span>
            </a>
        </li>
        <li>
            <a href="edit_tags.php">
                <i class="fas fa-edit"></i> <span>Modifier un tag</span>
            </a>
        </li>
        <li>
            <a href="delete_tags.php">
                <i class="fas fa-trash"></i> <span>Supprimer un tag</span>
            </a>
        </li>
    </ul>
          </li>

            <!-- Gestion des cours -->
            <li class="has-submenu">
                <a href="#">
                    <i class="fas fa-book"></i> <span>Gestion des cours</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="list_courses.php">
                            <i class="fas fa-list"></i> <span>Liste des cours</span>
                        </a>
                    </li>
                    <li>
                        <a href="validation_course.php">
                            <i class="fas fa-plus-circle"></i> <span>Validation des cours</span>
                        </a>
                    </li>
                   
                    
                </ul>
            </li>

            <!-- Gestion des catégories -->
            <li class="has-submenu">
                <a href="#">
                    <i class="fas fa-tags"></i> <span>Gestion des catégories</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="list_category.php">
                            <i class="fas fa-list"></i> <span>Liste des catégories</span>
                        </a>
                    </li>
                    <li>
                        <a href="add _category.php">
                            <i class="fas fa-plus-circle"></i> <span>Ajouter une catégorie</span>
                        </a>
                    </li>
                    <li>
                        <a href="edit_category.php">
                            <i class="fas fa-edit"></i> <span>Modifier une catégorie</span>
                        </a>
                    </li>
                    <li>
                        <a href="delete_category.php">
                            <i class="fas fa-trash"></i> <span>Supprimer une catégorie</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Statistiques -->
            
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
                    <h5>Nombre d'enseignants</h5>
                    <p><?= $totalTeachers ?></p>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="coursesChart"></canvas>
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
        // Graphique en Secteurs (Répartition des utilisateurs)
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(usersCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($usersLabels) ?>, // Rôles récupérés depuis la base de données
                datasets: [{
                    label: 'Utilisateurs',
                    data: <?= json_encode($usersData) ?>, // Données réelles
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)', // Étudiants
                        'rgba(255, 99, 132, 0.8)', // Enseignants
                        'rgba(75, 192, 192, 0.8)'  // Administrateurs
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Répartition des Utilisateurs'
                    }
                }
            }
        });

        // Graphique en Barres (Nombre de cours par mois)
        const coursesCtx = document.getElementById('coursesChart').getContext('2d');
        const coursesChart = new Chart(coursesCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($months) ?>, // Mois récupérés depuis la base de données
                datasets: [{
                    label: 'Nombre de Cours',
                    data: <?= json_encode($coursesData) ?>, // Données réelles
                    backgroundColor: 'rgba(75, 192, 192, 0.8)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Nombre de Cours par Mois'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

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