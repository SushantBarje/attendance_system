<?php
namespace app\controller;
require_once __DIR__ . '\..\vendor\autoload.php';
use app\controller\FacultyController;
$faculty = new FacultyController();

ob_start();
$req = $_GET['action'];

if($req == "addAcademicYear"){
    $r =  $faculty->addAcadYear();
    die($r);
}else if($req == "addDept"){
    $r = $faculty->addDepartment();
    die($r);
}else if($req == "editDept"){
    $r = $faculty->editDepartment();
    die($r);
}else if($req == "delDept"){
    $r = $faculty->removeDepartment();
    die($r);
}
ob_end_flush();
?>