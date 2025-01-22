<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Admin;
use App\Models\User;
use App\Models\UserRepository;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$adminId = $_SESSION["userId"];
$adminData = $_SESSION["user"]->getId(); 


// Récupérer les informations de l'enseignant depuis la base de données
$adminData = UserRepository::getUserById($adminData);

// Créer une instance de la classe Teacher
$admin = new Admin(
    $adminId,
    $adminData['nom'],
    $adminData['email'],
    $adminData['mot_de_passe'],
    $adminData['role_id'],
    $adminData['date_inscription'],
    $adminData['photo_profil'],
    $adminData['bio'],
    $adminData['pays'],
    $adminData['langue_id'],
    $adminData['statut_id']
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'])) {
        $tagName = trim($_POST['nom']);
        if (!empty($tagName)) {
            if ($admin->addTag($tagName)) {
                echo "<script>alert('Tag ajouté avec succès.'); window.location.href = 'list_tags.php';</script>";
            } else {
                echo "<script>alert('Erreur lors de l\'ajout du tag.');</script>";
            }
        } else {
            echo "<script>alert('Le nom du tag ne peut pas être vide.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Tag - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Ajouter un Tag</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <i class="fas fa-user-circle"></i>
                    <span>Admin</span>
                </div>
                <button class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <a href="#">Déconnexion</a>
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
            <h1>Ajouter un Tag</h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="tag_name" class="form-label">Nom du tag</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter
                </button>
                <a href="list_tags.php" class="btn btn-secondary">Annuler</a>
            </form>
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