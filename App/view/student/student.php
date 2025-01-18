<?php
// Inclure l'autoload de Composer
require_once __DIR__ . '/../../../vendor/autoload.php';

// Utiliser les classes nécessaires
use App\Models\User;
use App\Models\Student;
use App\Models\UserRepository;
use App\Models\CertificatRepository;

// Demarrer la session
session_start();

// Verifier si l'utilisateur est connecte
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecte
    header('Location: ../../views/auth/login.php');
    exit();
}

// recupere l'objet User de la session
$user = $_SESSION['user'];

// Verifier que l'objet est bien une instance de User ou d'une de ses classes enfant
if (!($user instanceof User)) {
    die("Erreur : L'objet dans la session n'est pas une instance de User.");
}

// Créer une instance de Student avec l'objet User
$student = new Student($user);

// Récupérer les cours en cours de l'étudiant
$enrolledCourses = $student->getMyCourse($student->getId());

// Récupérer les certifications de l'étudiant
$certificates = $student->getMyCertificats($student->getId());
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord étudiant - Youdemy</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Lien vers le fichier CSS personnalisé -->
    <link rel="stylesheet" href="../../../public/assets/css/css.css">
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">Youdemy</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Mes cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Certifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light" href="../front/logout.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Section principale -->
    <main class="dashboard">
        <div class="container">
            <!-- Bienvenue -->
            <section class="welcome-section">
                <h1>Bienvenue, <span class="student-name"><?php echo htmlspecialchars($student->getUsername()); ?></span> !</h1>
                <p>Commencez votre parcours d'apprentissage dès aujourd'hui.</p>
            </section>

            <!-- Cours en cours -->
            <section class="ongoing-courses">
                <h2>Mes cours en cours</h2>
                <div class="row">
                    <?php if (!empty($enrolledCourses)): ?>
                        <?php foreach ($enrolledCourses as $course): ?>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Cours 1">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($course['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo htmlspecialchars($course['progress']); ?>%;" aria-valuenow="<?php echo htmlspecialchars($course['progress']); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo htmlspecialchars($course['progress']); ?>%</div>
                                        </div>
                                        <a href="#" class="btn btn-primary mt-3">Continuer</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun cours en cours pour le moment.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Certifications -->
            <section class="certifications">
                <h2>Mes certifications</h2>
                <div class="row">
                    <?php if (!empty($certificates)): ?>
                        <?php foreach ($certificates as $certificate): ?>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Certification 1">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($certificate['name']); ?></h5>
                                        <p class="card-text">Certification obtenue le <?php echo htmlspecialchars($certificate['date']); ?>.</p>
                                        <a href="#" class="btn btn-primary">Voir la certification</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune certification obtenue pour le moment.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <!-- Pied de page -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Youdemy. Tous droits réservés.</p>
            <p>
                <a href="#">Politique de confidentialité</a> |
                <a href="#">Conditions d'utilisation</a> |
                <a href="#">Mentions légales</a>
            </p>
        </div>
    </footer>
    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>