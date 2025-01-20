<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Admin;
use App\Models\User;

// Instancier la classe Admin
$admin = new Admin(
    1, // ID de l'admin
    'admin_username', // Nom d'utilisateur de l'admin
    'admin@example.com', // Email de l'admin
    'hashed_password', // Mot de passe hashé
    User::ROLE_ADMIN // Rôle de l'admin
);

$tags = $admin->getAllTags();

// recupere l'ID du tag à modifier
$tagId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$tag = null;

if ($tagId) {
    foreach ($tags as $t) {
        if ($t['id'] === $tagId) {
            $tag = $t;
            break;
        }
    }
}

// Gérer la modification du tag
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tag_name'])) {
    $newTagName = trim($_POST['tag_name']);
    if (!empty($newTagName)) {
        if ($admin->updateTag($tagId, $newTagName)) {
            echo "<script>alert('Tag modifié avec succès.'); window.location.href = 'edit_tags.php';</script>";
        } else {
            echo "<script>alert('Erreur lors de la modification du tag.');</script>";
        }
    } else {
        echo "<script>alert('Le nom du tag ne peut pas être vide.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Tag - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Modifier un Tag</h1>
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

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Youdemy Admin</h3>
        <ul class="sidebar-menu">
            <li>
                <a href="?page=dashboard">
                    <i class="fas fa-home"></i> <span>Accueil</span>
                </a>
            </li>
            <li class="has-submenu">
                <a href="#">
                    <i class="fas fa-users"></i> <span>Gestion des utilisateurs</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="?page=validate_teachers">
                            <i class="fas fa-check-circle"></i> <span>Valider les enseignants</span>
                        </a>
                    </li>
                    <li>
                        <a href="list_students.php">
                            <i class="fas fa-user-graduate"></i> <span>Liste des étudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=list_teachers">
                            <i class="fas fa-chalkboard-teacher"></i> <span>Liste des enseignants</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=manage_users">
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
                        <a href="?page=list_tags">
                            <i class="fas fa-list"></i> <span>Liste des tags</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=add_tag">
                            <i class="fas fa-plus-circle"></i> <span>Ajouter un tag</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=edit_tag">
                            <i class="fas fa-edit"></i> <span>Modifier un tag</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=delete_tag">
                            <i class="fas fa-trash"></i> <span>Supprimer un tag</span>
                        </a>
                    </li>
                </ul>
            </li>
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
                        <a href="?page=add_course">
                            <i class="fas fa-plus-circle"></i> <span>Ajouter un cours</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=edit_course">
                            <i class="fas fa-edit"></i> <span>Modifier un cours</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=delete_course">
                            <i class="fas fa-trash"></i> <span>Supprimer un cours</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#">
                    <i class="fas fa-tags"></i> <span>Gestion des catégories</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="?page=list_categories">
                            <i class="fas fa-list"></i> <span>Liste des catégories</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=add_category">
                            <i class="fas fa-plus-circle"></i> <span>Ajouter une catégorie</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=edit_category">
                            <i class="fas fa-edit"></i> <span>Modifier une catégorie</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=delete_category">
                            <i class="fas fa-trash"></i> <span>Supprimer une catégorie</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="?page=statistics">
                    <i class="fas fa-chart-line"></i> <span>Statistiques</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="container mt-4">
            <h1>Modifier un Tag</h1>

            <!-- Liste des tags avec bouton Modifier -->
            <div class="mb-4">
                <h2>Liste des Tags</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du Tag</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tags as $t) : ?>
                            <tr>
                                <td><?= htmlspecialchars($t['id']) ?></td>
                                <td><?= htmlspecialchars($t['nom']) ?></td>
                                <td>
                                    <a href="edit_tags.php?id=<?= $t['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulaire de modification -->
            <?php if ($tag) : ?>
                <div id="formModifier">
                    <h2>Modifier le Tag</h2>
                    <form method="POST">
                        <input type="hidden" name="tag_id" value="<?= $tag['id'] ?>">
                        <div class="mb-3">
                            <label for="tag_name" class="form-label">Nom du tag</label>
                            <input type="text" name="tag_name" class="form-control" value="<?= htmlspecialchars($tag['nom']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="edit_tags.php" class="btn btn-secondary">Annuler</a>
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