<?php
namespace App\Models;
require_once '../../vendor/autoload.php';
use Config\Database;
use App\Core\Model;

class Category extends Model {
    protected $table = 'Categorie';

    public function __construct() {
        $this->conn = Database::getConnection();
    }

   
    public function showCategorie() {
        return parent::show($this->table);
    }

    public function addCategorie($data) {
        return parent::add($this->table, $data);
    }

    public function updateCategorie($id, $data) {
        return parent::update($this->table, $id, $data);
    }

    public function deleteCategorie($id) {
        return parent::delete($this->table, $id);
    }
}
?>
