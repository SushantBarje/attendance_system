<?php
namespace app\model;
use \PDOException;
use app\database\Database;

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

	/*
	#	Function will return a particular academic year using id.
	#	@params $acad_year_id
	#	@return array().
	*/
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


	/*#################################################################################################
	#	Function will run query to select faculty member if his faculty_id matches.   
	#	Include query for HOD, Staff member.
	#	@params usernme = faculty_id for staff.													
	#	@returns Associative array contanining single row.
	###################################################################################################*/
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
			$sql = "SELECT a.*, b.dept_name,c.s_class_name,d.div_name,e.batch_name FROM student as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id";
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
			$sql = "SELECT a.*, b.dept_name,c.s_class_name,d.div_name,e.batch_name FROM student as a JOIN department as b ON a.dept_id = b.dept_id JOIN student_class as c ON a.year_id = c.s_class_id JOIN division as d ON a.div_id = d.div_id JOIN batch as e ON a.batch_id = e.batch_id WHERE a.prn_no = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($prn_no);
			return $stmt->fetch();
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
			$sql = "INSERT INTO student(prn_no,first_name,middle_name, last_name, roll_no, dept_id, year_id, div_id, batch_id) VALUES(?,?,?,?,?,?,?,?,?)";
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

	/*
	#	This function will delete the student based on $prn_no.
	#	@params $prn_no
	#	@return bool true/exception false;
	*/
	public function deleteStudentById($prn_no){
		try{
			$sql = "DELETE FROM student WHERE prn_no = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$prn_no]);
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
			$sql = "SELECT * FROM department WHERE dept_id = ?";
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

	public function getCourses(){
		try{
			$sql = "SELECT a.*, b.dept_name, c.s_class_name, d.sem_name FROM courses AS a INNER JOIN department AS b ON a.dept_id = b.dept_id JOIN student_class AS c ON a.s_class_id = c.s_class_id JOIN semester as d ON a.sem_id = d.sem_id";
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
			$stmt = $this->connect()->prepare($sql);
			if($stmt->execute($data)) return true;
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function insertOneClass($data){
		try{
			$con = $this->connect();
			$sql = "INSERT INTO class(faculty_id,course_id,dept_id,div_id,sem_id,academic_id) VALUES(?,?,?,?,?,?)";
			$stmt = $con->prepare($sql);
			$stmt->execute($data);
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getClassByDept($data){
		try{
			$sql = "SELECT a.*, b.first_name, b.last_name, c.course_name, d.dept_name, e.s_class_name, f.div_name, g.sem_name, h.academic_descr   FROM class as a JOIN faculty as b ON a.faculty_id = b.faculty_id JOIN courses as c ON a.course_id = c.course_id JOIN department as d ON a.dept_id = d.dept_id JOIN student_class as e ON a.s_class_id = e.s_class_id JOIN division as f ON a.div_id = f.div_id JOIN semester as g ON a.sem_id = g.sem_id JOIN academic_year as h ON a.academic_id = h.acedemic_id WHERE dept_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}
};