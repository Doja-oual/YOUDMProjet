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

$users = $admin->getAllUsers();

if ($users === false) {
    die("Une erreur s'est produite lors de la récupération des utilisateurs.");
}

// Gerer les actions (activation/désactivation, suppression)
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['action']) && isset($_POST['user_id'])) {
//         $userId = (int)$_POST['user_id'];
//         switch ($_POST['action']) {
//             case 'toggle_status':
//                 // Activer/Désactiver l'utilisateur
//                 if ($admin->suspendUser($userId)) {
//                     echo "<script>alert('Statut de l\'utilisateur modifié avec succès.'); window.location.href = 'gestion_utilisateurs.php';</script>";
//                 } else {
//                     echo "<script>alert('Erreur lors de la modification du statut.');</script>";
//                 }
//                 break;
//             case 'delete':
//                 // Supprimer l'utilisateur
//                 if ($admin->deleteUser($userId)) {
//                     echo "<script>alert('Utilisateur supprimé avec succès.'); window.location.href = 'gestion_utilisateurs.php';</script>";
//                 } else {
//                     echo "<script>alert('Erreur lors de la suppression de l\'utilisateur.');</script>";
//                 }
//                 break;
//             default:
//                 echo "<script>alert('Action non reconnue.');</script>";
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
    <style>
        /* Styles pour la table des utilisateurs */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-table th, .user-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .user-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .user-table tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons .btn {
            padding: 5px 10px;
            font-size: 14px;
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
            <h2>Liste des Utilisateurs</h2>

            <?php if (empty($users)) : ?>
                <div class="alert alert-info">Aucun utilisateur trouvé.</div>
            <?php else : ?>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= htmlspecialchars($user['nom']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php
                                    switch ($user['role_id']) {
                                        case User::ROLE_ETUDIANT:
                                            echo 'Étudiant';
                                            break;
                                        case User::ROLE_ENSEIGNANT:
                                            echo 'Enseignant';
                                            break;
                                        case User::ROLE_ADMIN:
                                            echo 'Administrateur';
                                            break;
                                        default:
                                            echo 'Inconnu';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($user['statut_id'] == User::STATUS_ACTIVE ? 'Actif' : 'Inactif') ?>
                                </td>
                               
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