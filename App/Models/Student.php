<?php
namespace App\Models;

use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\InscriptionRepository;
use App\Models\EvaluationRepository;


class Student extends User {
    public function showDashboard() {
        return "Tableau de bord Étudiant";
    }
 public function InscritInCourse($courseId){
    // virifie que etudiant deja fait insciption

    if($this->isInscritCours($courseId)){
        return "vous etes deja inscrita ce course";
    }



    // enregistre l'inscription dans database
$success = InscriptionRepository::addInscription($this->getId(),$courseId);

 if($success){
    return "Inscription au cours reussie";
 }else{
    return "errure inscrite a cour";
 }


    
 }

 // methode pour virifier si etudiant deja inscrit a un cours

 public function isEtudiantInscritCours($courseId){
    return InscriptionRepository::isInscritCours($this->getId(),$courseId);
 }

//  pour consulter les details d'un cours
 public function getCourseDetails($courseId){
    return CoursRepository::getCourseById($courseId);
 }


 //pour evaluer un cours
 public function evalueCours($courseId,$note,$commrntaire){
    // verifie student inscritr a course 
    if(!$this->isInscritCours($courseId)){
        return "Vous deja inscrit";
    }
    //ENregistre l'evaluation dans la base de donnees
    $success=EvaluationRepository::addEvaluation($this->grtId(),$courseId,$note,$commrntaire);

    if($success){
        return "Evaluation du cours enrigestree avec succes";
    }else{
        return " Errure lors de l'enregistrement de l'evaluation";
    }

    
 }


}