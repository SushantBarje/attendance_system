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
}else if($req == "staff_report"){
    $r = $faculty->viewStaffReport();
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
}else if($req == "editHod"){
    $r = $faculty->editHod();
    die($r);
}else if($req == "delHod"){
    $r = $faculty->removeHod();
    die($r);
}else if($req == "getSem"){
    $r = $faculty->getSemesterByClassYear();
    die($r);
}else if($req == "addCourse"){
    $r = $faculty->addCourse();
    die($r);
}else if($req == "editCourse"){
    $r = $faculty->editCourseById();
    die($r);
}else if($req == "delCourse"){
    $r = $faculty->removeCourse();
    die($r);
}else if($req == "addStudent"){
    $r = $faculty->addStudent();
    die($r);
}else if($req == "editStudent"){
    $r = $faculty->editStudent();
    die($r);
}else if($req == "delStudent"){
    $r = $faculty->removeStudent();
    die($r);
}else if($req == "add_bulk_student"){
    $r = $faculty->saveBulkStudent();
    die($r);
}else if($req == "addStaff"){
    $r = $faculty->addStaff();
    die($r);
}else if($req == "editStaff"){
    $r = $faculty->editStaff();
    die($r);
}else if($req == "delStaff"){
    $r = $faculty->removeStaff();
    die($r);
}else if($req == "addClass"){
    $r = $faculty->addClass();
    die($r);
}else if($req == "delClass"){
    $r = $faculty->removeClass();
    die($r);
}else if($req == "add_pract_class"){
    $r = $faculty->addPracticalClass();
    die($r);
}else if($req == "get_acd_class"){
    $r = $faculty->getClassForStaffAcademic();
    die($r);
}else if($req == "check_theory_attend"){
    $r = $faculty->showStudentByClassForAttendance();
    die($r);
}else if($req == "save_attend"){
    $r = $faculty->saveAttendance();
    die($r);
}else if($req == "addCourseDept"){
    $r = $faculty->addCourseByDept();
    die($r);
}else if($req == "hod_report"){
    $r = $faculty->getHodReport();
    die($r);
}else if($req == "get_faculty_dept_wise"){
    $r = $faculty->showFacultyByDept();
    die($r);
}else if($req == "get_year_belong_dept"){
    $r = $faculty->showYearBelongsDept();
    die($r);
}else if($req == "get_class_div_wise"){
    $r = $faculty->showClassByDiv();
    die($r);
}else if($req == "get_div_belongs_dept"){
    $r = $faculty->showDivBelongsDept();
    die($r);
}else if($req == "admin_report"){
    $r = $faculty->showAdminReport();
    die($r);
}else if($req == "get_attend_details_class"){
  $r = $faculty->showAttendTakenClass();
  die($r);
}else if($req == "del_attend"){
    $r = $faculty->removeAttendance();
    die($r);
}else if($req == "perform_hod_report"){
    $r = $faculty->showHodReport();
    die($r);
}else if($req == "get_class_sem_wise"){
    $r = $faculty->showClassSemWise();
    die($r);
}else if($req == "get_courses_sem_wise"){
    $r = $faculty->showCoursesBySem();
    die($r);
}else if($req == "check_pract_attend"){
    $r = $faculty->showPractAttendance();
    die($r);
}else if($req == "save_pract_attendance"){
    $r = $faculty->savePracticalAttendance();
    die($r);
}else if($req == "get_pract_class_sem_wise"){
    $r = $faculty->showPractClassBySemester();
    die($r);
}else if($req == "get_staff_pract_report"){
    $r = $faculty->showPracticalReport();
   die($r);
}else if($req == "get_pract_report"){
    $r = $faculty->showPracticalReport();
   die($r);
}else if($req == "get_pract_class_by_acd"){
    $r = $faculty->showPracticalClassByAcademicYear();
    die($r);
}else if($req == "get_theory_class_by_acd"){
    $r = $faculty->showTheroyClassByAcademicYear();
    die($r);
}else if($req = "promote_class"){
    $r = $faculty->promoteStudentYear();
    echo $r;
    die();
}
ob_end_flush();
