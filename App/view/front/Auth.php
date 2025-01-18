<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\UserRepository;
use App\Models\User;
// use App\Entity\Student;
// use App\Entity\Teacher;
// use App\Entity\Admin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Traitement de la connexion
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['mot_de_passe'];
        $user = UserRepository::login($email, $password); 

        if ($user) {
            // Stocker l'objet User dans la session
            $_SESSION['user'] = $user;

            // Rediriger en fonction du rôle
            switch ($user->getRole()) {
                case User::ROLE_ADMIN: 
                    header('Location: ../admin/dashboard.php');
                    break;
                case User::ROLE_ENSEIGNANT: 
                    header('Location: ../teacher/teacher.php');
                    break;
                case User::ROLE_ETUDIANT: 
                    header('Location: ../student/student.php');
                    break;
                default: 
                    header('Location: index.php');
                    break;
            }
            exit(); 
        } else {
            $login_error = "Email ou mot de passe incorrect.";
        }
    } elseif (isset($_POST['register'])) {
        // Traitement de l'inscription
        $username = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['mot_de_passe'];
        $confirm_password = $_POST['Confirme_motPasse'];
        $role = (int)$_POST['role'];

        if ($password !== $confirm_password) {
            $register_error = "Les mots de passe ne correspondent pas.";
        } elseif (UserRepository::emailExists($email)) {
            $register_error = "Cet email est déjà utilisé.";
        } else {
            if (UserRepository::register($username, $email, $password, $role)) {
                $register_success = "Inscription réussie. <a href='login.php'>Connectez-vous</a>";
            } else {
                $register_error = "Une erreur s'est produite. Veuillez réessayer.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion et Inscription</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <link href="../../../public/assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <!-- Formulaire de Connexion -->
        <div id="login-form">
            <h2>Connexion</h2>
            <?php if (isset($login_error)): ?>
                <div class="alert alert-danger"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <form action="Auth.php" method="post">
                <!-- Champ Email -->
                <div class="mb-3">
                    <label for="login-email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="login-email" placeholder="Entrez votre email" required>
                    </div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="mb-3">
                    <label for="login-password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="mot_de_passe" class="form-control" id="login-password" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>

                <!-- Case à cocher "Se souvenir de moi" -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember-me">
                    <label class="form-check-label" for="remember-me">Se souvenir de moi</label>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" name="login" class="btn btn-primary">Connexion</button>

                <!-- Lien pour basculer vers le formulaire d'inscription -->
                <div class="text-center mt-3">
                    <a href="#" class="toggle-form" onclick="toggleForm('register-form', 'login-form')">Pas de compte? S'inscrire</a>
                </div>
            </form>
        </div>

        <!-- Formulaire d'Inscription -->
        <div id="register-form" class="hidden">
            <h2>Inscription</h2>
            <?php if (isset($register_error)): ?>
                <div class="alert alert-danger"><?php echo $register_error; ?></div>
            <?php endif; ?>
            <?php if (isset($register_success)): ?>
                <div class="alert alert-success"><?php echo $register_success; ?></div>
            <?php endif; ?>
            <form action="Auth.php" method="POST">
                <!-- Champ Nom complet -->
                <div class="mb-3">
                    <label for="register-fullname" class="form-label">Nom complet</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="nom" class="form-control" id="register-fullname" placeholder="Entrez votre nom complet" required>
                    </div>
                </div>
                <!-- Champ Email -->
                <div class="mb-3">
                    <label for="register-email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="register-email" placeholder="Entrez votre email" required>
                    </div>
                </div>
                <!-- Champ Mot de passe -->
                <div class="mb-3">
                    <label for="register-password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="mot_de_passe" class="form-control" id="register-password" placeholder="Créez un mot de passe" required>
                    </div>
                </div>
                <!-- Champ Confirmation du mot de passe -->
                <div class="mb-3">
                    <label for="register-confirm-password" class="form-label">Confirmez le mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="Confirme_motPasse" class="form-control" id="register-confirm-password" placeholder="Confirmez votre mot de passe" required>
                    </div>
                </div>
                <!-- Choix du rôle (boutons radio) -->
                <div class="mb-3">
                    <label class="form-label">Choisissez votre rôle</label>
                    <div class="form-check">
                        <input class="form-check-input" name="role" type="radio" id="register-role-etudiant" value="<?= User::ROLE_ETUDIANT ?>" required>
                        <label class="form-check-label" for="register-role-etudiant">Étudiant</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="role" type="radio" id="register-role-enseignant" value="<?= User::ROLE_ENSEIGNANT ?>" required>
                        <label class="form-check-label" for="register-role-enseignant">Enseignant</label>
                    </div>
                </div>
                <!-- Bouton d'inscription -->
                <button type="submit" name="register" class="btn btn-primary">S'inscrire</button>
                <!-- Lien pour basculer vers le formulaire de connexion -->
                <div class="text-center mt-3">
                    <a href="#" class="toggle-form" onclick="toggleForm('login-form', 'register-form')">Déjà un compte? Connexion</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script pour basculer entre les formulaires -->
    <script>
        function toggleForm(showId, hideId) {
            document.getElementById(showId).classList.remove('hidden');
            document.getElementById(hideId).classList.add('hidden');
        }
    </script>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>