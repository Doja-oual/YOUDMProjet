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

// Récupérer l'ID du tag à modifier
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

// Gérer la modification du tag via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tag_name'])) {
    $newTagName = trim($_POST['tag_name']);
    if (!empty($newTagName)) {
        if ($admin->updateTag($tagId, $newTagName)) {
            echo json_encode(['success' => true, 'message' => 'Tag modifié avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification du tag.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Le nom du tag ne peut pas être vide.']);
    }
    exit; // Arrêter l'exécution du script après la réponse AJAX
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tags - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .form-modifier {
            display: none; 
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Gestion des Tags</h1>

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
                                <button onclick="afficherFormulaireModification(<?= $t['id'] ?>, '<?= htmlspecialchars($t['nom']) ?>')" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulaire de modification -->
        <div id="formModifier" class="form-modifier">
            <h2>Modifier le Tag</h2>
            <form id="formModifierTag" method="POST">
                <input type="hidden" name="tag_id" id="tag_id">
                <div class="mb-3">
                    <label for="tag_name" class="form-label">Nom du tag</label>
                    <input type="text" name="tag_name" id="tag_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <button type="button" onclick="masquerFormulaire()" class="btn btn-secondary">Annuler</button>
            </form>
        </div>
    </div>

    <script>
        // Afficher le formulaire de modification
        function afficherFormulaireModification(tagId, tagNom) {
            document.getElementById('tag_id').value = tagId;
            document.getElementById('tag_name').value = tagNom;
            document.getElementById('formModifier').style.display = 'block';
        }

        // Masquer le formulaire de modification
        function masquerFormulaire() {
            document.getElementById('formModifier').style.display = 'none';
        }

        // Soumettre le formulaire via AJAX
        document.getElementById('formModifierTag').addEventListener('submit', function (e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire

            const formData = new FormData(this);
            fetch('edit_tags.php?id=' + document.getElementById('tag_id').value, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload(); // Recharger la page pour afficher les modifications
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    </script>
</body>
</html>