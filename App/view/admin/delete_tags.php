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

// Récupérer tous les tags
$tags = $admin->getAllTags();

// Gérer la suppression d'un tag
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tag'])) {
    $tagId = (int)$_POST['tag_id'];
    if ($admin->deleteTag($tagId)) {
        echo "<script>alert('Tag supprimé avec succès.'); window.location.href = 'delete_tag.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression du tag.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Tag - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Supprimer un Tag</h1>
        <a href="list_tags.php" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <?php if (empty($tags)) : ?>
            <div class="alert alert-info">Aucun tag trouvé.</div>
        <?php else : ?>
            <table class="tag-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du tag</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tags as $tag) : ?>
                        <tr>
                            <td><?= htmlspecialchars($tag['id']) ?></td>
                            <td><?= htmlspecialchars($tag['name']) ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?');">
                                    <input type="hidden" name="tag_id" value="<?= htmlspecialchars($tag['id']) ?>">
                                    <button type="submit" name="delete_tag" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>