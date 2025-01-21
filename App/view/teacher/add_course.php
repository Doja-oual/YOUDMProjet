
<?php
// Inclure l'autoloader de Composer pour charger les classes
require_once __DIR__ . '/../../../vendor/autoload.php';

// Importer les classes nécessaires
use App\Models\Teacher;
use App\Models\UserRepository;
use App\Models\Category;


// Démarrer la session pour accéder aux données de l'utilisateur connecté

session_start();
$teacherId = $_SESSION["user"]->getId(); 

// Vérifier si l'enseignant est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'enseignant n'est pas connecté
    header('Location: ../front/Auth.php');
    exit();
}
$category = new Category;
$categories = $category->showCategorie();
// $langues = UserRepository::getLangue();

// Récupérer l'ID de l'enseignant connecté depuis la session
// $teacherId = $_SESSION['teacher_id'];

// Récupérer les informations de l'enseignant depuis la base de données
$teacherData = UserRepository::getUserById($teacherId);

// Créer une instance de la classe Teacher
$teacher = new Teacher(
    $teacherId,
    $teacherData['nom'],
    $teacherData['email'],
    $teacherData['mot_de_passe'],
    $teacherData['role_id'],
    $teacherData['date_inscription'],
    $teacherData['photo_profil'],
    $teacherData['bio'],
    $teacherData['pays'],
    $teacherData['langue_id'],
    $teacherData['statut_id']
);



// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-course'])) {
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
        'statut_id' => (int)$_POST['statut_id'],
        'enseignant_id' => $teacherId
    ];
    // Ajouter le cours en utilisant la méthode de la classe Teacher
    if ($teacher->addCourse($courseData)) {
        // Afficher un message de succès
        echo "Le cours a été ajouté avec succès !";
        // Rediriger vers la liste des cours après 2 secondes
        // header('Refresh: 2; URL=my_courses.php');
        header("Location: ./my_course.php");
        exit;
    } else {
        // Afficher un message d'erreur
        echo "Une erreur s'est produite lors de l'ajout du cours.";
    }
} else {
    // Si le formulaire n'a pas été soumis, afficher un message d'erreur
    echo "Accès non autorisé.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Cours</title>
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

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .input-group-text {
            background: transparent;
            border: none;
            color: #2F80ED;
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

        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .slide {
            display: none;
        }

        .slide.active {
            display: block;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Barre de progression */
        .progress-container {
            width: 100%;
            background-color: #e9ecef;
            border-radius: 25px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 10px;
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            width: 0;
            border-radius: 25px;
            transition: width 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Cours</h2>

        <!-- Barre de progression -->
        <div class="progress-container">
            <div class="progress-bar" id="progress-bar"></div>
        </div>

        <form id="form-cours" action="my_course.php" method="POST">
            <!-- Slide 1 : Informations de base -->
            <div class="slide active" id="slide1">
                <!-- Titre du cours -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du cours :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                        <input type="text" id="titre" name="titre" class="form-control" required>
                    </div>
                </div>

                <!-- Description du cours -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                </div>

                <!-- Type de contenu -->
                <div class="mb-3">
                    <label for="type_contenu" class="form-label">Type de contenu :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        <select id="type_contenu" name="type_contenu" class="form-control" required>
                            <option value="texte">Texte</option>
                            <option value="video">Vidéo</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                </div>

                <!-- Contenu (dynamique en fonction du type) -->
                <div class="mb-3" id="contenu-groupe">
                    <label for="contenu" class="form-label">Contenu :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                        <textarea id="contenu" name="contenu" class="form-control" rows="4" required></textarea>
                    </div>
                </div>

                <!-- Boutons de navigation -->
                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" disabled>Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextSlide(2)">Suivant</button>
                </div>
            </div>

            <!-- Slide 2 : Détails supplémentaires -->
            <div class="slide" id="slide2">
                <!-- Enseignant -->
                <div class="mb-3">
                    <!-- <label for="enseignant_id" class="form-label">Enseignant :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                        <select id="enseignant_id" name="enseignant_id" class="form-control" required>
                            <option value="1">Enseignant 1</option>
                            <option value="2">Enseignant 2</option>
                        </select>
                    </div> -->
                </div>

                <!-- Catégorie -->
                <div class="mb-3">
                    <label for="categorie_id" class="form-label">Catégorie :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        <select id="categorie_id" name="categorie_id" class="form-control" required>
                            <?php foreach($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>"><?= $category['nom'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Niveau -->
                <div class="mb-3">
                    <label for="niveau" class="form-label">Niveau :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-signal"></i></span>
                        <select id="niveau" name="niveau" class="form-control" required>
                            <option value="Débutant">Débutant</option>
                            <option value="Intermédiaire">Intermédiaire</option>
                            <option value="Avancé">Avancé</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons de navigation -->
                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" onclick="prevSlide(1)">Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextSlide(3)">Suivant</button>
                </div>
            </div>

            <!-- Slide 3 : Informations supplémentaires -->
            <div class="slide" id="slide3">
                <!-- Durée -->
                <div class="mb-3">
                    <label for="duree" class="form-label">Durée (en minutes) :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        <input type="number" id="duree" name="duree" class="form-control" required>
                    </div>
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input type="number" id="prix" name="prix" class="form-control" step="0.01" required>
                    </div>
                </div>

                <!-- Langue -->
                <div class="mb-3">
                    <label for="langue_id" class="form-label">Langue :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-language"></i></span>
                        <select id="langue_id" name="langue_id" class="form-control" required>
                            
                            <option value="1">Francais</option>
                        </select>
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-3">
                    <label for="statut_id" class="form-label">Statut :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <select id="statut_id" name="statut_id" class="form-control" required>
                            <option value="1">Actif</option>
                            <option value="2">En attente</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons de navigation -->
                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" onclick="prevSlide(2)">Précédent</button>
                    <button type="submit" name="add-course" class="btn btn-primary">Ajouter le Cours</button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript pour gérer les slides et la barre de progression -->
    <script>
        let currentSlide = 1;
        const totalSlides = 3;

        function showSlide(slideNumber) {
            const slides = document.querySelectorAll('.slide');
            slides.forEach(slide => slide.classList.remove('active'));
            document.getElementById(`slide${slideNumber}`).classList.add('active');
            currentSlide = slideNumber;

            // Mettre à jour la barre de progression
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = (currentSlide / totalSlides) * 100;
            progressBar.style.width = `${progressPercentage}%`;
        }

        function nextSlide(slideNumber) {
            showSlide(slideNumber);
        }

        function prevSlide(slideNumber) {
            showSlide(slideNumber);
        }

        // Afficher la première slide au chargement de la page
        showSlide(1);
    </script>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>