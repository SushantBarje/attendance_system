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
    public $errors = [];

    public function userLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") $errors["post"] = "ERROR!: METHOD NOT POST";    
        $this->faculty_id = $_POST['username'];
        $this->password = $_POST['password'];
        if(!filter_var($_SERVER['REQUEST_URI'], FILTER_VALIDATE_URL) === false ){
            $errors["url"] = "URL not Valid.";
            header("Location:index.php");
        }
        
        $result = $this->getByFacultyId((int)$this->faculty_id);
        if(count($result) > 0 && $result['faculty_id'] == $this->faculty_id && $this->password == $result['password'] ){
            $_SESSION['faculty_id'] = $result['faculty_id'];
            $_SESSION['role'] = $result['role_id'];
            if($result['role_id'] == 0) header("Location:admin/admindash.php");
            if($result['role_id'] == 1) header("Location:hod.php");
            if($result['role_id'] == 2) header("Location:staff.php");
        }
        else{
            $errors["invalid"] = "Invalid Faculty Id or Password";
            header("Location:index.php");
        }
    }
}