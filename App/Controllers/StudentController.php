<?php
namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\Student;
use App\Models\InscriptionRepository;
use App\Models\CoursRepository;
use App\Models\EvaluationRepository;
use App\Models\CertificatRepository;

class StudentController {
    private $student;

    public function __construct($userId) {
        $user = UserRepository::getUserById($userId);
        $this->student = new Student($user);
    }

    public function showDashboard() {
        return $this->student->showDashboard();
    }

    public function enrollInCourse($courseId) {
        return $this->student->InscritInCourse($courseId);
    }

    public function isEnrolledInCourse($courseId) {
        return $this->student->isEtudiantInscritCours($courseId);
    }

    public function getCourseDetails($courseId) {
        return $this->student->getCourseDetails($courseId);
    }

    public function evaluateCourse($courseId, $note, $commentaire) {
        return $this->student->evalueCours($courseId, $note, $commentaire);
    }

    public function getMyEvaluations() {
        return $this->student->getMyEvaluation();
    }

    public function getMyCertificates() {
        return $this->student->getMyCertificats();
    }
}