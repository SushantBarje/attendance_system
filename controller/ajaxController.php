<?php
namespace app\controller;
require_once __DIR__ . '\..\vendor\autoload.php';
use app\controller\FacultyController;

$faculty = new FacultyController();

$req = $_GET['action'];

if($req == "addAcademicYear"){
    $r =  $faculty->addAcadYear();
    echo $r;
}

?>