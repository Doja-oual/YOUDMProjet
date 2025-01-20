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

// Récupérer l'ID du tag à modifier
$tagId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Récupérer les informations du tag
$tag = null;
if ($tagId) {
    $tags = $admin->getAllTags();
    foreach ($tags as $t) {
        if ($t['id'] === $tagId) {
            $tag = $t;
            break;
        }
    }
}

// Gérer la modification du tag
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTagName = trim($_POST['tag_name']);
    if (!empty($newTagName)) {
        // Ici, vous devez implémenter une méthode updateTag dans la classe Admin
        if ($admin->updateTag($tagId, $newTagName)) {
            echo "<script>alert('Tag modifié avec succès.'); window.location.href = 'list_tags.php';</script>";
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
</head>
<body>
    <div class="container mt-4">
        <h1>Modifier un Tag</h1>
        <?php if ($tag) : ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="tag_name" class="form-label">Nom du tag</label>
                    <input type="text" name="tag_name" class="form-control" value="<?= htmlspecialchars($tag['name']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="list_tags.php" class="btn btn-secondary">Annuler</a>
            </form>
        <?php else : ?>
            <div class="alert alert-danger">Tag non trouvé.</div>
        <?php endif; ?>
    </div>
</body>
</html>