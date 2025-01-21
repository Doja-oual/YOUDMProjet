<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;
use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\InscriptionRepository;
use App\Models\EvaluationRepository;
use App\Models\CertificatRepository;


class Student extends User {
    public function __construct() {
        $args = func_get_args();

        if (count($args) === 1 && ($args[0] instanceof User || $args[0] instanceof Student)) {
            $user = $args[0];
            parent::__construct(
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getPasswordHash(),
                $user->getRole(),
                $user->getDateInscription(),
                $user->getPhotoProfil(),
                $user->getBio(),
                $user->getPays(),
                $user->getLangueId(),
                $user->getStatutId()
            );
        }
        else if (count($args) >= 6) {
            parent::__construct(
                $args[0],  // id
                $args[1],  // username
                $args[2],  // email
                $args[3],  // passwordHash
                $args[4],  // role
                $args[5],  // dateInscription
                $args[6] ?? null,  // photoProfil
                $args[7] ?? null,  // bio
                $args[8] ?? null,  // pays
                $args[9] ?? null,  // langueId
                $args[10] ?? null  // statutId
            );
        } 
        else {
            return null;
        }
    }
    
        
    

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

   //recupere les evaluation
   
   public function getMyEvaluation(){
    return EvaluationRepository::getEvaluationsByStudent($this->getId());
   }


   //methode pour recupere cirtificats de l'etudiant

   public function getMyCertificats(){
     return CertificatRepository::getCertificatresByStudent($this->getId());
   }

   // recupere les cours d'etudiant
   public function getMyCourse(){
    return InscriptionRepository::getInscritCourse($this->getId());
  }


}