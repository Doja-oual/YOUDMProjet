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
    // header('Location: login.php');
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

$teacherStatistics = $teacher->getTeacherStatistics();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Enseignant</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Styles personnalisés -->
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .chart-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h1, h2 {
            text-align: center;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Statistiques Enseignant</h1>

        <!-- Graphique 1 : Nombre total de cours -->
        <div class="chart-container">
            <h2>Nombre total de cours</h2>
            <canvas id="totalCoursesChart"></canvas>
        </div>

        <!-- Graphique 2 : Nombre total d'étudiants -->
        <div class="chart-container">
            <h2>Nombre total d'étudiants</h2>
            <canvas id="totalStudentsChart"></canvas>
        </div>

        <!-- Graphique 3 : Cours le plus populaire -->
        <div class="chart-container">
            <h2>Cours le plus populaire</h2>
            <canvas id="mostPopularCourseChart"></canvas>
        </div>
    </div>

    <!-- Script pour initialiser les graphiques -->
    <script>
        // Données pour le graphique "Nombre total de cours"
        const totalCoursesData = {
            labels: ['Cours'],
            datasets: [{
                label: 'Nombre total de cours',
                data: [<?= $teacherStatistics['total_courses'] ?>],
                backgroundColor: ['#2F80ED'],
                borderColor: ['#2F80ED'],
                borderWidth: 1
            }]
        };

        // Configuration du graphique "Nombre total de cours"
        const totalCoursesConfig = {
            type: 'bar',
            data: totalCoursesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Nombre total de cours'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Initialisation du graphique "Nombre total de cours"
        const totalCoursesChart = new Chart(
            document.getElementById('totalCoursesChart'),
            totalCoursesConfig
        );

        // Données pour le graphique "Nombre total d'étudiants"
        const totalStudentsData = {
            labels: ['Étudiants'],
            datasets: [{
                label: 'Nombre total d\'étudiants',
                data: [<?= $teacherStatistics['total_students'] ?>],
                backgroundColor: ['#F2994A'],
                borderColor: ['#F2994A'],
                borderWidth: 1
            }]
        };

        // Configuration du graphique "Nombre total d'étudiants"
        const totalStudentsConfig = {
            type: 'bar',
            data: totalStudentsData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Nombre total d\'étudiants'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Initialisation du graphique "Nombre total d'étudiants"
        const totalStudentsChart = new Chart(
            document.getElementById('totalStudentsChart'),
            totalStudentsConfig
        );

        // Données pour le graphique "Cours le plus populaire"
        const mostPopularCourseData = {
            labels: ['Cours le plus populaire'],
            datasets: [{
                label: 'Cours le plus populaire',
                data: [1], // Valeur statique pour représenter le cours le plus populaire
                backgroundColor: ['#6FCF97'],
                borderColor: ['#6FCF97'],
                borderWidth: 1
            }]
        };

        // Configuration du graphique "Cours le plus populaire"
        const mostPopularCourseConfig = {
            type: 'bar',
            data: mostPopularCourseData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Cours le plus populaire : <?= $teacherStatistics['most_popular_course'] ?>'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Initialisation du graphique "Cours le plus populaire"
        const mostPopularCourseChart = new Chart(
            document.getElementById('mostPopularCourseChart'),
            mostPopularCourseConfig
        );
    </script>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>