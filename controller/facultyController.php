<?php
namespace app\controller;
use app\model\Faculty;

class FacultyController extends Faculty {
    private $faculty_id;
    private $first_name;
    private $last_name;
    private $dept;
    private $role;
    private $password;
    private $errors = [];

    public function verfiyInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkEmpty(){
        foreach ($_POST as $p){
			if(empty($p)){
				return array('error' => 'empty');
			}
		}
    }

    public function userLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") $errors["post"] = "ERROR!: METHOD NOT POST";  
        $this->checkEmpty(); 
        $this->faculty_id = $this->verfiyInput($_POST['faculty_id']);
        $this->password = $this->verfiyInput($_POST['password']);
        if(!filter_var($_SERVER['REQUEST_URI'], FILTER_VALIDATE_URL) === false ){
            $this->errors["url"] = "URL not Valid.";
            return $this->errors;
        }
        
        $result = $this->getByFacultyId((int)$this->faculty_id);
        if($result && count($result) > 0 && $result['faculty_id'] == $this->faculty_id && $this->password == $result['password'] ){
            $_SESSION['faculty_id'] = $result['faculty_id'];
            $_SESSION['first_name'] = $result['first_name'];
            $_SESSION['last_name'] = $result['last_name'];
            $_SESSION['dept'] = $result['dept_id'];
            $_SESSION['role'] = $result['role_id'];
            if($result['role_id'] == 0) header("Location:admin/admindash.php");
            if($result['role_id'] == 1) header("Location:hod/hod.php");
            if($result['role_id'] == 2) header("Location:staff/staffdash.php");
        }
        else{
            $this->errors["invalid"] = "Invalid Faculty Id or Password";
            return $this->errors;
        }
    }

    // public function addDepartment($dept_id, $dept_name){
    //     return $this->
    // }

    public function getFacultyId(){
        return $this->faculty_id;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function getLastName(){
        return $this->last_name;
    }

    public function getDept(){
        return $this->dept;
    }

    public function getRole(){
        return $this->role;
    }
}