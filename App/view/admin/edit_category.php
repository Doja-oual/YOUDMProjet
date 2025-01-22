<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Admin;
use App\Models\User;
use App\Models\UserRepository;


session_start();
$adminId = $_SESSION["userId"];
$adminData = $_SESSION["user"]->getId(); 


$adminData = UserRepository::getUserById($adminData);

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

$categories = $admin->getAllCategories();

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$category = null;

if ($categoryId) {
    foreach ($categories as $c) {
        if ($c['id'] === $categoryId) {
            $category = $c;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $newCategoryName = trim($_POST['category_name']);
    if (!empty($newCategoryName)) {
        if ($admin->updateCategory($categoryId, $newCategoryName)) {
            echo "<script>alert('Catégorie modifiée avec succès.'); window.location.href = 'edit_category.php';</script>";
        } else {
            echo "<script>alert('Erreur lors de la modification de la catégorie.');</script>";
        }
    } else {
        echo "<script>alert('Le nom de la catégorie ne peut pas être vide.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Catégorie - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css"> <!-- Lien vers le fichier CSS -->
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

    <!-- Sidebar -->
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
        <div class="container mt-4">
            <h1>Modifier une Catégorie</h1>

            <!-- Liste des catégories avec bouton Modifier -->
            <div class="mb-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom de la Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $c) : ?>
                            <tr>
                                <td><?= htmlspecialchars($c['id']) ?></td>
                                <td><?= htmlspecialchars($c['nom']) ?></td>
                                <td>
                                    <a href="edit_category.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulaire de modification -->
            <?php if ($category) : ?>
                <div id="formModifier">
                    <h2>Modifier la Catégorie</h2>
                    <form method="POST">
                        <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Nom de la catégorie</label>
                            <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($category['nom']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="edit_category.php" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            <?php endif; ?>
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