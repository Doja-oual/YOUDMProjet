<?php
namespace App\Models;

use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\InscriptionRepository;


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


}