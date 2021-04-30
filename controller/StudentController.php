<?php
namespace app\controller;
use app\model\Faculty;
use app\model\Student;

class StudentController extends Student {
    private $prn_no;
    private $first_name;
    private $middle_name;
    private $last_name;
    private $class_year;
    private $dept;
    private $sem;
    private $div;
    private $errors = [];

    public function studentLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") return $errors["post"] = "ERROR!: METHOD NOT POST";    
        $this->prn_no = $_POST['prn_no'];
        if(!filter_var($_SERVER['REQUEST_URI'], FILTER_VALIDATE_URL) === false ){
           $this->errors["url"] = "URL not Valid.";  
           return $this->errors;       
        }
        
        $result = $this->getStudentById([(int)$this->prn_no]);
        if($result && $result[0]['prn_no'] == $this->prn_no ){
            $_SESSION['prn_no'] = $result[0]['prn_no'];
            header("Location:student/studentdash.php");
        }
        else{
           $this->errors["invalid"] = "Invalid PRN Number";
           return $this->errors;
        }
    } 
}