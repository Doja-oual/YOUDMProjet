<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Admin;
use App\Models\User;

$admin = new Admin(
    1, 
    'admin_username', 
    'admin@example.com', 
    'hashed_password', 
    User::ROLE_ADMIN 
);

$tags = $admin->getAllTags();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tags - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
    <style>
        .tag-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .tag-table th, .tag-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .tag-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .tag-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>Liste des Tags</h1>
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
            <!-- Accueil -->
            <li>
                <a href="?page=dashboard">
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
            <!-- Gestion des tags -->
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

            <!-- Gestion des catégories -->
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

            <!-- Statistiques -->
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
            <h1>Liste des Tags</h1>
            <a href="add_tag.php" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Ajouter un tag
            </a>

            <?php if (empty($tags)) : ?>
                <div class="alert alert-info">Aucun tag trouvé.</div>
            <?php else : ?>
                <table class="tag-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du tag</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tags as $tag) : ?>
                            <tr>
                                <td><?= htmlspecialchars($tag['id']) ?></td>
                                <td><?= htmlspecialchars($tag['nom']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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

    <!-- Scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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