


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction à HTML - Youdemy</title>
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
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .course-content {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .video-content, .text-content, .download-content, .quiz-content {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .video-content iframe {
            border-radius: 8px;
        }
        .text-content pre {
            background-color: #f1f1f1;
            padding: 1rem;
            border-radius: 6px;
            overflow-x: auto;
        }
        .download-content a, .quiz-content a {
            text-decoration: none;
            color: #ffffff;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                            <a class="nav-link btn btn-primary" href="#">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Section principale -->
    <main class="course-page">
        <div class="container">
            <!-- Contenu du cours -->
            <section class="course-content mt-5">
                <h2 class="mb-4">Contenu du cours</h2>

                <!-- Vidéo YouTube -->
                <div class="video-content">
                    <h3 class="mb-3"><i class="fas fa-video me-2"></i>Vidéo : Introduction à HTML</h3>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/UB1O30fR-EE" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Document texte -->
                <div class="text-content">
                    <h3 class="mb-3"><i class="fas fa-file-alt me-2"></i>Document : Les bases de HTML</h3>
                    <p>HTML (HyperText Markup Language) est le langage standard utilisé pour créer des pages web. Voici un aperçu des balises de base :</p>
                    <pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;Ma première page web&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Bonjour, monde !&lt;/h1&gt;
    &lt;p&gt;Ceci est un paragraphe.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                </div>

                <!-- Fichier téléchargeable -->
                <div class="download-content">
                    <h3 class="mb-3"><i class="fas fa-file-download me-2"></i>Fichier : Résumé du cours</h3>
                    <p>Téléchargez le résumé du cours au format PDF :</p>
                    <a href="resume-cours-html.pdf" download class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Télécharger le PDF
                    </a>
                </div>

                <!-- Bouton pour terminer le cours -->
                <div class="text-center mt-5">
                    <button id="mark-complete-btn" class="btn btn-primary btn-lg">
                        <i class="fas fa-check-circle me-2"></i>Terminer le cours
                    </button>
                </div>

                <!-- Quiz pour obtenir un certificat -->
                <div class="quiz-content mt-5">
                    <h3 class="mb-3"><i class="fas fa-question-circle me-2"></i>Quiz : Obtenez votre certificat</h3>
                    <p>Répondez à ce quiz pour obtenir votre certificat de réussite.</p>
                    <form>
                        <div class="mb-3">
                            <label for="question1" class="form-label">1. Que signifie HTML ?</label>
                            <input type="text" class="form-control" id="question1" placeholder="Votre réponse">
                        </div>
                        <div class="mb-3">
                            <label for="question2" class="form-label">2. Quelle balise est utilisée pour créer un paragraphe ?</label>
                            <input type="text" class="form-control" id="question2" placeholder="Votre réponse">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Soumettre le quiz
                        </button>
                    </form>
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