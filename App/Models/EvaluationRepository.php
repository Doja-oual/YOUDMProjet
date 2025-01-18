<?php
namespace App\Models;

use Config\Database;
use PDOException;
 

class EvaluationRepository {
    private static function getConnection(){
        return Database::getConnection();
    }

    
}