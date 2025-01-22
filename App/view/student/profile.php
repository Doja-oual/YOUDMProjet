<?php
// Activer l'affichage des erreurs PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrer la session
session_start();

// Inclure l'autoloader de Composer
require_once __DIR__ . '/../../../vendor/autoload.php';

// Importer les classes nécessaires
use App\Models\Student;
use App\Models\UserRepository;

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Vous devez être connecté pour accéder à cette page.'); window.location.href = 'login.php';</script>";
    exit();
}

// Récupérer l'ID de l'utilisateur connecté depuis la session
$userId = $_SESSION['userId'];

// Récupérer les informations de l'étudiant depuis la base de données
$userData = UserRepository::getUserById($userId);

// Vérifier si l'utilisateur existe
if (!$userData) {
    echo "<script>alert('Utilisateur non trouvé.'); window.location.href = 'login.php';</script>";
    exit();
}

// Instancier la classe Student avec les données de l'utilisateur
$student = new Student(
    $userData['id'],
    $userData['nom'],
    $userData['email'],
    $userData['mot_de_passe'],
    $userData['role_id'],
    $userData['date_inscription'],
    $userData['photo_profil'],
    $userData['bio'],
    $userData['pays'],
    $userData['langue_id'],
    $userData['statut_id']
);

// Récupérer toutes les langues disponibles via UserRepository
$langues = UserRepository::getLangue($userId);

// Gérer la soumission du formulaire pour mettre à jour le profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateData = [
        'photo_profil' => trim($_POST['photo_profil']),
        'bio' => trim($_POST['bio']),
        'pays' => trim($_POST['pays']),
        'langue_id' => (int) $_POST['langue_id']
    ];

    if ($student->updateProfile($updateData)) {
        echo "<script>alert('Profil mis à jour avec succès.'); window.location.href = 'profile.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la mise à jour du profil.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Étudiant - Youdemy</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        body {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .profile-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
        }

        .profile-container h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #2F80ED;
            text-align: center;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            border: 3px solid #2F80ED;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(47, 128, 237, 0.4);
        }

        .form-container {
            display: none; /* Masquer le formulaire par défaut */
            margin-top: 20px;
        }

        .form-container.active {
            display: block; /* Afficher le formulaire lorsqu'il est actif */
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Profil Étudiant</h2>

        <!-- Photo de profil -->
        <img src="<?= htmlspecialchars($student->getProfile()['photo_profil']) ?>" alt="Photo de profil" class="profile-picture">

        <!-- Informations du profil -->
        <div class="profile-info">
            <p><strong>Nom :</strong> <?= htmlspecialchars($student->getProfile()['nom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($student->getProfile()['email']) ?></p>
            <p><strong>Bio :</strong> <?= htmlspecialchars($student->getProfile()['bio']) ?></p>
            <p><strong>Pays :</strong> <?= htmlspecialchars($student->getProfile()['pays']) ?></p>
            <p><strong>Langue :</strong> <?= htmlspecialchars($student->getLangueUser()['nom']) ?> (<?= htmlspecialchars($student->getLangueUser()['code']) ?>)</p>
        </div>

        <!-- Bouton pour ouvrir le formulaire de modification -->
        <button id="edit-profile-button" class="btn btn-edit">
            <i class="fas fa-edit"></i> Modifier le Profil
        </button>

        <!-- Formulaire de modification du profil (caché par défaut) -->
        <div id="form-container" class="form-container">
            <form id="profile-form" method="POST">
                <!-- Photo de profil (URL) -->
                <div class="mb-3">
                    <label for="photo_profil" class="form-label">Photo de profil (URL) :</label>
                    <input type="text" id="photo_profil" name="photo_profil" class="form-control" value="<?= htmlspecialchars($student->getProfile()['photo_profil']) ?>">
                </div>

                <!-- Bio -->
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio :</label>
                    <textarea id="bio" name="bio" class="form-control" rows="4"><?= htmlspecialchars($student->getProfile()['bio']) ?></textarea>
                </div>

                <!-- Pays -->
                <div class="mb-3">
                    <label for="pays" class="form-label">Pays :</label>
                    <input type="text" id="pays" name="pays" class="form-control" value="<?= htmlspecialchars($student->getProfile()['pays']) ?>">
                </div>

                <!-- Langue -->
                <div class="mb-3">
                    <label for="langue_id" class="form-label">Langue :</label>
                    <select id="langue_id" name="langue_id" class="form-control">
                        <?php foreach ($langues as $langue) : ?>
                            <option value="<?= $langue['id'] ?>" <?= $langue['id'] == $student->getProfile()['langue_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($langue['nom']) ?> (<?= htmlspecialchars($langue['code']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-edit">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Script pour gérer l'affichage/masquage du formulaire -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButton = document.getElementById("edit-profile-button");
            const formContainer = document.getElementById("form-container");

            if (editButton && formContainer) {
                editButton.addEventListener("click", function () {
                    formContainer.classList.toggle("active");
                });
            }
        });
    </script>
</body>
</html>