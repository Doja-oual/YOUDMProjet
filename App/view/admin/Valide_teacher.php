<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Admin;
use App\Models\User;

// Create an admin instance
$admin = new Admin(
    1, // ID
    'AdminName', // Username
    'admin@example.com', // Email
    'hashed_password', // Password hash
    User::ROLE_ADMIN // Role
);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['validate_teacher'])) {
        $teacherId = $_POST['teacher_id'];
        if ($admin->validateTeacherAccount($teacherId)) {
            $successMessage = "Le compte de l'enseignant a été validé avec succès.";
        } else {
            $errorMessage = "Une erreur s'est produite lors de la validation.";
        }
    } elseif (isset($_POST['reject_teacher'])) {
        $teacherId = $_POST['teacher_id'];
        if ($admin->deleteUser($teacherId)) {
            $successMessage = "Le compte de l'enseignant a été refusé et supprimé.";
        } else {
            $errorMessage = "Une erreur s'est produite lors du refus.";
        }
    }
}

// Fetch pending teachers (after form processing)
$pendingTeachers = $admin->getPendingTeachers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider les Enseignants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Valider les Enseignants</h1>

        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success"><?= $successMessage ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif; ?>

        <h3>Enseignants en Attente</h3>
        <?php if (empty($pendingTeachers)) : ?>
            <div class="alert alert-info">Aucun enseignant en attente de validation.</div>
        <?php else : ?>
            <div class="row">
                <?php foreach ($pendingTeachers as $teacher) : ?>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($teacher['nom']) ?></h5>
                                <p class="card-text">Email: <?= htmlspecialchars($teacher['email']) ?></p>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="teacher_id" value="<?= $teacher['id'] ?>">
                                    <button type="submit" name="validate_teacher" class="btn btn-success">Valider</button>
                                </form>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="teacher_id" value="<?= $teacher['id'] ?>">
                                    <button type="submit" name="reject_teacher" class="btn btn-danger">Refuser</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>