<?php
namespace app\controller;
use app\model\Faculty;

class StudentController extends Faculty {
    private $prn_no;
    private $first_name;
    private $middle_name;
    private $last_name;
    private $class_year;
    private $dept;
    private $sem;
    private $div;
    public $errors = [];

    public function studentLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") $errors["post"] = "ERROR!: METHOD NOT POST";    
        $this->prn_no = $_POST['prn_no'];
        if(!filter_var($_SERVER['REQUEST_URI'], FILTER_VALIDATE_URL) === false ){
            $errors["url"] = "URL not Valid.";
            return $errors;
        }
        
        $result = $this->getStudentById((int)$this->prn_no);
        if($result && $result['prn_no'] == $this->prn_no ){
            $_SESSION['prn_no'] = $result['prn_no'];
            header("Location:student/studentdash.php");
        }
        else{
            $errors = array("invalid" => "Invalid PRN Number");
            return $errors;
        }
    } 
}