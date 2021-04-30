<?php

namespace app\controller;
use app\model\Faculty;
session_start();
class FacultyController extends Faculty {
    private $faculty_id;
    private $first_name;
    private $last_name;
    private $dept;
    private $role;
    private $password;
    private $errors = [];
    private $course_id;
    private $course_name;
    private $class;
    private $sem;
    private $s_first_name;
    private $s_middle_name;
    private $s_last_name;
    private $s_roll_no;
    private $s_div;
    private $s_batch;
    private $courses_ar = [];


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
            $_SESSION['role_id'] = $result[0]['role_id'];
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
        $data = $this->verifyInput($_POST['academic_year']);
        $result = $this->insertAcademicYear([$data]);
        if($result){
            $getacd = $this->getAcademicYear();
        }else{
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getacd));
       
    }

    public function removeAcademicYear(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = $this->verifyInput($_POST['id']);
        $result = $this->deleteAcademicYear([$id]);
        if($result){ 
            $getAcd = $this->getAcademicYear(); 
        }
        else {
            return json_encode(array("error" => "notdelete"));
        }
        return json_encode(array("error" => "none","data" => $getAcd));
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

    public function addCourse(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->course_id = $this->verifyInput($_POST['course_id']);
        if($this->getCourseById([$this->course_id])) return json_encode(array("error" => "exists"));
        $this->course_name = $this->verifyInput($_POST['course_name']);
        $this->dept = (int)$this->verifyInput($_POST['course_dept']);
        $this->class = (int)$this->verifyInput($_POST['course_class']);
        $this->sem = (int)$this->verifyInput($_POST['s_sem']);
        $result = $this->insertCourse([$this->course_id, $this->course_name, $this->dept, $this->class, $this->sem]);
        if($result){ 
            $getHod = $this->getCourses();
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getHod));
    }


    public function addStudent(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->prn_no = $this->verifyInput($_POST['prn']);
        if($this->getStudentById([$this->prn_no])) return json_encode(array("error" => "exists"));
        $this->s_first_name = $this->verifyInput($_POST['fname']);
        $this->s_middle_name = $this->verifyInput($_POST['mname']);
        $this->s_last_name = $this->verifyInput($_POST['lname']);
        $this->s_roll_no = $this->verifyInput($_POST['roll_no']);
        $this->class = (int)$this->verifyInput($_POST['class_year']);
        $this->dept = (int)$this->verifyInput($_POST['s_dept']);
        $this->s_div = (int)$this->verifyInput($_POST['s_div']);
        $this->s_batch = (int)$this->verifyInput($_POST['s_batch']);
        $result = $this->insertOneStudent([$this->prn_no, $this->s_first_name, $this->s_middle_name, $this->s_last_name, $this->s_roll_no, $this->dept, $this->class, $this->s_div, $this->s_batch]);
        if($result){ 
            $getdata = $this->getAllStudent();
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function addStaff(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->faculty_id = $this->verifyInput($_POST['faculty_id']);
        if($this->getFacultyById([$this->faculty_id])) return json_encode(array("error" => "exists"));
        $this->first_name = $this->verifyInput($_POST['fname']);
        $this->last_name = $this->verifyInput($_POST['lname']);
        $this->role = 2;
        $this->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $result = $this->insertOneFaculty([$this->faculty_id, $this->first_name, $this->last_name, $_SESSION['dept'], $this->role, $this->password]);
        if($result){ 
            $getStaff = $this->getFacultyByRole([2]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getStaff));
    }


    public function addClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->faculty_id = $this->verifyInput($_POST['faculty_s']);
        $this->courses_ar = $this->verifyInput($_POST['courses']);
        foreach($this->courses_ar as $course){
            $result = $this->insertOneClass($this->faculty_id, $course, 83);
            if(!$result) return json_encode(array("error" => "notinsert"));
        }
        $getclass = $this->getClassByDept([$_SESSION['dept']]);
        return json_encode(array("error" => "none", "data" => $getclass));
    }

    public function getStudentByClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->class_id = $this->verifyInput($_POST['data']);
        return json_encode($this->selectStudentByDeptAndClass([$_SESSION['dept_id'],$this->class_id]));
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