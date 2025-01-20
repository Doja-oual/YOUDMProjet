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
</body>
</html>