<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Youdemy</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Lien vers le fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styles personnalisés */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .profile-section {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .profile-section h2 {
            margin-bottom: 1.5rem;
            color: #0d6efd;
        }
        .profile-info {
            margin-bottom: 2rem;
        }
        .profile-info img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }
        .profile-info h3 {
            margin-bottom: 0.5rem;
            color: #343a40;
        }
        .profile-info p {
            color: #6c757d;
        }
        .profile-details {
            text-align: left;
            margin-top: 1.5rem;
        }
        .profile-details p {
            margin-bottom: 0.5rem;
        }
        .course-card, .certification-card {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        .course-card:hover, .certification-card:hover {
            transform: translateY(-5px);
        }
        .course-card h3, .certification-card h3 {
            margin-bottom: 0.5rem;
            color: #343a40;
        }
        .course-card p, .certification-card p {
            color: #6c757d;
        }
        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
        .badge-primary {
            background-color: #0d6efd;
        }
        .badge-success {
            background-color: #28a745;
        }
        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }
        footer a {
            color: #ffffff;
            text-decoration: none;
        }
        footer a:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="home.php">Youdemy</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="student.php">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pageCourse.php">Cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="MyCourses.php">Mes cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Cirtificat.php">Certifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profil</a>
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
    <main class="profile-page">
        <div class="container">
            <!-- Titre de la page -->
            <h1 class="my-5">Profil</h1>

            <!-- Section : Informations du profil -->
            <section class="profile-section">
                <h2><i class="fas fa-user me-2"></i>Informations personnelles</h2>
                <div class="profile-info text-center">
                    <!-- Photo de profil -->
                    <img src="https://via.placeholder.com/150" alt="Photo de profil">
                    <!-- Nom -->
                    <h3>Jean Dupont</h3>
                    <!-- Email -->
                    <p>jean.dupont@example.com</p>
                </div>
                <!-- Détails supplémentaires -->
                <div class="profile-details">
                    <p><strong>Date d'inscription :</strong> 15/10/2023</p>
                    <p><strong>Bio :</strong> Développeur passionné par les nouvelles technologies et les langages de programmation modernes.</p>
                    <p><strong>Pays :</strong> France</p>
                    <p><strong>Langue :</strong> Français</p>
                </div>
                <!-- Bouton pour modifier le profil -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Modifier le profil
                    </button>
                </div>
            </section>

          
        </div>
    </main>

    <!-- Pied de page -->
    <footer>
        <div class="container text-center">
            <p>&copy; 2024 Youdemy. Tous droits réservés.</p>
            <p>
                <a href="#">Politique de confidentialité</a> |
                <a href="#">Conditions d'utilisation</a>
            </p>
        </div>
    </footer>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>