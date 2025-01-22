<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\Student;
use App\Models\UserRepository;
use App\Models\CertificatRepository;
use App\Models\CoursRepository;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Vous devez être connecté pour accéder à cette page.'); window.location.href = 'login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];

if (!isset($_GET['course_id'])) {
    echo "<script>alert('Cours non trouvé.'); window.location.href = 'student.php';</script>";
    exit();
}

$courseId = $_GET['course_id'];
$result=CertificatRepository::getCertificatsWithDetailsByStudent($userId,$courseId);
if(!$result){
    $success = CertificatRepository::addCirtificat($userId,$courseId);
    $result = CertificatRepository::getCertificatsWithDetailsByStudent($userId,$courseId);
} 



// 
//     echo "<script>alert('Certificat généré avec succès.'); window.location.href = 'certificat.php';</script>";
// } else {
//     echo "<script>alert('Erreur lors de la génération du certificat.'); window.location.href = 'completed_courses.php';</script>";
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Certificats - Youdemy</title>
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

        .certificate-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
        }

        .certificate-container h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #2F80ED;
            text-align: center;
        }

        .certificate-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .certificate-card h3 {
            margin-top: 0;
        }

        .certificate-card p {
            margin: 10px 0;
            font-size: 16px;
        }

        .btn-download {
            background: linear-gradient(135deg, #2F80ED, #F2994A);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(47, 128, 237, 0.4);
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <h2> Certificats</h2>
        <?php echo $result["etudiant_nom"] ?>

    </div>

    <!-- Lien vers Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Script pour télécharger le certificat -->
    <script>
     
    </script>
</body>
</html>