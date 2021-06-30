<?php
namespace app\model;
use \PDOException;
use app\database\Database;
use PDO;

class Faculty extends Database {
	/**
	* 	This function will get academic Year from database.
	*	@param  
	*	@return array[].
	*/
	public function getAcademicYear(){
		try {
			$con = $this->connect();
			$sql = "SELECT * FROM academic_year";
			$stmt = $con->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();	
		}  
		catch (PDOException $e) {
			return array("e" => $e->getMessage());
		}
	}

	public function getLastAcademicYear(){
		try {
			$con = $this->connect();
			$sql = "SELECT * FROM academic_year ORDER BY acedemic_id DESC LIMIT 1";
			$stmt = $con->prepare($sql);
			$stmt->execute();
			return $stmt->fetch();	
		}  
		catch (PDOException $e) {
			return array("e" => $e->getMessage());
		}
	}

	/** 
	*	Function will return a particular academic year using id.
	*	@param $acad_year_id
	*	@return array[].
	**/
	public function getAcademicYearById($acd_year_id){
		try{
			$sql = "SELECT * FROM academic_year WHERE acedemic_id = ?";
			$stmt = $this->dbconn->prepare($sql);
			$stmt->execute($acd_year_id);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			return array("e" => $e->getMessage());
		}
	}

	public function insertAcademicYear($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO academic_year(academic_descr) VALUES (?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}	
		catch (PDOException $e) {
			return array("e" => $e->getMessage());
		}
	}

