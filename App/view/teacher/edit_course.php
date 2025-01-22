<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Teacher;
use App\Models\UserRepository;
use App\Models\Category;
use App\Models\CoursRepository;

// Démarrer la session pour accéder aux données de l'utilisateur connecté
session_start();

// Vérifier si l'enseignant est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'enseignant n'est pas connecté
    header('Location: ../front/Auth.php');
    exit();
}

// Récupérer l'ID de l'enseignant connecté depuis la session
$teacherId = $_SESSION["user"]->getId();

// Récupérer l'ID du cours à modifier depuis l'URL
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Récupérer les informations du cours à modifier
$course = new CoursRepository();
$courses = $course->getCourseById($courseId);

// Vérifier si le cours appartient à l'enseignant connecté
if ($course['enseignant_id'] !== $teacherId) {
    echo "Vous n'êtes pas autorisé à modifier ce cours.";
    exit();
}

// Récupérer les catégories pour le formulaire
$category = new Category;
$categories = $category->showCategorie();

// Créer une instance de la classe Teacher
$teacher = new Teacher(
    $teacherId,
    $_SESSION["user"]->getUsername(),
    $_SESSION["user"]->getEmail(),
    $_SESSION["user"]->getPasswordHash(),
    $_SESSION["user"]->getRole(),
    $_SESSION["user"]->getDateInscription(),
    $_SESSION["user"]->getPhotoProfil(),
    $_SESSION["user"]->getBio(),
    $_SESSION["user"]->getPays(),
    $_SESSION["user"]->getLangueId(),
    $_SESSION["user"]->getStatutId()
);

// Gérer la soumission du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $courseData = [
        'titre' => $_POST['titre'],
        'description' => $_POST['description'],
        'contenu' => $_POST['contenu'],
        'type_contenu' => $_POST['type_contenu'],
        'categorie_id' => (int)$_POST['categorie_id'],
        'niveau' => $_POST['niveau'],
        'duree' => $_POST['duree'],
        'prix' => $_POST['prix'],
        'langue_id' => $_POST['langue_id'],
        'statut_id' => (int)$_POST['statut_id']
    ];

    // Mettre à jour le cours en utilisant la méthode de la classe Teacher
    if ($teacher->updateCourse($courseId, $courseData)) {
        echo "<script>alert('Le cours a été modifié avec succès.'); window.location.href = 'my_courses.php';</script>";
    } else {
        echo "<script>alert('Une erreur s\'est produite lors de la modification du cours.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Cours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #2F80ED;
            text-align: center;
        }

        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2F80ED;
            box-shadow: 0 0 10px rgba(47, 128, 237, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(47, 128, 237, 0.4);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier un Cours</h2>
        <form method="POST">
            <!-- Titre du cours -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre du cours :</label>
                <input type="text" id="titre" name="titre" class="form-control" value="<?= htmlspecialchars($course['titre']) ?>" required>
            </div>

            <!-- Description du cours -->
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?= htmlspecialchars($course['description']) ?></textarea>
            </div>

            <!-- Type de contenu -->
            <div class="mb-3">
                <label for="type_contenu" class="form-label">Type de contenu :</label>
                <select id="type_contenu" name="type_contenu" class="form-control" required>
                    <option value="texte" <?= $course['type_contenu'] === 'texte' ? 'selected' : '' ?>>Texte</option>
                    <option value="video" <?= $course['type_contenu'] === 'video' ? 'selected' : '' ?>>Vidéo</option>
                    <option value="image" <?= $course['type_contenu'] === 'image' ? 'selected' : '' ?>>Image</option>
                </select>
            </div>

            <!-- Contenu -->
            <div class="mb-3">
                <label for="contenu" class="form-label">Contenu :</label>
                <textarea id="contenu" name="contenu" class="form-control" rows="4" required><?= htmlspecialchars($course['contenu']) ?></textarea>
            </div>

            <!-- Catégorie -->
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Catégorie :</label>
                <select id="categorie_id" name="categorie_id" class="form-control" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" <?= $course['categorie_id'] === $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Niveau -->
            <div class="mb-3">
                <label for="niveau" class="form-label">Niveau :</label>
                <select id="niveau" name="niveau" class="form-control" required>
                    <option value="Débutant" <?= $course['niveau'] === 'Débutant' ? 'selected' : '' ?>>Débutant</option>
                    <option value="Intermédiaire" <?= $course['niveau'] === 'Intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
                    <option value="Avancé" <?= $course['niveau'] === 'Avancé' ? 'selected' : '' ?>>Avancé</option>
                </select>
            </div>

            <!-- Durée -->
            <div class="mb-3">
                <label for="duree" class="form-label">Durée (en minutes) :</label>
                <input type="number" id="duree" name="duree" class="form-control" value="<?= htmlspecialchars($course['duree']) ?>" required>
            </div>

            <!-- Prix -->
            <div class="mb-3">
                <label for="prix" class="form-label">Prix :</label>
                <input type="number" id="prix" name="prix" class="form-control" step="0.01" value="<?= htmlspecialchars($course['prix']) ?>" required>
            </div>

            <!-- Langue -->
            <div class="mb-3">
                <label for="langue_id" class="form-label">Langue :</label>
                <select id="langue_id" name="langue_id" class="form-control" required>
                    <option value="1" <?= $course['langue_id'] === 1 ? 'selected' : '' ?>>Français</option>
                    <!-- Ajoutez d'autres langues si nécessaire -->
                </select>
            </div>

            <!-- Statut -->
            <div class="mb-3">
                <label for="statut_id" class="form-label">Statut :</label>
                <select id="statut_id" name="statut_id" class="form-control" required>
                    <option value="2" <?= $course['statut_id'] === 2 ? 'selected' : '' ?>>En attente</option>
                    <!-- Ajoutez d'autres statuts si nécessaire -->
                </select>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>