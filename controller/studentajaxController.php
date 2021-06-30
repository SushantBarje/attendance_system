<?php
namespace app\controller;
require_once __DIR__ . '\..\vendor\autoload.php';
use app\controller\StudentController;


$student = new StudentController();

ob_start();
$req = $_GET['action'];

if($req == "get_student_class_report"){
    $r = $student->getStudentReportClass();
    die($r);
}else if($req == "get_student_class_pract_report"){
    $r = $student->getStudentReportClassPractical();
    die($r);
}

?>