	public function deleteAcademicYear($id){
		try{
			$sql = "DELETE FROM academic_year WHERE acedemic_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			if($stmt->execute($id)) return true;
		} catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	/*#################################################################################################
	#	Function will run query to select faculty member if his faculty_id matches.   
	#	Include query for HOD, Staff member.
	#	@params usernme = faculty_id for staff.													
	#	@returns Associative array contanining single row.
	###################################################################################################*/
	public function getFacultyByIdLogin($id){
		try{
			$sql = "SELECT * FROM faculty WHERE faculty_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($id);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getFacultyById($id){
		try{
			$sql = "SELECT * FROM faculty as a INNER JOIN department as b WHERE a.dept_id = b.dept_id AND a.faculty_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($id);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getFacultyByRole($role){
		try{
			$sql = "SELECT * FROM faculty as a INNER JOIN department as b WHERE a.dept_id = b.dept_id AND role_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($role);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getFacultyByDept($data){
		try{
			$sql = "SELECT * FROM faculty as a INNER JOIN department as b WHERE a.dept_id = b.dept_id AND a.dept_id = ? AND role_id = 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*################################################################################################### 
	#	This will run query to select all the faculty member in database include HOD, staff and admin.
	#	@params no_parameters;
	#	@returns Arrays of Associative Array containing multiple rows;		
	#####################################################################################################*/
	public function getAllFaculty(){
		try{
			$sql = "SELECT * FROM faculty as a INNER JOIN department as b WHERE a.dept_id = b.dept_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
		
	}

	

	/*
	#	This function will run query to select only the Hod from faculty.
	#	In database role_id of Hod is set to 1.
	#	@params no_parameters;
	#	@return Arrays of Associative Array containing multiple rows;
	*/

	public function insertOneHod($data){
		try{
			$sql = "INSERT INTO faculty(faculty_id, first_name, last_name, dept_id, role_id, password) VALUES (?,?,?,?,?,?);";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	This function will add a single faculty into database.
	#	@params faculty_id, first_name, last_name, dept(department), role(0 => Admin, 1 => HOD, 2 => Staff).
	#	@return array containing two values array[0] = true or false, array[1] = if true null else if catch exception then error message.
	*/
	public function insertOneFaculty($data){
		try{
			$sql = "INSERT INTO faculty(faculty_id, first_name, last_name, dept_id, role_id, password) VALUES (?,?,?,?,?,?);";
			$stmt = $this->connect()->prepare($sql);
			if($stmt->execute($data)) return true;
		}catch (PDOException $e){
			return array(false, $e->getMessage());
		}
	}


	/*######################################################################################################################################
	#	Function to insert Faculty data in bulk.
	#	This function will take filepath as arrgument
	#	@params $filepath
	#	@return array containing two values array[0] = true or false, array[1] = if true null else if catch exception then error message.
	########################################################################################################################################*/
	public function insertMultipleFaculty($file) {

	}


	public function updateOneFaculty($data){
		try{
			$con = $this->connect();
			$sql = "UPDATE faculty SET first_name = ?, last_name = ?, dept_id = ? WHERE faculty_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}catch (PDOException $e){
			return array(false, $e->getMessage());
		}
	}

	/*#######################################################################################################################################
	#	This function will update faculty using there faculty_id. Update the values based of which field is to update. 
	#	Generally used to update only the field whose values is to be update rather than updating whole table.
	#	@params $faculty_id
	#	@params $data := Containst the associative array like the columns to update and its associated value.
	#	@return array containing two values array[0] = true or false, array[1] = if true null else if catch exception then error message.
 	########################################################################################################################################*/
	public function updateFacultyById($faculty_id, $data){
		
		$setPart = array();
        $bindings = array();

        foreach ($data as $key => $value)
        {
            $setPart[] = "{$key} = :{$key}";
            $bindings[":{$key}"] = $value;
    	}
        $bindings[":faculty_id"] = $faculty_id;
		try{
			$sql = "UPDATE faculty SET".implode(',',$setPart)." WHERE faculty_id = :faculty_id;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($bindings);
			if($stmt->rowCount)
				return array(true, null);
		}catch (PDOException $e){
			return array(false, $e->getMessage());
		}
	}


	/*
	# 	This function will delete the faculty using faculty_id.
	#	@params $faculty_id.
	*/

	public function deleteFacultyById($faculty_id){
		try{
			$sql = "DELETE FROM faculty WHERE faculty_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			if($stmt->execute($faculty_id)) return true;
		} catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}
	/*
	#	This function to get all the students form student table
	#	@params no parameter
	#	@return array of associative array containing all student details.
	*/
	public function getAllStudent(){
		try {
			$sql = "SELECT a.*, b.dept_name,c.s_class_name,d.div_name,e.batch_name FROM student as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id ORDER BY a.prn_no;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
		
	}


	/*
	#	This function will get a single student form student table using its prn_no.
	#	@params prn_no
	#	@return associative array containing details of a student.
	*/
	public function getStudentById($prn_no) {
		try{
			$sql = "SELECT a.*, b.dept_name,c.s_class_name,d.div_name,e.batch_name FROM student as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id WHERE a.prn_no  = CAST(? AS UNSIGNED INTEGER)";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($prn_no);
			return $stmt->fetch();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStudentByDept($data) {
		try{
			$sql = "SELECT a.*, b.dept_name,c.s_class_name,d.div_name,e.batch_name FROM student as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id WHERE a.dept_id = ? ORDER BY CAST(a.roll_no AS INTEGER)";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	/*
	#	This function insert a single student into database 
	#	@params $data := This contain the array of student details
	#	@return bool true on succed. false on error. 
	*/
	public function insertOneStudent($data){
		try{
			$sql = "INSERT INTO student(prn_no,first_name,middle_name, last_name, roll_no, dept_id, year_id, batch_id, div_id) VALUES(?,?,?,?,?,?,?,?,?)";
			$stmt = $this->connect()->prepare($sql);
			if($stmt->execute($data)) return true;
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	This function will insert mutiple values of student.
	#	@params $filepath 
	*/
	public function insertMultipleStudent($filepath){

	}

	/*
	#	This function will update a single student details using prn_no in the database.
	#	@params $prn_no
	#	@params $data := Contains associative array $key is the table_columns name in database for which value is to be updated and $value is the new value
	#	to update.
	#	@return bool true/exception false. 
	*/
	public function updateStudnetById($prn_no,$data){
		$setPart = array();
        $bindings = array();

        foreach ($data as $key => $value)
        {
            $setPart[] = "{$key} = :{$key}";
            $bindings[":{$key}"] = $value;
    	}
        $bindings[":prn_no"] = $prn_no;
        try{
			$sql = "UPDATE student SET".implode(',',$setPart)." WHERE prn_no = :prn_no;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($bindings);
			if($stmt->rowCount)
				return array(true, null);
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function updateOneStudent($data){
		try{
			$con = $this->connect();
			$sql = "UPDATE student SET first_name = ?, middle_name = ?, last_name = ?, roll_no = ?, dept_id = ?, year_id = ?, batch_id = ?, div_id = ? WHERE prn_no = CAST(? AS UNSIGNED INTEGER);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	This function will delete the student based on $prn_no.
	#	@params $prn_no
	#	@return bool true/exception false;
	*/
	public function deleteStudentById($prn_no){
		try{
			$con = $this->connect();
			$sql = "SET FOREIGN_KEY_CHECKS = 0;";
			$stmt = $con->prepare($sql);
			$stmt->execute();
			$sql = "DELETE FROM student WHERE prn_no = CAST(? AS UNSIGNED INTEGER); SET FOREIGN_KEY_CHECKS = 1;";
			$stmt = $con->prepare($sql);
			$result = $stmt->execute($prn_no);
			return $result;
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	This function will get all the roles of users in the table.
	#	@params 
	#	@return associative array of roles of user.
	*/
	public function getRole(){
		try{
			$sql = "SELECT * FROM roles";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	This function will get all the department in the table
	#	@params 
	#	@return array of department details.
	*/
	public function getDepartment(){
		try {
			$sql = "SELECT * FROM department";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch(PDOException $e){
			return array("e"=> $e->getMessage());
		}
	}

	public function getDepartmentById($id){
		try{
			$con = $this->connect();
			$sql = "SELECT dept_id, dept_name FROM department WHERE dept_id = ?";
			$stmt = $con->prepare($sql);
			$stmt->execute($id);
			return $stmt->fetchAll();	
		}
		catch(PDOException $e){
			return array("e"=> $e->getMessage());
		}
	}

	/*
	#	This function will insert the department into database
	#	@params $data:= Array containing all the details of department.
	#	@returns 
	*/
	public function insertDepartment($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO department(dept_name) VALUES(?);";
			$stmt = $con->prepare($sql);
			$stmt->execute($data);
			$lastid = $con->lastInsertId();
			return $lastid;
		}
		catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	public function insertYearBelongsDept($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO year_belongs_dept(dept_id, year_id) VALUES(?,?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getYearBelongsDept($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*,dept_name,s_class_name FROM year_belongs_dept as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id WHERE a.dept_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function insertDivBelongsDept($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO div_belongs_dept(dept_id, div_id) VALUES(?,?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/** 
	*	Function will update the Department in the table
	*	@param string $dept_id  ID of the department to be change.
	*	@param array $data:= Array containg key value pair. $key = name of columns to set and $value = New value of columns.
	*	@return 
	*/

	public function updateDepartmentById($data){
		try{
			$con = $this->connect();
			$sql = "UPDATE department SET dept_name = ? WHERE dept_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
			else return false;
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/**
	*	Function will delete the specific department in the table.
	*	@param string $dept_id:= ID of the department to be change.
	*	@return bool
	*/

	public function deleteDepartment($dept_id){
		try {
			$con = $this->connect();
			$sql = "DELETE FROM department WHERE dept_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($dept_id)) return true;
		}
		catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	Function will get the Class Year i.e. First Year, Second Yar and so on.
	#	@params 
	#	@return array;
	*/

	public function getClassYear(){
		try {
			$sql = "SELECT * FROM student_class";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	/*
	#	Function will get all the semester.
	#	@params 
	#	@return array().
	*/
	public function getAllSemester(){
		try {
			$sql = "SELECT * FROM semester;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetch();
		}
		catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	Function will get semester by year wise i.e for first year => [sem 1, sem 2], second year => [sem 3, sem 4] and so on.
	#	@params $year_id
	#	@return array of semester for that particular year.
	*/
	public function getSemesterByYearId($year_id){
		try {
			$sql = "SELECT a.sem_id, a.sem_name FROM semester as a INNER JOIN student_class as b WHERE a.s_class_id = b.s_class_id AND a.s_class_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($year_id);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			return array("e" => $e->getMessage());
		}
	}

	/*
	#	Function to get all division.
	#	@params 
	#	@return array().
	*/
	public function getAllDivision(){
		try {
			$sql = "SELECT * FROM division;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getDivBelongsDept($data){
		try {
			$con = $this->connect();
			$sql = "SELECT a.*,b.dept_name,c.div_name FROM div_belongs_dept as a JOIN department as b ON a.dept_id = b.dept_id JOIN division as c ON a.div_id = c.div_id WHERE a.dept_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function searchDivision($data){
		try{
			$con = $this->connect();
			$sql = "SELECT div_id FROM division WHERE div_name LIKE ?";
			$stmt = $con->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getBatch(){
		try{
			$sql = "SELECT * FROM batch;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function searchBatch($data){
		try{
			$con = $this->connect();
			$sql = "SELECT batch_id FROM batch WHERE batch_name LIKE ?";
			$stmt = $con->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	

	public function getCourses(){
		try{
			$sql = "SELECT a.*, b.dept_name, c.s_class_name, d.sem_name FROM courses AS a INNER JOIN department AS b ON a.dept_id = b.dept_id JOIN student_class AS c ON a.s_class_id = c.s_class_id JOIN semester as d ON a.sem_id = d.sem_id ORDER BY b.dept_id,c.s_class_id,d.sem_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getCourseById($id){
		try{
			$sql = "SELECT a.*, b.dept_name, c.s_class_name, d.sem_name FROM courses AS a INNER JOIN department AS b ON a.dept_id = b.dept_id JOIN student_class AS c ON a.s_class_id = c.s_class_id JOIN semester as d ON a.sem_id = d.sem_id WHERE course_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($id);
			return $stmt->fetch();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getCoursesByYearSem($data){
		try{
			$sql = "SELECT a.*, b.dept_name, c.s_class_name, d.sem_name FROM courses AS a INNER JOIN department AS b ON a.dept_id = b.dept_id JOIN student_class AS c ON a.s_class_id = c.s_class_id JOIN semester as d ON a.sem_id = d.sem_id WHERE a.s_class_id = ? AND a.sem_id = ? AND a.dept_id = ?";
			$stmt = $this->connect()->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getCoursesByDept($data){
		try{
			$sql = "SELECT a.*, b.dept_name, c.s_class_name, d.sem_name FROM courses AS a INNER JOIN department AS b ON a.dept_id = b.dept_id JOIN student_class AS c ON a.s_class_id = c.s_class_id JOIN semester as d ON a.sem_id = d.sem_id WHERE a.dept_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function insertCourse($data){
		try{
			$con = $this->connect(); 
			$sql = "INSERT INTO courses(course_id, course_name, dept_id, s_class_id, sem_id) VALUES(?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function insertOneClass($data){
		try{
			$con = $this->connect();
			$sql = "SELECT course_id FROM courses WHERE course_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute([$data[1]])){
				$sql = "INSERT INTO class(faculty_id, course_id, dept_id, s_class_id, sem_id, div_id, academic_id) VALUES(?,?,?,?,?,?,?);";
				$stmt = $con->prepare($sql);
				return $stmt->execute($data);
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getAllClass(){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id";
			$stmt = $con->prepare($sql);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					return $stmt->fetch();
				}else{
					return false;
				}
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByAcademicAndFaculty($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id WHERE a.academic_id = ? AND a.faculty_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)){
				if($stmt->rowCount() > 0){
					return $stmt->fetchAll();
				}else{
					return false;
				}
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function checkClassExists($data){
		try{
			$con = $this->connect();
			$sql = "SELECT * FROM class WHERE faculty_id = ? AND course_id = ? AND dept_id = ? AND s_class_id = ? AND sem_id = ? AND div_id = ? AND academic_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassById($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id WHERE a.faculty_id = ? AND a.class_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)){
				if($stmt->rowCount() > 0){
					return $stmt->fetch();
				}else{
					return false;
				}
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getFacultyofClassById($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id WHERE a.class_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)){
				if($stmt->rowCount() > 0){
					return $stmt->fetch();
				}else{
					return false;
				}
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function classExists($data){
		try{
			$con = $this->connect();
			$sql = "SELECT faculty_id, course_id FROM class WHERE faculty_id = ? AND course_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
			return false;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByDept($data){
		try{
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id WHERE a.dept_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByYearDivisionAcademicAndFaculty($data){
		try{
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id WHERE a.academic_id = ? AND a.s_class_id = ? AND a.div_id = ? AND a.sem_id = ? AND a.faculty_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByYearDivisionAcademicAndDept($data){
		try{
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id WHERE a.academic_id = ? AND a.s_class_id = ? AND a.div_id = ? AND a.sem_id = ? AND a.dept_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByAcademicYear($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id WHERE a.academic_id = ? AND a.faculty_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)){
				if($stmt->rowCount() > 0){
					return $stmt->fetchAll();
				}else{
					return false;
				}
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	public function deleteClassById($data){
		try{

			$sql = "SET FOREIGN_KEY_CHECKS=0; DELETE FROM class WHERE class_id = ?;SET FOREIGN_KEY_CHECKS=1;";
			$stmt = $this->connect()->prepare($sql);
			return $stmt->execute($data);
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassYearByCourse($data){

	}

	
	

	public function updateCourse($data){
		try{
			$con = $this->connect();
			$sql = "UPDATE courses SET course_id = ?, course_name = ?, dept_id = ?, s_class_id = ?, sem_id = ? WHERE course_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function deleteCourseById($data){
		try{
			$con = $this->connect();
			$sql = "SET FOREIGN_KEY_CHECKS=0; DELETE FROM courses WHERE course_id = ?; SET FOREIGN_KEY_CHECKS=1";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	

	public function getClassByStaff($data){
		try{
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id WHERE a.faculty_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function selectStudentByDeptAndYearForAttend($data){
		try{
			$sql = "SELECT prn_no, roll_no,first_name, middle_name, last_name FROM student WHERE dept_id = ? AND year_id = ? ORDER BY roll_no+0 ASC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStudentByRollno($data){
		try{
			$con = $this->connect();
			$sql = "SELECT roll_no FROM student WHERE roll_no = ? AND year_id = ? AND dept_id = ? AND div_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();

		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function checkStudentPresentInAttendance($data){
		try{
			$con = $this->connect();
			$sql = "SELECT student_id FROM attendance WHERE class_id = ? AND student_id = ? AND date_time = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetch();
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStudentByDeptDivisionAndYear($data){
		try{
			$sql = "SELECT prn_no, roll_no,first_name, middle_name, last_name FROM student WHERE dept_id = ? AND year_id = ? AND div_id = ? ORDER BY roll_no+0 ASC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getTheoryAttendance($data){
		try{
			$con = $this->connect();
			$sql = "SELECT * FROM attendance as a JOIN student as b ON a.student_id = b.prn_no WHERE a.class_id = ? AND a.date_time = ?  ORDER BY b.roll_no+0;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)){
				return $stmt->fetchAll();
			}	
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function insertStudentAttendance($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO attendance(class_id,student_id, status, date_time) VALUES(?,?,?,?)";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
				
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function updateStudentAttendance($data){
        try{
			$con = $this->connect();
			$sql = "UPDATE attendance SET status = ? WHERE class_id = ? AND student_id = ? AND date_time = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
				
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
    }

	public function updateNoOfLect($data){
		try{
			$con = $this->connect();
			$sql = "UPDATE class SET no_of_lect = no_of_lect + 1 WHERE class_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getCountAttendanceByClassAndRoll($data){
		try{
			$sql = "SELECT";
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	// public function selectStudentByDeptAndClass($data){
	// 	try{
	// 		$sql = "SELECT a.roll_no FROM student as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id";
	// 		$stmt = $this->connect()->prepare($sql);
	// 		$stmt->execute($data);
	// 		return $stmt->fetchAll();
	// 	}
	// 	catch (PDOException $e){
	// 		return array("e" => $e->getMessage());
	// 	}
	// }


	public function insertOnePractClass($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO practical_class(faculty_id, course_id, div_id, dept_id, year_id, sem_id, batch_id, academic_id) VALUES(?,?,?,?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function checkPractClassAlreadyTaken($data){
		try{
			$con = $this->connect();
			$sql = "SELECT p_class_id FROM practical_class WHERE course_id = ? AND div_id = ? AND dept_id = ? AND year_id = ? AND sem_id = ? AND batch_id = ? AND academic_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function checkPractClass($data){
		try{
			$con = $this->connect();
			$sql = "SELECT * FROM practical_class WHERE faculty_id = ? AND course_id = ? AND  div_id = ? AND dept_id = ? AND year_id = ? AND sem_id = ? AND batch_id = ? AND academic_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getPractClassByDept($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.faculty_id, a.dept_id, a.year_id, a.sem_id, d.div_name , group_concat(a.p_class_id) as p_class_ids, group_concat(a.batch_id) as batch_ids, c.course_name, CONCAT(b.first_name, ' ', b.last_name) as faculty_name, g.s_class_name, group_concat(DISTINCT h.batch_name) as batch_name  FROM practical_class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON c.course_id = a.course_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id JOIN academic_year as f ON a.academic_id = f.acedemic_id JOIN student_class as g ON c.s_class_id = g.s_class_id JOIN batch as h ON a.batch_id = h.batch_id WHERE a.dept_id = ? GROUP BY a.faculty_id,a.course_id";			
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStaffReport($data){
		try{
			$con = $this->connect();
			$con->query("SET @sql = NULL");
            $stmt = $con->prepare("SELECT GROUP_CONCAT(DISTINCT CONCAT( 'MAX(IF(a.date_time = ''', date_time, ''', a.status, NULL)) AS ', CONCAT('`',date_time,'`'))) INTO @sql FROM attendance WHERE class_id = ? AND DATE(date_time) BETWEEN (?) AND (?);");
            $stmt->execute($data);
            $stmt = $con->prepare("SET @sql = CONCAT('SELECT  b.roll_no, CONCAT(b.last_name,'' '', b.first_name,'' '', b.middle_name) as student_name, a.student_id, ', @sql ,' FROM attendance as a JOIN student as b ON a.student_id = b.prn_no JOIN class as c ON a.class_id = c.class_id GROUP BY a.student_id ORDER BY b.roll_no+0')");
            $stmt->execute();
            $stmt = $con->prepare("PREPARE stmt FROM @sql");
            $stmt->execute();
            $stmt = $con->prepare("EXECUTE stmt");
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            $con->query("DEALLOCATE PREPARE stmt");
			return $result;
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStaffReportTotal($data){
		try{
			$con = $this->connect();
			$sql = "SELECT b.prn_no, sum(a.status) AS total, CONCAT(ROUND(SUM(a.status)/COUNT(a.status)*100,2),'%') AS percent FROM attendance as a JOIN student as b ON a.student_id = b.prn_no WHERE a.class_id = ? AND DATE(date_time) BETWEEN (?) AND (?) GROUP BY a.student_id ORDER BY b.roll_no+0;";
			$stmt = $con->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	public function findClassByAcademicYearAndFaculty($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.class_id FROM attendance as a JOIN class as b ON a.class_id = b.class_id WHERE b.academic_id = ? AND b.faculty_id = ? AND a.class_id = ? AND DATE(a.date_time) BETWEEN(?) AND (?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByAcademicAndClassYear($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id WHERE a.academic_id = ? AND a.s_class_id = ? AND a.dept_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)){
				if($stmt->rowCount() > 0){
					return $stmt->fetchAll();
				}else{
					return false;
				}
			}
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function findClassByAcademicYearAndClassYear($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.class_id FROM attendance as a JOIN class as b ON a.class_id = b.class_id WHERE b.academic_id = ? AND b.s_class_id = ? AND a.class_id = ? AND DATE(a.date_time) BETWEEN(?) AND (?);";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassYearByClass($data){
		try{
			$con = $this->connect();
			$sql = "SELECT b.s_class_name FROM class as a JOIN student_class as b ON a.s_class_id = b.s_class_id WHERE a.class_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getAttendanceDateByClassAndFaculty($data){
		try{
			$con = $this->connect();
			$sql = "SELECT DISTINCT a.date_time,a.class_id FROM attendance as a JOIN class as b ON a.class_id = b.class_id WHERE a.class_id = ? AND b.faculty_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getTotalLecturesConducted($data){
		try{
			$con = $this->connect();
			$sql = "SELECT COUNT(DISTINCT date_time) as total_lectures FROM attendance WHERE class_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function deleteAttendance($data){
		try{
			$con = $this->connect();
			$sql = "DELETE FROM attendance WHERE class_id = ? AND date_time = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getHodReportYearWise($query, $data){
		try{
			$con = $this->connect();
			$con->query("SET @sql = NULL");
            $stmt = $con->prepare("SELECT GROUP_CONCAT(DISTINCT CONCAT( 'SUM(IF(a.class_id = ''', class.class_id, ''', a.status, NULL)) AS ', CONCAT('`',courses.course_name,'`'))) INTO @sql FROM courses LEFT JOIN class ON courses.course_id = class.course_id LEFT JOIN attendance ON attendance.class_id = class.class_id WHERE ".$query." ORDER BY courses.course_id+0");
            $stmt->execute($data);
            $stmt = $con->prepare("SET @sql = CONCAT('SELECT  b.roll_no, CONCAT(b.last_name,'' '', b.first_name,'' '', b.middle_name) as student_name, a.student_id, ', @sql ,' FROM attendance as a JOIN student as b ON a.student_id = b.prn_no JOIN class as c ON a.class_id = c.class_id GROUP BY a.student_id ORDER BY b.roll_no+0')");
            $stmt->execute();
            $stmt = $con->prepare("PREPARE stmt FROM @sql");
            $stmt->execute();
            $stmt = $con->prepare("EXECUTE stmt");
            $stmt->execute();
            $each_sub_total = $stmt->fetchAll();
            $con->query("DEALLOCATE PREPARE stmt");


			$con = $this->connect();
			$con->query("SET @sql = NULL");
            $stmt = $con->prepare("SELECT GROUP_CONCAT(DISTINCT CONCAT( 'SUM(IF(c.dept_id = ''', class.dept_id, ''', a.status, NULL)) AS Total')) INTO @sql FROM courses LEFT JOIN class ON courses.course_id = class.course_id LEFT JOIN attendance ON attendance.class_id = class.class_id WHERE ".$query." ORDER BY courses.course_id+0");
            $stmt->execute($data);
            $stmt = $con->prepare("SET @sql = CONCAT('SELECT ', @sql ,' FROM attendance as a JOIN student as b ON a.student_id = b.prn_no JOIN class as c ON a.class_id = c.class_id GROUP BY a.student_id ORDER BY b.roll_no+0')");
            $stmt->execute();
            $stmt = $con->prepare("PREPARE stmt FROM @sql");
            $stmt->execute();
            $stmt = $con->prepare("EXECUTE stmt");
            $stmt->execute();
            $total_sum = $stmt->fetchAll();
            $con->query("DEALLOCATE PREPARE stmt");


			$con = $this->connect();
			$con->query("SET @sql = NULL");
            $stmt = $con->prepare("SELECT GROUP_CONCAT(DISTINCT CONCAT( 'COUNT(IF(a.class_id = ''', class.class_id, ''', a.class_id, NULL)) AS ', CONCAT('`',courses.course_name,'`'))) INTO @sql FROM courses LEFT JOIN class ON courses.course_id = class.course_id LEFT JOIN attendance ON attendance.class_id = class.class_id WHERE".$query." ORDER BY courses.course_id+0");
            $stmt->execute($data);
            $stmt = $con->prepare("SET @sql = CONCAT('SELECT ', @sql ,' FROM attendance as a JOIN student as b ON a.student_id = b.prn_no JOIN class as c ON a.class_id = c.class_id GROUP BY a.student_id ORDER BY b.roll_no+0')");
            $stmt->execute();
            $stmt = $con->prepare("PREPARE stmt FROM @sql");
            $stmt->execute();
            $stmt = $con->prepare("EXECUTE stmt");
            $stmt->execute();
            $total_lectures_conducted = $stmt->fetch();
            $con->query("DEALLOCATE PREPARE stmt");
			return array("each_total" => $each_sub_total, "total" => $total_sum, "total_lectures" => $total_lectures_conducted);
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getAttendanceByDate($query, $data){
		try{
			$con = $this->connect();
			$sql = "SELECT DISTINCT a.class_id FROM attendance as a JOIN class as b ON a.class_id = b.class_id JOIN courses  ON b.course_id = courses.course_id JOIN division ON division.div_id = b.div_id WHERE ".$query."";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassSemWise($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*,b.course_name FROM class as a JOIN courses as b ON a.course_id = b.course_id WHERE a.academic_id = ? AND a.s_class_id = ? AND a.div_id = ? AND a.sem_id = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	public function checkIfClassAttendanceExisits($data){
		try{
			$con = $this->connect();
			$sql = "SELECT DISTINCT a.class_id, a.date_time FROM attendance as a JOIN class as b ON a.class_id = b.class_id WHERE b.dept_id = ? AND b.s_class_id = ? AND b.div_id = ? and b.academic_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStaffPracticalClassByAcademicYearAndFacultyID($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.div_name, j.batch_name FROM practical_class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.year_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN division as i ON a.div_id = i.div_id JOIN batch as j ON a.batch_id = j.batch_id WHERE a.academic_id = ? AND a.faculty_id = ? ORDER BY p_class_id, year_id, sem_id, academic_id";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getStudentForPractAttendanceBatchWise($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, p_class_id FROM student as a JOIN practical_class as b ON a.year_id = b.year_id AND a.div_id = b.div_id AND a.batch_id = b.batch_id WHERE b.p_class_id = ? ORDER BY roll_no+0;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getPractClassById($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, g.sem_name, h.academic_descr, i.batch_name, j.div_name FROM practical_class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.year_id = e.s_class_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id JOIN batch as i ON a.batch_id = i.batch_id JOIN division as j ON a.div_id = j.div_id WHERE p_class_id = ? AND a.faculty_id = ?;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetch();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getFullPracticalAttendanceByClassDateAndTime($data){
		try{
			$con = $this->connect();
			$sql = "SELECT b.* ,a.*, dept_name, s_class_name, div_name, batch_name FROM pract_attend as a JOIN student as b ON a.prn_no = b.prn_no JOIN department as c ON b.dept_id = c.dept_id JOIN student_class as d ON b.year_id = d.s_class_id JOIN division as e ON e.div_id = b.div_id JOIN batch as f ON f.batch_id = b.batch_id WHERE a.p_class_id = ? AND a.date_time = ? ORDER BY b.roll_no+0;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getPracticalAttendance($data){
		try{
			$con = $this->connect();
			$sql = "SELECT a.*, b.* FROM pract_attend as a JOIN student as b ON a.prn_no = b.prn_no WHERE p_class_id = ? AND date_time = ? ORDER BY b.roll_no+0";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function insertStudentPracticalAttendance($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO pract_attend(p_class_id, prn_no, status, date_time, course_id) VALUES(?,?,?,?,?)";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
				
		}catch(PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function updateStudentPracticalAttendance($data){
        try{
			$con = $this->connect();
			$sql = "UPDATE pract_attend SET status = ? WHERE p_class_id = ? AND prn_no = ? AND date_time = ?";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return true;
				
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
    }

	public function getClassBySemesterYearAndAcademic($data){
		try{
			$con = $this->connect();

			//$sql = "SELECT a.*,b.course_name, c.batch_name, d.div_name FROM practical_class as a JOIN courses as b ON a.course_id = b.course_id JOIN batch as c ON a.batch_id = c.batch_id JOIN division as d ON a.div_id = d.div_id WHERE a.academic_id = ? AND a.year_id = ? AND a.sem_id = ? AND a.dept_id = ? AND a.div_id = ? ORDER BY b.course_name,a.batch_id;";
			$sql = "SELECT DISTINCT a.course_id, b.course_name FROM practical_class as a JOIN courses as b ON a.course_id = b.course_id WHERE  a.academic_id = ? AND a.year_id = ? AND a.sem_id = ? AND a.div_id = ? AND a.dept_id = ? ORDER BY a.p_class_id;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getPracticalClassByCourses($query,$data){
		try{
			$con = $this->connect();
			//$sql = "SELECT a.*,b.course_name, c.batch_name, d.div_name FROM practical_class as a JOIN courses as b ON a.course_id = b.course_id JOIN batch as c ON a.batch_id = c.batch_id JOIN division as d ON a.div_id = d.div_id WHERE a.academic_id = ? AND a.year_id = ? AND a.sem_id = ? AND a.dept_id = ? AND a.div_id = ? ORDER BY b.course_name,a.batch_id;";
			$sql = "SELECT a.p_class_id FROM practical_class as a WHERE a.academic_id = ? AND a.course_id = ? ".$query." ORDER BY a.p_class_id;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	// public function getPracticalReport($query, $data){
	// 	try{
	// 		$con = $this->connect();
	// 		$con->query("SET @sql = NULL");
    //         $stmt = $con->prepare("SELECT GROUP_CONCAT(DISTINCT CONCAT( 'MAX(IF(a.date_time = ''', date_time, ''', a.status, NULL)) AS ', CONCAT(''',date_time,''') ) ) INTO @sql FROM pract_attend as a JOIN practical_class as b ON a.p_class_id = b.p_class_id JOIN student as c ON a.prn_no = c.prn_no WHERE ".$query." ORDER BY c.roll_no+0;");
    //         $stmt->execute($data);
    //         $stmt = $con->prepare("SET @sql = CONCAT('SELECT a.p_class_id, a.prn_no, c.roll_no, CONCAT(c.last_name,'' '', c.first_name,'' '', c.middle_name) as student_Name, ', @sql, ' FROM pract_attend as a JOIN practical_class as b ON a.p_class_id = b.p_class_id JOIN student as c ON a.prn_no = c.prn_no WHERE ".$query." GROUP BY a.prn_no ORDER BY c.roll_no+0');");
	// 		$stmt->execute();
    //         $stmt = $con->prepare("PREPARE stmt FROM @sql");
    //         $stmt->execute();
    //         $stmt = $con->prepare("EXECUTE stmt");
    //         $stmt->execute();
    //         $result = $stmt->fetchAll();
    //         $con->query("DEALLOCATE PREPARE stmt");
	// 		return $result;
	// 	}
	// 	catch (PDOException $e){
	// 		return array("e" => $e->getMessage());
	// 	}
	// }

	public function getPracticalReportDynamicColumn($query, $data){
		try{
			$con = $this->connect();
			$sql = "SELECT GROUP_CONCAT(DISTINCT CONCAT( 'MAX(IF(a.date_time = ''', date_time, ''', a.status, NULL)) AS ', CONCAT('''',date_time,'''') ) ) as string FROM pract_attend as a JOIN practical_class as b ON a.p_class_id = b.p_class_id JOIN student as c ON a.prn_no = c.prn_no WHERE ".$query." ORDER BY c.roll_no+0;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetch();
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getFinalPracticalReport($query, $data, $string){
		try{
			//$result = array();
			$con = $this->connect();
			$sql = "SELECT b.batch_id, d.batch_name, a.prn_no, c.roll_no, CONCAT(c.last_name,'"." "."', c.first_name,'"." "."', c.middle_name) as student_name, SUM(a.status) as total, (SUM(a.status)/COUNT(a.status))*100 as percent, ".$string['string']." FROM pract_attend as a JOIN practical_class as b ON a.p_class_id = b.p_class_id JOIN student as c ON a.prn_no = c.prn_no JOIN batch as d ON b.batch_id = d.batch_id WHERE ".$query." GROUP BY a.prn_no ORDER BY c.roll_no+0;";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) return $stmt->fetchAll();

			// $sql = "SELECT SUM(status) as total, (SUM(status)/COUNT(status))*100 as percent FROM pract_attend as a JOIN practical_class as b on a.p_class_id = b.p_class_id JOIN student on a.prn_no = student.prn_no WHERE ".$query." GROUP BY a.prn_no ORDER BY roll_no+0;";
			// $stmt = $con->prepare($sql);
			// if($stmt->execute($data)) $total = $stmt->fetchAll();

			//return $result;
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}


	public function getPracticalReportSemester($query, $data){
		try{
			$con = $this->connect();
			$arr = array();
			$sql = "SELECT GROUP_CONCAT(DISTINCT CONCAT('SUM(IF(a.course_id = ''', a.course_id , ''', a.status, 0)) AS ', CONCAT('`',c.course_name,'`') ) ) as string FROM pract_attend as a RIGHT JOIN practical_class as b ON a.p_class_id = b.p_class_id RIGHT JOIN courses as c ON b.course_id = c.course_id WHERE ".$query.";";
			$stmt = $con->prepare($sql);
			if($stmt->execute($data)) { 
				$string = $stmt->fetch()['string'];
				$sql = "SELECT batch_name,a.prn_no, c.roll_no, CONCAT(c.first_name,' ',c.middle_name,' ',c.last_name) as student_name, SUM(a.status) as total, (SUM(a.status)/COUNT(a.status))*100 as percent, ".$string." FROM pract_attend as a JOIN practical_class as b ON a.p_class_id = b.p_class_id JOIN student as c ON a.prn_no = c.prn_no JOIN batch as d on b.batch_id = d.batch_id WHERE ".$query." GROUP BY a.prn_no ORDER BY d.batch_id,c.roll_no+0;";
				$stmt = $con->prepare($sql);
				if($stmt->execute($data)) return $stmt->fetchAll();
			}
		}catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}
};