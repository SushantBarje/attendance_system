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

    // public function test(){
    //     $this->insertOneFaculty([1,"admin","admin",44,0,password_hash($_POST['pwd'], PASSWORD_DEFAULT)]);
    // }

    public function userLogin(){
        if($_SERVER['REQUEST_METHOD'] != "POST") $errors["post"] = "ERROR!: METHOD NOT POST";  
        $this->checkEmpty(); 
        $this->faculty_id = $this->verifyInput($_POST['faculty_id']);
        $this->password =$this->verifyInput($_POST['password']);
        if(!filter_var($_SERVER['REQUEST_URI'], FILTER_VALIDATE_URL) === false ){
            $this->errors["url"] = "URL not Valid.";
            return $this->errors;
        }
        
        $result = $this->getFacultyById([(int)$this->faculty_id]);
        if($result && $result[0]['faculty_id'] == $this->faculty_id && password_verify($this->password ,$result[0]['password'])){
            $_SESSION['faculty_id'] = $result[0]['faculty_id'];
            $_SESSION['first_name'] = $result[0]['first_name'];
            $_SESSION['last_name'] = $result[0]['last_name'];
            $_SESSION['dept'] = $result[0]['dept_id'];
            $_SESSION['role'] = $result[0]['role_id'];
            if($result[0]['role_id'] == 0) header("Location:admin/admindash.php");
            if($result[0]['role_id'] == 1) header("Location:hod/hodHeader.php");
            if($result[0]['role_id'] == 2) header("Location:staff/staffHeader.php");
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
        if($this->getFacultyById([$this->faculty_id])) return json_encode(array("error" => "exists"));
        $this->first_name = $this->verifyInput($_POST['fname']);
        $this->last_name = $this->verifyInput($_POST['lname']);
        $this->dept = $this->verifyInput($_POST['dept']);
        $this->role = 1;
        $this->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $result = $this->insertOneFaculty([$this->faculty_id, $this->first_name, $this->last_name, $this->dept, $this->role, $this->password]);
        if($result){ 
            $getHod = $this->getFacultyByRole([1]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getHod));
    }

    public function removeHod(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = $this->verifyInput($_POST['id']);
        $result = $this->deleteFacultyById([$id]);
        if($result){ 
            $getHod = $this->getFacultyByRole([1]);
        }
        else {
            return json_encode(array("error" => "notdelete"));
        }
        return json_encode(array("error" => "none","data" => $getHod));
    }

    public function getAjaxHodDetailsById(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = $this->verifyInput($_POST['data']);
        $getHod = $this->getFacultyById([$id]);
        return json_encode(array("error" => "none","data" => $getHod));
    }

    public function getSemesterByClassYear(){   
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = $this->verifyInput($_POST['data']);
        $getdata = $this->getSemesterByYearId([$id]);
        return json_encode(array("error" => "none","data" => $getdata));
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