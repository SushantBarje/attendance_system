<?php

namespace app\controller;
use app\model\Faculty;
use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
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
    private $time;
    private $attend = [];
    private $acd_year;


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
        $this->faculty_id = (int)$this->verifyInput($_POST['faculty_id']);
        if($this->getFacultyById([$this->faculty_id])) return json_encode(array("error" => "exists"));
        $this->first_name = $this->verifyInput($_POST['fname']);
        $this->last_name = $this->verifyInput($_POST['lname']);
        $this->dept = (int)$this->verifyInput($_POST['dept']);
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

    public function editHod(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->faculty_id = (int)$this->verifyInput($_POST['faculty_id']);
        if(!$this->getFacultyById([$this->faculty_id])) return json_encode(array("error" => "notexists"));
        $this->first_name = $this->verifyInput($_POST['fname']);
        $this->last_name = $this->verifyInput($_POST['lname']);
        $this->dept = (int)$this->verifyInput($_POST['dept-id']);
        $result = $this->updateOneFaculty([$this->first_name, $this->last_name, $this->dept, $this->faculty_id]);
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

    public function getSemesterByClassYear(){   
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = $this->verifyInput($_POST['data']);
        $getdata = $this->getSemesterByYearId([$id]);
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function addCourse(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->course_id = (int)$this->verifyInput($_POST['course_id']);
        if($this->getCourseById([$this->course_id])) return json_encode(array("error" => "exists"));
        $this->course_name = $this->verifyInput($_POST['course_name']);
        $this->dept = (int)$this->verifyInput($_POST['course_dept']);
        $this->class = (int)$this->verifyInput($_POST['course_class']);
        $this->sem = (int)$this->verifyInput($_POST['s_sem']);
        $result = $this->insertCourse([$this->course_id, $this->course_name, $this->dept, $this->class, $this->sem]);
        if($result){ 
            $getCourse = $this->getCourses();
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getCourse));
    }

    public function editCourseById(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->course_id = (int)$this->verifyInput($_POST['edit_course_id']);
        if(!$this->getCourseById([$this->course_id])) return json_encode(array("error" => "notexists"));
        $this->course_name = $this->verifyInput($_POST['edit_course_name']);
        $this->dept = (isset($_POST['edit_course_dept'])) ? (int)$this->verifyInput($_POST['edit_course_dept']) : $_SESSION['dept'];
        $this->class = (int)$this->verifyInput($_POST['edit_course_class']);
        $this->sem = (int)$this->verifyInput($_POST['edit_course_sem']);
        $result = $this->updateCourse([$this->course_id, $this->course_name, $this->dept, $this->class, $this->sem, $this->course_id]);
        if($result){ 
            $getCourse = $_SESSION['role_id'] === 0 ? $this->getCourses() : $this->getCoursesByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getCourse));
    }

    public function removeCourse(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->course_id = (int)$this->verifyInput($_POST['id']);
        if(!$this->getCourseById([$this->course_id])) return json_encode(array("error" => "notexists"));
        $result = $this->deleteCourseById([$this->course_id]);
        if($result){ 
            $getCourse = $_SESSION['role_id'] === 0 ? $this->getCourses() : $this->getCoursesByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getCourse));
    }

    public function addCourseByDept(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->course_id = $this->verifyInput($_POST['course_id']);
        if($this->getCourseById([$this->course_id])) return json_encode(array("error" => "exists"));
        $this->course_name = $this->verifyInput($_POST['course_name']);
        $this->dept = (int)$this->verifyInput($_SESSION['dept']);
        $this->class = (int)$this->verifyInput($_POST['course_class']);
        $this->sem = (int)$this->verifyInput($_POST['s_sem']);
        $result = $this->insertCourse([$this->course_id, $this->course_name, $this->dept, $this->class, $this->sem]);
        if($result){ 
            $getHod = $this->getCoursesByDept([$_SESSION['dept']]);
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
        $this->dept = (!isset($_POST['s_dept'])) ? $_SESSION['dept'] : (int)$this->verifyInput($_POST['s_dept']);
        $this->s_div = (int)$this->verifyInput($_POST['s_div']);
        $this->s_batch = (int)$this->verifyInput($_POST['s_batch']);
        $result = $this->insertOneStudent([$this->prn_no, $this->s_first_name, $this->s_middle_name, $this->s_last_name, $this->s_roll_no, $this->dept, $this->class, $this->s_batch, $this->s_div]);
        if($result){ 
            $getdata = $this->getStudentByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function editStudent(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->prn_no = (float)$this->verifyInput($_POST['prn']);
        if(!$this->getStudentById([$this->prn_no])) return json_encode(array("error" => "notexists"));
        $this->s_first_name = $this->verifyInput($_POST['fname']);
        $this->s_middle_name = $this->verifyInput($_POST['mname']);
        $this->s_last_name = $this->verifyInput($_POST['lname']);   
        $this->s_roll_no = $this->verifyInput($_POST['roll_no']);
        $this->class = (int)$this->verifyInput($_POST['class_year']);
        $this->dept = (!isset($_POST['s_dept'])) ? $_SESSION['dept'] : (int)$this->verifyInput($_POST['s_dept']);
        $this->s_div = isset($_POST['s_div']) ? (int)$this->verifyInput($_POST['s_div']) : 1;
        $this->s_batch = (int)$this->verifyInput($_POST['s_batch']);
        $result = $this->updateOneStudent([$this->s_first_name, $this->s_middle_name, $this->s_last_name, $this->s_roll_no, $this->dept, $this->class, $this->s_batch, $this->s_div, $this->prn_no]);
        if($result){ 
            $getdata = $_SESSION['role_id'] === 0 ? $this->getAllStudent() : $this->getStudentByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function removeStudent(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->prn_no = $this->verifyInput($_POST['id']);
        if(!$this->getStudentById([$this->prn_no])) return json_encode(array("error" => "notexists"));
        $result = $this->deleteStudentById([$this->prn_no]);
        if($result){ 
            $getdata = $_SESSION['role_id'] === 0 ? $this->getAllStudent() : $this->getStudentByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function saveBulkStudent(){
        $this->checkEmpty();
        $this->class = $this->verifyInput($_POST['class']);
        $this->div_id = isset($_POST['div_id']) ? $_POST['div_id'] : 1;
        $allowedFileType = [
            'application/vnd.ms-excel',
            'text/xls',
            'text/xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        if(in_array($_FILES["file"]["type"], $allowedFileType)) {
            $targetPath = '../uploads/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
    
            $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    
            $spreadSheet = $Reader->load($targetPath);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();
            $sheetCount = count($spreadSheetAry);

            for ($i = 0; $i <= $sheetCount; $i++) {
                
                //echo $spreadSheetAry[$i][0]." ".$last_name." ".$spreadSheetAry[$i][2]." ".$spreadSheetAry[$i][3];
                $roll_no = "";
                if (isset($spreadSheetAry[$i][0])) {
                    $roll_no = $this->verifyInput($spreadSheetAry[$i][0]);
                }
                $first_name = $last_name = $middle_name = "";
                if (isset($spreadSheetAry[$i][1])) {
                    list($last_name, $first_name, $middle_name) = explode(" ",$spreadSheetAry[$i][1]);
                }

                $prn_no = "";
                if (isset($spreadSheetAry[$i][2])) {
                    $prn_no = $this->verifyInput($spreadSheetAry[$i][2]);
                }

                $batch = "";
                if (isset($spreadSheetAry[$i][3])) {
                    $batch = $this->verifyInput($spreadSheetAry[$i][3]);
                }
                if (!empty($prn_no) || !empty($first_name) || !empty($middle_name) || !empty($last_name) || !empty($roll_no) || !empty($batch)) {
                    $result = $this->insertOneStudent([$prn_no, $first_name, $middle_name, $last_name, $roll_no, $_SESSION['dept'], $this->class, $batch, $this->div_id]);
                    if(!$result) return json_encode(array("error" => "notinsert"));
                }
            }
        } else {
            return json_encode(array("error" => "type"));
        }
        return json_encode(array("error" => "none"));
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
            $getStaff = $this->getFacultyByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getStaff));
    }

    public function editStaff(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->faculty_id = $this->verifyInput($_POST['faculty_id']);
        if(!$this->getFacultyById([$this->faculty_id])) return json_encode(array("error" => "notexists"));
        $this->first_name = $this->verifyInput($_POST['fname']);
        $this->last_name = $this->verifyInput($_POST['lname']);
        $this->role = 2;
        $this->dept_id = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $result = $this->updateOneFaculty([$this->first_name, $this->last_name, $this->dept_id, $this->faculty_id]);
        if($result){ 
            $getStaff = $_SESSION['role_id'] === 0 ? $this->getAllFaculty() : $this->getFacultyByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getStaff));
    }

    public function removeStaff(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $id = (int)$this->verifyInput($_POST['id']);
        $result = $this->deleteFacultyById([$id]);
        if($result){ 
            $getStaff = $_SESSION['role_id'] === 0 ? $this->getFacultyByRole([2]) : $this->getFacultyByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notdelete"));
        }
        return json_encode(array("error" => "none","data" => $getStaff));
    }

    public function addClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->acd_year = $this->verifyInput($_POST['acd_year']);
        $this->faculty_id = $this->verifyInput($_POST['faculty_s']);
        $this->courses_ar = (array)$this->verifyInput($_POST['courses']);
        $this->dept = isset($_POST['dept']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $result = true;
        foreach($this->courses_ar as $course){
            $c = $this->getCourseById([$course]);
            $result = $this->insertOneClass([$this->faculty_id, $course, $this->dept, (int)$c["s_class_id"], (int)$c["sem_id"], $this->acd_year]);
        }
        if(!$result) return json_encode(array("error" => "notinsert"));
        $getclass = $this->getClassByDept([$_SESSION['dept']]);
        return json_encode(array("error" => "none", "data" => $getclass));
    }

    public function getStudentByClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->class_id = $this->verifyInput($_POST['data']);
        return json_encode($this->selectStudentByDeptAndClassForAttend([$_SESSION['dept'],$this->class_id]));
    }

    public function removeClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->class_id = (int)$this->verifyInput($_POST['id']);
        //if(!$this->getStudentById([$this->class_id])) return json_encode(array("error" => "notexists"));
        $result = $this->deleteClassById([$this->class_id]);
        if($result){ 
            $getdata = $_SESSION['role_id'] === 0 ? $this->getAllClass() : $this->getClassByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function saveAttendance(){
        $this->checkEmpty();
        $this->class = $this->verifyInput($_POST['class']);
        $this->attend = $this->verifyInput($_POST['attend']);
        $this->year = $this->verifyInput($_POST['academic_year']);
        date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d H:i:s");
        $this->time = $timestamp;
        $result = $this->insertAttendanceList([(int)$this->class,$this->time,(int)$this->year]);
        if($result){
            foreach((array)$this->attend as $key => $value){
                $r = $this->insertStudentAttendance([(int)$result,(int)$key,(int)$value]);
                if(!$r) return json_encode(array("error" => "notinsert"));
            }
            
        }else{
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none"));
    }

    public function viewAdminReport(){
        $sql_query = "";
        $data = [];
        if(!empty($_POST['academic_year'])){
            $sql_query .= "academic_year = ?";
            $data[] = $this->verifyInput($_POST['academic_year']);
        }
        if(!empty($_POST['deptartment'])){
            $sql_query .= "AND dept_id = ?";
            $data[] = $this->verifyInput($_POST['deptartment']);
        }
        if(!empty($_POST['classyear'])){
            $sql_query .= "AND s_class_id = ?";
            $data[] = $this->verifyInput($_POST['classyear']);
        }
        if(!empty($_POST['start_date'])){
            $sql_query .= "AND DATE(date_time)) BETWEEN ? AND ?";
            $data[] = $this->verifyInput($_POST['start_date']);
        }
        if(!empty($_POST['end_date'])){
            $sql_query .= "<= date_time = ?";
            $data[] = $this->verifyInput($_POST['end_date']);
        }

        //$result = $this->getAdminReport($sql_query,[$data]);
    }

    // public function reportAcademicWise(){
    //     $this->checkEmpty();
    //     $this->acd_id = $this->verifyInput($_POST['data']);
        
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