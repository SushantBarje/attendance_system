<?php
namespace app\controller;
use app\model\Student;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

    public function verifyInput($data){
        if(is_array($data)){
            $data = array_map('trim', $data);
            $data = array_map('stripslashes', $data);
            $data = array_map('htmlspecialchars',$data);
            return $data;
        }else{
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }

    public function checkEmpty(){
        foreach ($_POST as $p){
			if(empty($p)){
				return true;
			}
		}
        return false;
    }

    public function studentLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") return $errors["post"] = "ERROR!: METHOD NOT POST";    
        if($this->checkEmpty()) return $errors["empty"] = "Please enter valid PRN no.";
        
        $this->prn_no = $this->verifyInput($_POST['prn_no']);
        if(!filter_var($_SERVER['REQUEST_URI'], FILTER_VALIDATE_URL) === false ){
           $this->errors["url"] = "URL not Valid.";  
           return $this->errors;       
        }
        
        $result = $this->getStudentById([(int)$this->prn_no]);
        if($result && $result[0]['prn_no'] == $this->prn_no ){
            $_SESSION['prn_no'] = $result[0]['prn_no'];
            $_SESSION['first_name'] = $result[0]['first_name'];
            $_SESSION['middle_name'] = $result[0]['middle_name'];
            $_SESSION['last_name'] = $result[0]['last_name'];
            $_SESSION['roll_no'] = $result[0]['roll_no'];
            $_SESSION['dept_id'] = $result[0]['dept_id'];
            $_SESSION['year_id'] = $result[0]['year_id'];
            $_SESSION['batch_id'] = $result[0]['batch_id'];
            $_SESSION['div_id'] = $result[0]['div_id'];
            header("Location:student/generatereport.php");
        }
        else{
           $this->errors["invalid"] = "Invalid PRN Number";
           return $this->errors;
        }
    } 

    public function showGrandReport(){

            $result = $this->getStudentReport([$_SESSION['prn_no'],$_SESSION['year_id']]);
            if($result) return array("error" => "none", "data" => $result);

      
        //if($this->checkEmpty()) return $errors["empty"] = "Please enter valid PRN no.";
    }

    public function showGrandReportPractical(){
        $result = $this->getStudentReportPractical([$_SESSION['prn_no']]);
        if($result) return array("error" => "none", "data" => $result);
    }

    public function getStudentReportClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $data = $this->verifyInput($_POST['data']);
        $result = $this->getClassReport([$data, $_SESSION['prn_no']]);
        
        if(!$result) return json_encode(array("error" => "notfound"));
        else if(isset($result["e"])) return json_encode(array("error" => "sql" , "msg" => $result["e"]));
        else return json_encode(array("error" => "none", "data" => $result));
    }

    public function getStudentReportClassPractical(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $data = $this->verifyInput($_POST['data']);
        $result = $this->getClassReportPractical([$data, $_SESSION['prn_no']]);
        
        if(!$result) return json_encode(array("error" => "notfound"));
        else if(isset($result["e"])) return json_encode(array("error" => "sql" , "msg" => $result["e"]));
        else return json_encode(array("error" => "none", "data" => $result));
    }
}