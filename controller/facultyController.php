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

    public function verifyInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkEmpty(){
        foreach ($_POST as $p){
			if(empty($p)){
				return true;
			}
		}
    }

    public function userLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") $errors["post"] = "ERROR!: METHOD NOT POST";  
        $this->checkEmpty(); 
        $this->faculty_id = $this->verifyInput($_POST['faculty_id']);
        $this->password = $this->verifyInput($_POST['password']);
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
            if($result['role_id'] == 1) header("Location:hod/hodHeader.php");
            if($result['role_id'] == 2) header("Location:staff/staffHeader.php");
        }
        else{
            $this->errors["invalid"] = "Invalid Faculty Id or Password";
            return $this->errors;
        }
    }

    public function addDepartment(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $data = $this->verifyInput($_POST['dptname']);
        $result = $this->insertDepartment([$data]);
        if($result){ 
            $getDpt = $this->getDepartment(); 
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getDpt));
    }

    public function addAcadYear(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $data = $this->verifyInput($_POST['acd']);
        $lastid = $this->insertAcademicYear([$data]);
        $getresult = $this->getAcademicYearById([$lastid]);
        return json_encode(array("error" => $lastid,"data" => $getresult));
       
    }

    public function editDepartment(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $data = $this->verifyInput($_POST['editdptname']);
        $id = $this->verifyInput($_POST['dept_id']);
        $result = $this->updateDepartmentById([$data, $id]);
        if($result){ 
            $getDpt = $this->getDepartment(); 
        }
        else {
            return json_encode(array("error" => "noteidt"));
        }
        return json_encode(array("error" => "none","data" => $getDpt));
    }

    public function removeDepartment(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = $this->verifyInput($_POST['id']);
        $result = $this->deleteDepartment([$id]);
        if($result){ 
            $getDpt = $this->getDepartment(); 
        }
        else {
            return json_encode(array("error" => "notdelete"));
        }
        return json_encode(array("error" => "none","data" => $getDpt));
    }

    public function addOneHod(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->faculty_id = $this->verifyInput($_POST['faculty_id']);
        $this->first_name = $this->verifyInput($_POST['fname']);
        $this->last_name = $this->verifyInput($_POST['lname']);
        $this->dept = $this->verifyInput($_POST['dept']);
        $this->role = 2;
        $this->password = password_hash($_POST['password'], 'PASSWORD_DEFAULT');
        $result = $this->insertOneHod([$this->faculty_id, $this->first_name, $this->last_name, $this->dept, $this->role, $this->password]);
        if($result){ 
            $getDpt = $this->getDepartment(); 
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getDpt));
    }

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