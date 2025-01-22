<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\CoursRepository;
use App\Models\Admin;

if (isset($_POST['activer_cours'])) {
    $coursId = $_POST['cours_id'];
    Admin::UpdateStatutCours($coursId);
}

$coursNonActifs = CoursRepository::getCoursNonActifs();
$coursActifs = CoursRepository::getCoursActifs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
    <style>
        .table-style {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-style th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #0056b3;
        }

        .table-style td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .table-style tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .table-style tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-style {
            border-radius: 8px;
            overflow: hidden;
        }

        .table-style .btn {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .table-style .btn-success {
            background-color: #28a745;
            color: white;
        }

        .table-style .btn-success:hover {
            background-color: #218838;
        }

        .table-style .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .table-style .btn-warning:hover {
            background-color: #e0a800;
        }

        @media (max-width: 768px) {
            .table-style {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
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

    <div class="main-content">
        <div class="container mt-4">
            <h2>Cours Non Actifs</h2>
            <table class="table-style">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Enseignant</th>
                        <th>Date de Création</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coursNonActifs as $cours): ?>
                        <tr>
                            <td><?= htmlspecialchars($cours['titre']) ?></td>
                            <td><?= htmlspecialchars($cours['description']) ?></td>
                            <td><?= htmlspecialchars($cours['enseignant_nom']) ?></td>
                            <td><?= htmlspecialchars($cours['date_creation']) ?></td>
                            <td>Non actif</td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="cours_id" value="<?= $cours['id'] ?>">
                                    <button type="submit" name="activer_cours" class="btn btn-success">
                                        Activer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2 class="mt-5">Cours Actifs</h2>
            <table class="table-style">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Enseignant</th>
                        <th>Date de Création</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coursActifs as $cours): ?>
                        <tr>
                            <td><?= htmlspecialchars($cours['titre']) ?></td>
                            <td><?= htmlspecialchars($cours['description']) ?></td>
                            <td><?= htmlspecialchars($cours['enseignant_nom']) ?></td>
                            <td><?= htmlspecialchars($cours['date_creation']) ?></td>
                            <td>Actif</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

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