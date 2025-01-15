<?php
namespace App\Models;
require_once '../../vendor/autoload.php';
use Config\Database;
use App\Core\Model;

class Tag extends Model {
    protected $table = 'Tag';

    public function __construct() {
        $this->conn = Database::getConnection();
    }

   
    public function showTag() {
        return parent::show($this->table);
    }

    public function addTag($data) {
        return parent::add($this->table, $data);
    }

    public function updateTag($id, $data) {
        return parent::update($this->table, $id, $data);
    }

    public function deleteTag($id) {
        return parent::delete($this->table, $id);
    }
}
?>
