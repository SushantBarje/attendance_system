<?php
namespace app\controller;
require_once __DIR__ . '\..\vendor\autoload.php';
use app\controller\FacultyController;

$faculty = new FacultyController();

if($_REQUEST['action'] == 'addDepartment'){
    $faculty->getDepartment()
}

?>