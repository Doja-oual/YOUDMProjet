<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Admin;
use App\Models\User;

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Instancier la classe Admin
$admin = new Admin(
    1, // ID de l'admin
    'admin_username', // Nom d'utilisateur de l'admin
    'admin@example.com', // Email de l'admin
    'hashed_password', // Mot de passe hashé
    User::ROLE_ADMIN // Rôle de l'admin
);

// Gérer l'ajout d'un tag
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si la clé 'nom' existe dans $_POST
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
    } else {
        // echo "<script>alert('Le champ "nom" est manquant.');</script>";
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
</head>
<body>
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
</body>
</html>