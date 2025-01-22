<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\Teacher;
use App\Models\UserRepository;



$userId = $_SESSION['userId'];

$userData = UserRepository::getUserById($userId);

if (!$userData) {
    echo "<script>alert('Utilisateur non trouvé.'); window.location.href = 'login.php';</script>";
    exit();
}

// Instancier la classe Teacher avec les données de l'utilisateur
$teacher = new Teacher(
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
        'langue_id' => 3
    ];

    if ($teacher->updateProfile($updateData)) {
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
    <title>Profil Enseignant - Youdemy</title>
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
            animation: fadeIn 1s ease-in-out;
        }

        /* @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        } */

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
        <h2>Profil Enseignant</h2>

        <!-- Photo de profil -->
        <img src="<?= htmlspecialchars($teacher->getProfile()['photo_profil']) ?>" alt="Photo de profil" class="profile-picture">

        <!-- Informations du profil -->
        <div class="profile-info">
            <p><strong>Nom :</strong> <?= htmlspecialchars($teacher->getProfile()['nom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($teacher->getProfile()['email']) ?></p>
            <p><strong>Bio :</strong> <?= htmlspecialchars($teacher->getProfile()['bio']) ?></p>
            <p><strong>Pays :</strong> <?= htmlspecialchars($teacher->getProfile()['pays']) ?></p>
            <p><strong>Langue :</strong> <?= htmlspecialchars($teacher->getLangueUser()['nom']) ?> (<?= htmlspecialchars($teacher->getLangueUser()['code']) ?>)</p>
        </div>

        <!-- Bouton pour ouvrir le formulaire de modification -->
        <button id="edit-profile-button" class="btn btn-edit">
            <i class="fas fa-edit"></i> Modifier le Profil
        </button>

        <!-- Formulaire de modification du profil (caché par défaut) -->
        <div id="form-container" class="">
            <form id="profile-form" method="POST">
                <!-- Photo de profil (URL) -->
                <div class="mb-3">
                    <label for="photo_profil" class="form-label">Photo de profil (URL) :</label>
                    <input type="text" id="photo_profil" name="photo_profil" class="form-control" value="<?= htmlspecialchars($teacher->getProfile()['photo_profil']) ?>">
                </div>

                <!-- Bio -->
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio :</label>
                    <textarea id="bio" name="bio" class="form-control" rows="4"><?= htmlspecialchars($teacher->getProfile()['bio']) ?></textarea>
                </div>

                <!-- Pays -->
                <div class="mb-3">
                    <label for="pays" class="form-label">Pays :</label>
                    <input type="text" id="pays" name="pays" class="form-control" value="<?= htmlspecialchars($teacher->getProfile()['pays']) ?>">
                </div>

                <!-- Langue -->
              
                
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
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButton = document.getElementById("edit-profile-button");
            const formContainer = document.getElementById("form-container");

            console.log("DOM chargé");
            console.log("editButton:", editButton);
            console.log("formContainer:", formContainer);

            if (editButton && formContainer) {
                editButton.addEventListener("click", function () {
                    console.log("Bouton cliqué");
                    formContainer.classList.toggle("active");
                    console.log("formContainer active:", formContainer.classList.contains("active"));
                });
            } else {
                console.error("Élément non trouvé : editButton ou formContainer");
            }
        });
    </script> -->
</body>
</html>