<?php

namespace app\controller;
use app\model\Faculty;
use PDO;
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
    private $div = [];
    private $class_year = [];
    private $s_batch;
    private $courses_ar = [];
    private $time;
    private $attend = [];
    private $acd_year;
    private $from_date;
    private $till_date;
    private $year;
    private $batch_ar = [];


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
        
        $result = $this->getFacultyByIdLogin([(int)$this->faculty_id]);
        if($result && $result[0]['faculty_id'] == $this->faculty_id && password_verify($this->password ,$result[0]['password'])){
            $_SESSION['faculty_id'] = $result[0]['faculty_id'];
            $_SESSION['first_name'] = $result[0]['first_name'];
            $_SESSION['last_name'] = $result[0]['last_name'];
            if(isset($result[0]['dept_id'])) $_SESSION['dept'] = $result[0]['dept_id'];
            $_SESSION['role_id'] = $result[0]['role_id'];
            if($result[0]['role_id'] == 0) header("Location:admin/admindash.php");
            if($result[0]['role_id'] == 1) header("Location:hod/home.php");
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
        $this->class_year = (array)$this->verifyInput($_POST['year']);
        $this->div = (array)$this->verifyInput($_POST['div']);
        $result = $this->insertDepartment([$data]);
        if($result){ 
            foreach($this->class_year as $c){
               $r = $this->insertYearBelongsDept([$result, $c]);
            }

            foreach($this->div as $d){
                $r = $this->insertDivBelongsDept([$result, $d]);
            }
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
        $this->course_id = (int)$this->verifyInput($_POST['course_id']);
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
        $this->s_roll_no = (int)$this->verifyInput($_POST['roll_no']);
        $this->class = (int)$this->verifyInput($_POST['class_year']);
        $this->dept = (!isset($_POST['s_dept'])) ? $_SESSION['dept'] : (int)$this->verifyInput($_POST['s_dept']);
        $this->s_div = (int)$this->verifyInput($_POST['s_div']);
        $this->s_batch = (int)$this->verifyInput($_POST['s_batch']);
        if($this->getStudentByRollno([$this->s_roll_no, $this->class, $this->dept, $this->s_div])) return json_encode(array("error" => "exists"));
        $result = $this->insertOneStudent([$this->prn_no, $this->s_first_name, $this->s_middle_name, $this->s_last_name, $this->s_roll_no, $this->dept, $this->class, $this->s_batch, $this->s_div]);
        if($result){ 
            $acd_year_last = $this->getLastAcademicYear();
            $class_found = $this->checkIfClassAttendanceExisits([$this->dept, $this->class, $this->s_div, $acd_year_last["acedemic_id"]]);
            if($class_found){
                for($i = 0; $i < count($class_found); $i++){
                    $student_present_in_attendance = $this->checkStudentPresentInAttendance([$class_found[$i]["class_id"], $this->prn_no, $class_found[$i]["date_time"]]);
                    if(!$student_present_in_attendance){
                        $status = 0;
                        $this->insertStudentAttendance([$class_found[$i]['class_id'], $this->prn_no, $status, $class_found[$i]['date_time']]);
                    }
                    
                }
            }
            $getdata = $this->getStudentByDept([$_SESSION['dept']]);
        }
        else {
            return json_encode(array("error" => "notinsert"));
        }
        return json_encode(array("error" => "none","data" => $getdata));
    }

    public function editStudent(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->prn_no = $this->verifyInput($_POST['prn']);
        $result = $this->getStudentById([$this->prn_no]);
        if(!$result) return json_encode(array("error" => "notexists"));
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

            function hasDuplicatedValues($excelSheet, $column, $ignoreEmptyCells = false) {
                $cells = array();
                foreach ($excelSheet->getRowIterator() as $row) {
                    $cell = $excelSheet->getCell($column . $row->getRowIndex())->getValue();
                    if (($ignoreEmptyCells == false) && (empty($cell) == false)) {
                        $cells[] = $cell;
                    }
                }
                
                return count(array_unique($cells)) < count($cells);
            }
            if(hasDuplicatedValues($excelSheet, 'A')) return array("error" => "duplicateRoll");
            if(hasDuplicatedValues($excelSheet, 'C')) return array("error" => "duplicatePrn");
            $count = 0;
            for ($i = 0; $i <= $sheetCount; $i++) {
                $roll_no = "";
                if (isset($spreadSheetAry[$i][0])) {
                    $roll_no = $this->verifyInput($spreadSheetAry[$i][0]);
                }
                $first_name = $last_name = $middle_name = "";
                if (isset($spreadSheetAry[$i][1])) {
                    list($last_name, $first_name, $middle_name) = explode(" ",$spreadSheetAry[$i][1]);
                    if(empty($last_name)) $last_name = " ";
                }

                $prn_no = "";
                if (isset($spreadSheetAry[$i][2])) {
                    $prn_no = $this->verifyInput($spreadSheetAry[$i][2]);
                }

                $batch = "";
                if (isset($spreadSheetAry[$i][3])) {
                    $batch = $this->verifyInput($spreadSheetAry[$i][3]);
                    $batch = $this->searchBatch(['%'.$batch.'%']);
                    $batch = $batch[0]['batch_id'];
                }
                $div_id = "";
                if (isset($spreadSheetAry[$i][4])) {
                    $div = $this->verifyInput($spreadSheetAry[$i][4]);
                    $div_id = $this->searchDivision(['%'.$div.'%']);
                    $div_id = $div_id[0]['div_id'];
                }
                $this->dept = (isset($_POST['dept_id'])) ? $this->verifyInput($_POST['dept']) : $_SESSION['dept'];
                $dup = [];
                if (!empty($prn_no) || !empty($first_name) || !empty($middle_name) || !empty($last_name) || !empty($roll_no) || !empty($batch)) {
                    if(!$this->getStudentById([$prn_no])){
                        $result = $this->insertOneStudent([$prn_no, $first_name, $middle_name, $last_name, $roll_no, $_SESSION['dept'], $this->class, $batch, $div_id]);
            
                        $acd_year_last = $this->getLastAcademicYear();
                        $class_found = $this->checkIfClassAttendanceExisits([$this->dept, $this->class, $div_id, $acd_year_last["acedemic_id"]]);
                        if($class_found){
                            for($i = 0; $i < count($class_found); $i++){
                                $student_present_in_attendance = $this->checkStudentPresentInAttendance([$class_found[$i]["class_id"], $prn_no, $class_found[$i]["date_time"]]);
                                if(!$student_present_in_attendance){
                                    $status = 0;
                                    $this->insertStudentAttendance([$class_found[$i]['class_id'], $prn_no, $status, $class_found[$i]['date_time']]);
                                } 
                            }
                        }
                    }else{
                        $count++;
                        $dup[] = $prn_no;
                    }
                    
                    //if(!$result) return json_encode(array("error" => "notinsert"));
                }
            }
            return array("error" => "none", "duplicate" => $count, "values" => $dup);
        } else {
            return array("error" => "type");
        }
        
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
        $this->acd_year = (int)$this->verifyInput($_POST['acd_year']);
        $this->faculty_id = isset($_POST['faculty_s']) ? (int)$this->verifyInput($_POST['faculty_s']) : $_SESSION['faculty_id'];
        $this->courses_ar = (array)$this->verifyInput($_POST['courses']);
        $this->dept = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $this->div = (array)$this->verifyInput($_POST['div_id']);
        $dup = [];
        foreach($this->courses_ar as $course){
            foreach($this->div as $d){
                $c = $this->getCourseById([$course]);
                $result = $this->checkClassExists([$this->faculty_id, (int)$course, (int)$this->dept, (int)$c["s_class_id"], (int)$c["sem_id"],$d ,$this->acd_year]);
                if(!$result){
                    $result = $this->insertOneClass([$this->faculty_id, (int)$course, (int)$this->dept, (int)$c["s_class_id"], (int)$c["sem_id"],$d ,$this->acd_year]);
                }else{
                    $dup[] = $c['course_name'];
                }
            }
        }
        if(count($dup) > 0) return json_encode(array("error" => "dup", "count" => count($dup)));
        $getclass = $this->getClassByDept([$_SESSION['dept']]);
        return json_encode(array("error" => "none", "data" => $getclass));
    }

    // public function getStudentByClass(){
    //     if($this->checkEmpty()) return json_encode(array("error" => "empty"));
    //     $this->class_id = $this->verifyInput($_POST['data']);
    //     $_SESSION['class_id'] = $this->class_id;
    //     return json_encode($this->selectStudentByDeptAndYearForAttend([$_SESSION['dept'],$this->class_id]));
    // }

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

    public function addPracticalClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->acd_year = $this->verifyInput($_POST['acd_year']);
        $this->faculty_id = $this->verifyInput($_POST['faculty_s']);
        $this->course_id = $this->verifyInput($_POST['courses']);
        $this->div_id = (int)$this->verifyInput($_POST['div']);
        $this->batch_ar = $this->verifyInput($_POST['batches']);
        $this->year = $this->verifyInput($_POST['year']);
        $this->sem = $this->verifyInput($_POST['sem']);
        $this->dept = isset($_POST['dept']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $c = $p = [];
        foreach($this->batch_ar as $batch){
            $result = $this->checkPractClassAlreadyTaken([(int)$this->course_id, (int)$this->div_id ,(int)$this->dept, (int)$this->year, (int)$this->sem, (int)$batch, (int)$this->acd_year]);
            if($result) return json_encode(array("error" => "taken"));
            $result = $this->checkPractClass([(int)$this->faculty_id, (int)$this->course_id, (int)$this->div_id ,(int)$this->dept, (int)$this->year, (int)$this->sem, (int)$batch, (int)$this->acd_year]);
            if($result)
            { 
                $p[] = $batch;
                continue;
            }
            else
            {
                //var_dump((int)$this->course_id);
                $result = $this->insertOnePractClass([(int)$this->faculty_id, (int)$this->course_id, (int)$this->div_id ,(int)$this->dept, (int)$this->year, (int)$this->sem, (int)$batch, (int)$this->acd_year]);
        
                if(!$result) $c[] = $batch;
            }
        }

        if(count($p) > 0) return json_encode(array("error" => "already", "count" => $p));
        if(count($c) > 0) return json_encode(array("error" => "notinsert", "count" => $c));
        $getclass = $this->getPractClassByDept([(int)$this->dept]);
        return json_encode(array("error" => "none", "data" => $getclass));
    }

    public function getClassForStaffAcademic(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->class = $this->verifyInput($_POST['data']);
        $this->dept = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];
        $getclass = $this->getClassByAcademicYear([$this->class, $this->faculty_id]);
        if(!$getclass) return json_encode(array("error" => "notexist"));
        else return json_encode(array("error" => "none", "data" => $getclass));
    }


    public function saveAttendance(){
        if($this->checkEmpty()) return array("error" => "empty");
        $this->class = $this->verifyInput($_POST['class']);
        $this->attend = $this->verifyInput($_POST['attend']);
        $this->year = $this->verifyInput($_POST['academic_year']);
        $this->s_div = $this->verifyInput($_POST['div_id']);
        date_default_timezone_set("Asia/Kolkata");
        $date = $this->verifyInput($_POST['date']);
        $time = $this->verifyInput($_POST['time']);
        $timestamp = date('Y-m-d H:i:s', strtotime("$date $time"));
        $this->attend = $this->verifyInput($_POST['attend']);
        $result = $this->getTheoryAttendance([(int)$this->class,$timestamp]);
        if(count($result) == 0){
            $c = 0;
            foreach((array)$this->attend as $key => $value){
               $this->insertStudentAttendance([(int)$this->class, $key,(int)$value,$timestamp]);
               $c++;
            }
            if($c == sizeof($this->attend)){
                $r = $this->updateNoOfLect([(int)$this->class]);
                if(!$r){
                    return array("error" => "count");
                }
            }
        }else{
            foreach((array)$this->attend as $key => $value){
                $this->updateStudentAttendance([(int)$value, (int)$this->class, $key, $timestamp]);
             }
             return array("error" => "update");
        }
        return array("error" => "none");
    }

    public function viewStaffReport(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));

        $this->acd_year = $this->verifyInput($_POST['academic_year']);
        $this->class = $this->verifyInput($_POST['class']);

        if(strtotime($_POST['from-date']) > strtotime($_POST['till-date'])) return json_encode(array("error" => "date"));

        $fromdate = $this->verifyInput($_POST['from-date']);
        $fromdate = date('Y-m-d', strtotime("$fromdate"));
        $tilldate = $this->verifyInput($_POST['till-date']);
        $tilldate = date('Y-m-d', strtotime("$tilldate")); 
        $this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];

        $result = $this->findClassByAcademicYearAndFaculty([(int)$this->acd_year,(int)$this->faculty_id,(int)$this->class,$fromdate,$tilldate]);

        if(!$result) return json_encode(array("error" => "notexists"));
        $result = $this->getStaffReport([(int)$this->class,$fromdate,$tilldate]);

        $getTotal = $this->getStaffReportTotal([(int)$this->class,$fromdate,$tilldate]);

        $this->dept = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];

        $getDept = $this->getDepartmentById([(int)$this->dept]);
        $year = $this->getClassYearByClass([(int)$this->class]);

        return json_encode(array("error" => "none","data" => $result,"total" => $getTotal, 'dept' => $getDept, 'year' => $year));

    }

  

    public function getHodReport(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->acd_year = $this->verifyInput($_POST['academic_year']);
        $this->class = $this->verifyInput($_POST['class']);
        $this->year = $this->verifyInput($_POST['s_class_year']);
        $this->div_s = $this->verifyInput($_POST['div_id']);
        if(strtotime($_POST['from-date']) > strtotime($_POST['till-date'])) return json_encode(array("error" => "date"));
        $fromdate = $this->verifyInput($_POST['from-date']);
        $fromdate = date('Y-m-d', strtotime("$fromdate"));
        $tilldate = $this->verifyInput($_POST['till-date']);
        $tilldate = date('Y-m-d', strtotime("$tilldate"));
        $this->sem = $this->verifyInput($_POST['sem']); 
        //$this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];
        $result = $this->findClassByAcademicYearAndClassYear([(int)$this->acd_year,(int)$this->year,(int)$this->class,$fromdate,$tilldate]);
        if(!$result) return json_encode(array("error" => "notexists"));
        $result = $this->getStaffReport([(int)$this->class,$fromdate,$tilldate]);
        $getTotal = $this->getStaffReportTotal([(int)$this->class,$fromdate,$tilldate]);
        $faculty = $this->getFacultyofClassById([$this->class]);
        $faculty = $faculty["last_name"]." ".$faculty["first_name"];
        return json_encode(array("error" => "none","data" => $result,"total" => $getTotal, "faculty" => $faculty));
    }

    public function showFacultyByDept(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->dept = $this->verifyInput($_POST['dept_id']);
        $result = $this->getFacultyByDept([$this->dept]);
        if(!$result) return json_encode(array("error" => "notfound"));
        else return json_encode(array("error" => "none", "data" => $result));
    }

    public function showStudentByClassForAttendance(){

        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $s_class_id = $this->verifyInput($_POST['id']);
        $this->class = $this->verifyInput($_POST['class_id']);
        $this->acd_year = $this->verifyInput($_POST['year']);
        $this->s_div = $this->verifyInput($_POST['div']);
        $this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];
        $result = $this->getClassById([$this->faculty_id,$this->class]);
        $this->dept = $result['dept_id'];
        $year = $this->verifyInput($_POST['year']);
        $date = $this->verifyInput($_POST['date']);
        $time = $this->verifyInput($_POST['time']);
        $timestamp = date('Y-m-d H:i:s', strtotime("$date $time"));
        $result = $this->getStudentByDeptDivisionAndYear([(int)$this->dept, (int)$year, (int)$this->s_div]);
        if(!$result) return json_encode(array("error" => "nostudent"));
        $result = $this->getTheoryAttendance([(int)$this->class,$timestamp]);
        if(!$result){
            $getclass = $this->getClassById([$this->faculty_id, $this->class]);
            $result = $this->selectStudentByDeptAndYearForAttend([$getclass['dept_id'],$s_class_id]);
            return json_encode(array("error" => "notfound", "data" => $result));
        } 
        else return json_encode(array("error" => "none", "data" => $result));
    }

    public function showYearBelongsDept(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->dept = $this->verifyInput($_POST['id']);
        $result = $this->getYearBelongsDept([$this->dept]);
        if(!$result) return json_encode(array("error" => "notfound"));
        else return json_encode(array("error" => "none", "data" => $result));
    }

    public function showClassByDiv(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        
        if(isset($_POST['div'])) $this->s_div = $this->verifyInput($_POST['div']);
        else if(isset($_POST['id'])) $this->s_div = (int)$this->verifyInput($_POST['id']);
        else $this->s_div = 1;

        
        $this->acd_year = (int)$this->verifyInput($_POST['acd']);
        //$this->sem = (int)$this->verifyInput($_POST['sem']);

        if(isset($_POST['year'])) $this->year = (int)$this->verifyInput($_POST['year']);

        $this->faculty_id = (isset($_POST['faculty_id'])) ? (int)$this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];
        $this->dept = isset($_POST['dept_id']) ? (int)$this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];


        if(isset($_POST['for'])){
            $result =  $this->getClassByAcademicAndFaculty([$this->acd_year, $this->faculty_id]);
            if($result) return json_encode(array("error" => "none", "data" => $result));
            else return json_encode(array("error" => "notfound"));
        }

        $this->sem = $this->verifyInput($_POST['sem']);
        //if($_SESSION['role_id'] == 0) $result = $this->getAllClassByDeptAndYear([$this->$this->acd_year , $this->year, $this->s_div, $this->dept])
        if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 0) $result = $this->getClassByYearDivisionAcademicAndDept([$this->acd_year , $this->year, $this->s_div, $this->sem, $this->dept]);
        else $result = $this->getClassByYearDivisionAcademicAndFaculty([$this->acd_year , $this->year, $this->s_div, $this->sem, $this->faculty_id]);
        if(!$result) return json_encode(array("error" => "notfound"));
        else return json_encode(array("error" => "none", "data" => $result)); 
    }

    public function showDivBelongsDept(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->dept = isset($_POST['dept_id']) ? (int)$this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $result = $this->getDivBelongsDept([$this->dept]);
        if(!$result) return json_encode(array("error" => "notfound"));
        else return json_encode(array("error" => "none", "data" => $result)); 
    }

    public function showAdminReport(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->acd_year = $this->verifyInput($_POST['academic_year']);
        $this->class = $this->verifyInput($_POST['class']);
        $this->year = $this->verifyInput($_POST['year']);
        $this->div_s = $this->verifyInput($_POST['div']);
        if(strtotime($_POST['from-date']) > strtotime($_POST['till-date'])) return json_encode(array("error" => "date"));
        $fromdate = $this->verifyInput($_POST['from-date']);
        $fromdate = date('Y-m-d', strtotime("$fromdate"));
        $tilldate = $this->verifyInput($_POST['till-date']);
        $tilldate = date('Y-m-d', strtotime("$tilldate")); 
        $this->dept = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        //$this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];
        $result = $this->findClassByAcademicYearAndClassYear([(int)$this->acd_year,(int)$this->year,(int)$this->class,$fromdate,$tilldate]);
        if(!$result) return json_encode(array("error" => "notexists"));
        $result = $this->getStaffReport([(int)$this->class,$fromdate,$tilldate]);
        $getTotal = $this->getStaffReportTotal([(int)$this->class,$fromdate,$tilldate]);
        $faculty = $this->getFacultyofClassById([$this->class]);
        $faculty = $faculty["last_name"]." ".$faculty["first_name"];
        return json_encode(array("error" => "none","data" => $result,"total" => $getTotal, "faculty" => $faculty));
    }

    public function showAttendTakenClass(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->class = $this->verifyInput($_POST['class_id']);
        $this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];
        $result = $this->getAttendanceDateByClassAndFaculty([$this->class, $this->faculty_id]);
        if(!$result) return json_encode(array("error" => "notfound"));
        else{
            $count = $this->getTotalLecturesConducted([$this->class]);
            return json_encode(array("error" => "none", "data" => $result, "count" => $count));
        } 
    }


    public function removeAttendance(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->class = $this->verifyInput($_POST['class']);
        $this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($this->verifyInput($_POST['faculty_id'])) : $_SESSION['faculty'];
        $this->date_time = $this->verifyInput($_POST['date_time']);
        $result = $this->deleteAttendance([$this->class, $this->faculty_id, $this->date_time]);
    }


    /* Show Dynamic Attendance Report to HOD */

    public function showHodReport(){
        $data = [];
        $query = "";
        $from = $till = 0;
    
        if(!empty($_POST['academic_year'])){
            $query .= " academic_id = ? ";
            $this->acd_year = $this->verifyInput($_POST['academic_year']);
            $data[] = $this->acd_year;
        }
        if(!empty($_POST['s_class_year'])){
            $query .= " AND courses.s_class_id = ? ";
            $this->year = $this->verifyInput($_POST['s_class_year']);
            $data[] = $this->year;
        }
        if(!empty($_POST['div_id'])){
            $query .= " AND class.div_id = ? ";
            $this->s_div = $this->verifyInput($_POST['div_id']);
            $data[] = $this->s_div;
        }
        if(!empty($_POST['sem_id']) || !empty($_POST['sem'])){
            $query .= " AND courses.sem_id = ?";
            $this->sem = isset($_POST['sem_id']) ? $this->verifyInput($_POST['sem_id']) : $this->verifyInput($_POST['sem']);
            $data[] = $this->sem;
        }
        if(!empty($_POST['class'])){
            $query .= " AND class.class_id = ? ";
            $this->class = $this->verifyInput($_POST['class']);
            $data[] = $this->class;
        }
        if(isset($_POST['dept_id']) && !empty($_POST['dept_id'])){
            $query .= " AND courses.dept_id = ? ";
            $this->dept = $this->verifyInput($_POST['dept_id']);
            $data[] = $this->dept;
        }else{
            $query .= " AND courses.dept_id = ? ";
            $this->dept = $this->verifyInput($_SESSION['dept']);
            $data[] = $this->dept;
        }
       
        $result = $this->getStudentByDeptDivisionAndYear([$this->dept, $this->year, $this->s_div]);
        if(!$result) return json_encode(array("error" => "nostudent"));

        if(!empty($_POST['from-date']) && !empty($_POST['till-date'])){
            $query .= " AND DATE(date_time) >= DATE(?) AND DATE(date_time) <= DATE(?) ";
            $this->from_date = $this->verifyInput($_POST['from-date']);
            $this->till_date = $this->verifyInput($_POST['till-date']);
            $data[] = date('Y-m-d', strtotime($this->from_date));
            $data[] = date('Y-m-d', strtotime($this->till_date));
            
            $result = $this->getAttendanceByDate("date_time >= DATE(?) AND date_time <= DATE(?)",[$this->dept, $this->year, $this->s_div, date('Y-m-d', strtotime($this->from_date)) , date('Y-m-d', strtotime($this->till_date))]);
            
            if(!$result) return (array("error" => "noattend"));
        }
        else if(!empty($_POST['from-date'])){
            $query .= " AND DATE(date_time) >= DATE(?) ";
            $this->from_date = $this->verifyInput($_POST['from-date']);
            $data[] = date('Y-m-d', strtotime($this->from_date));
            $from_data = $this->getAttendanceByDate("DATE(date_time) >= DATE(?)",[$this->dept, $this->year, $this->s_div, date('Y-m-d', strtotime($this->from_date))]);
            if(!$from_data) return (array("error" => "noattend"));
        }
        else if(!empty($_POST['till-date'])){
            $query .= " AND DATE(date_time) <= DATE(?) ";
            $this->till_date = $this->verifyInput($_POST['till-date']);
            $data[] = date('Y-m-d', strtotime($this->till_date));
            
            $till_data = $this->getAttendanceByDate("date_time <= DATE(?)",[$this->dept, $this->year, $this->s_div, $this->sem_id, date('Y-m-d', strtotime($this->till_date))]);
            if(!$till_data) return (array("error" => "noattend"));
        }
    
        $result = $this->getClassByYearDivisionAcademicAndDept([$_POST['academic_year'],$_POST['s_class_year'],$_POST['div_id'],$this->dept]);
        if(!$result) json_encode(array("error" => "noclass"));
        else {
            //var_dump($_POST);
            //var_dump($query);
           
            $result = $this->getHodReportYearWise($query,$data);
            
            // if(empty($_POST['class_id'])){
            //     $result = $this->getHodReportYearWise($query,$data);
            // }else{

            // } 
            return json_encode(array("error" => "none", "data" => $result["each_total"], "total" => $result['total'], "lectures" =>$result['total_lectures']));
            // if($from == 1 && $till == 1){
            //     $query .= " AND date_time >= DATE(?) AND date_time <= DATE(?) ";
            //     $getTotal = $this->getReportTotalClassWise([(int)$this->class,$_POST['form-date'],$_POST['till-date']]);
            // }else if($from == 1 && $till == 0){
            //     $query .= " AND date_time >= DATE(?) ";
            //     $getTotal = $this->getReportTotalClassWise([(int)$this->class,$_POST['form-date'], '9999-12-31']);
            // }else if($from = 0 && $till == 1){
            //     $query .= " AND date_time <= DATE(?) ";
            //     $getTotal = $this->getReportTotalClassWise([(int)$this->class,'0000-00-00',$_POST['till-date']]);
            // }else{
            //     $getTotal = $this->getReportTotalClassWise([(int)$this->class]);
            // }
            
            //return json_encode(array("error" => "none","data" => $result,"total" => $getTotal));
        }
    }

    public function showClassSemWise(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->acd_year = $this->verifyInput($_POST['academic_year']);
        $this->year = $this->verifyInput($_POST['s_class_year']);
        $this->s_div = $this->verifyInput($_POST['div_id']);
        $this->sem = $this->verifyInput($_POST['sem_id']);
        $result = $this->getClassSemWise([$this->acd_year, $this->year, $this->s_div, $this->sem]);
        if(!$result) return json_encode(array("error" => "notfound"));
        return json_encode(array("error" => "none", "data" => $result));
    }


    public function showCoursesBySem(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->year = $this->verifyInput($_POST['year']);
        $this->sem = $this->verifyInput($_POST['sem']);
        $this->dept = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $result = $this->getCoursesByYearSem([$this->year, $this->sem, $this->dept]);
        if(!$result) return json_encode(array("error" => "notfound"));
        return json_encode(array("error" => "none", "data" => $result));
    }

    public function showPractAttendance(){
 
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $date = $this->verifyInput($_POST['date']);
        $time = $this->verifyInput($_POST['time']);
        $this->class = $this->verifyInput($_POST['class_id']);
        $timestamp = date('Y-m-d H:i:s', strtotime("$date $time"));
        $result = $this->getFullPracticalAttendanceByClassDateAndTime([$this->class, $timestamp]);
        if($result){
            $getAttend = $this->getPracticalAttendance([$this->class, $timestamp]);
            return json_encode(array("error" => "none" , "data" => $getAttend));
        }else{
            return json_encode(array("error" => "notfound"));
        }
    }

    public function savePracticalAttendance(){
        if($this->checkEmpty()) return array("error" => "empty");
        $this->class = $this->verifyInput($_POST['class']);
        date_default_timezone_set("Asia/Kolkata");
        $date = $this->verifyInput($_POST['date']);
        $time = $this->verifyInput($_POST['time']);
        $timestamp = date('Y-m-d H:i:s', strtotime("$date $time"));
        $this->attend = $this->verifyInput($_POST['attend']);
        $result = $this->getPracticalAttendance([(int)$this->class,$timestamp]);
        if(count($result) == 0){
            $c = 0;
            foreach((array)$this->attend as $key => $value){
               
                $result = $this->insertStudentPracticalAttendance([(int)$this->class, $key,(int)$value,$timestamp]);
                //var_dump($result);
               $c++;
            }
        }else{
            foreach((array)$this->attend as $key => $value){
                $result = $this->updateStudentPracticalAttendance([(int)$value,(int)$this->class, $key, $timestamp]);
             }
             return json_encode(array("error" => "update"));
        }
        return json_encode(array("error" => "none"));
    }


    public function showPractClassBySemester(){
        if($this->checkEmpty()) return json_encode(array("error" => "empty"));
        $this->acd = $this->verifyInput($_POST['acd']);
        $this->year = $this->verifyInput($_POST['year']);
        $this->sem = $this->verifyInput($_POST['sem']);
        $this->dept = isset($_POST['dept_id']) ? $this->verifyInput($_POST['dept_id']) : $_SESSION['dept'];
        $this->faculty_id = isset($_POST['faculty_id']) ? $this->verifyInput($_POST['faculty_id']) : $_SESSION['faculty_id'];

        $result = $this->getClassBySemesterYearAndAcademic([$this->acd, $this->year, $this->sem, $this->dept, $this->faculty_id]);
        if(!$result) return json_encode(array("error" => "notfound"));
        else return json_encode(array("error" => "none", "data" => $result));
    
    }

    public function showPracticalReport(){
        var_dump($_POST);
        $query = " ";
        $data = [];
        if(!empty($_POST['"academic_year'])){
            $this->acd = $this->verifyInput($_POST['"academic_year']);
            $query += "y.academic_id = ?";
            $data[] = $this->acd;
        }
        if(!empty($_POST['year'])){
            $this->year = $this->verifyInput($_POST['year']);
            $query += "AND a.year_id = ?";
            $data[] = $this->year;
        }
        if(!empty($_POST['sem'])){
            $this->sem = $this->verifyInput($_POST['sem']);
            $query = "AND a.sem_id = ?";
            $data[] = $this->sem;
        }
        if(!empty($_POST['class'])){
            $this->sem = $this->verifyInput($_POST['class']);
            $query = "AND a.p_class_id = ?";
            $data[] = $this->sem;
        }
        if(!empty($_POST['from-date']) && !empty($_POST['till-date'])){
            $this->from_date = date('Y-m-d', strtotime($this->verifyInput($_POST['from-date'])));
            $this->till_date = date('Y-m-d', strtotime($this->verifyInput($_POST['till-date'])));
            $query = "AND DATE(date_time) >= ? AND DATE(date_time) <= ?";
            $data[] = $this->from_date;
            $data[] = $this->till_date;
        }
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