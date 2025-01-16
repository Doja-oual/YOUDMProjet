<?php
namespace App\Controller;
require_once '../../vendor/autoload.php';
use App\Core\Controller;
use  App\Models\Tag;

class FrontController extends Controller{

    public function listTags() {
        $tagModel=new Tag();
        $tags =$tagModel->showTag();//pour recupere tous las tag
        $this->view('');
       
    }
}
