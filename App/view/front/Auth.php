<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php'; // Charger l'autoloader

use App\Models\UserRepository;
use App\Models\User;

if(isset($_SESSION['user'])) {
    $role = $_SESSION['role'];
    if($role === 3) {
        header("Location: ../admin/dashboard.php");
    }
    else if($role === 2) {
        header("Location: ../teacher/my_courses.php");
    } 
    else if($role === 1) {
        header("Location: ../teacher/my_courses.php");
    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['register'])) {
        $username = $_POST['nom'];
        $email = $_POST['email'];
        $password = $_POST['mot_de_passe'];
        $role = (int)$_POST['role'];
        if($role === 2) {
            $statu = 2;
        }
        else { 
            $statu = 1;
        }
        UserRepository::register($username, $email, $password, $role,$statu);
    }

    if (isset($_POST['login'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['mot_de_passe'];
        $user = UserRepository::login($email, $password);

        if ($user) {
            $_SESSION['user'] = $user; // Stocker l'objet dans la session
            $_SESSION['userId'] = $user->getId();
            $_SESSION['role'] = $user->getRole();
            // Rediriger en fonction du rôle
            switch ($user->getRole()) {
                case User::ROLE_ADMIN: 
                    header('Location: ../admin/dashboard.php');
                    break;
                case User::ROLE_ENSEIGNANT: 
                    if($user->getStatutId() === 1) {
                        header('Location: ../teacher/add_course.php');
                    } else {
                        header('Location: ../home.php');
                    }
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
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion et Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../../../public/assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <div id="login-form">
            <h2>Connexion</h2>
            <?php if (isset($login_error)): ?>
                <div class="alert alert-danger"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <form action="Auth.php" method="post">
                <div class="mb-3">
                    <label for="login-email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="login-email" placeholder="Entrez votre email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="login-password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="mot_de_passe" class="form-control" id="login-password" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember-me">
                    <label class="form-check-label" for="remember-me">Se souvenir de moi</label>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Connexion</button>
                <div class="text-center mt-3">
                    <a href="#" class="toggle-form" onclick="toggleForm('register-form', 'login-form')">Pas de compte? S'inscrire</a>
                </div>
            </form>
        </div>

        <div id="register-form" class="hidden">
            <h2>Inscription</h2>
            <?php if (isset($register_error)): ?>
                <div class="alert alert-danger"><?php echo $register_error; ?></div>
            <?php endif; ?>
            <?php if (isset($register_success)): ?>
                <div class="alert alert-success"><?php echo $register_success; ?></div>
            <?php endif; ?>
            <form action="Auth.php" method="POST">
                <div class="mb-3">
                    <label for="register-fullname" class="form-label">Nom complet</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="nom" class="form-control" id="register-fullname" placeholder="Entrez votre nom complet" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="register-email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="register-email" placeholder="Entrez votre email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="register-password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="mot_de_passe" class="form-control" id="register-password" placeholder="Créez un mot de passe" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="register-confirm-password" class="form-label">Confirmez le mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="Confirme_motPasse" class="form-control" id="register-confirm-password" placeholder="Confirmez votre mot de passe" required>
                    </div>
                </div>
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
                    <!-- <div class="mb-3">

                    <label for="statut_id" class="form-label">Statut :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <select id="statut_id" name="statut" class="form-control" required>
                            <option value="<? User::STATUS_INACTIVE ?>">En attente</option>
                        </select>
                        </div>
                </div> -->
                <button type="submit" name="register" class="btn btn-primary">S'inscrire</button>
                <div class="text-center mt-3">
                    <a href="#" class="toggle-form" onclick="toggleForm('login-form', 'register-form')">Déjà un compte? Connexion</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleForm(showId, hideId) {
            document.getElementById(showId).classList.remove('hidden');
            document.getElementById(hideId).classList.add('hidden');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>