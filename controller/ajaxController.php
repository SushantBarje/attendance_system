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
}else if($req == "delAcademicYear"){
    $r = $faculty->removeAcademicYear();
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
}else if ($req == "addHod"){
    $r = $faculty->addOneHod();
    die($r);
}else if($req == "delHod"){
    $r = $faculty->removeHod();
    die($r);
}else if($req == "hodDetails"){
    $r = $faculty->getAjaxHodDetailsById();
    die($r);
}else if($req == "getSem"){
    $r = $faculty->getSemesterByClassYear();
    die($r);
}else if($req == "addCourse"){
    $r = $faculty->addCourse();
    die($r);
}else if($req == "addStudent"){
    $r = $faculty->addStudent();
    die($r);
}else if($req == "addStaff"){
    $r = $faculty->addStaff();
    die($r);
}else if($req == "addClass"){
    $r = $faculty->addClass();
    die($r);
}else if($req == "attendanceSheet"){
    $r = $faculty->getStudentByClass();
    die($r);
}else if($req == "save_attend"){
    $r = $faculty->saveAttendance();
    die($r);
}else if($req == "add_bulk_student"){
    $r = $faculty->saveBulkStudent();
    die($r);
}else if($req == "report_acd_attend"){
    //$r = $faculty->reportAcademicWise();
    //die($r);
}else if($req == "addCourseDept"){
    $r = $faculty->addCourseByDept();
    die($r);
}else if($req == "admin_report"){
    $r = $faculty->viewAdminReport();
    die($r);
}
ob_end_flush();
?>