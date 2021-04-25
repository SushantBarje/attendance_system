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
			$sql = "SELECT * FROM academic_year";
			$stmt = $this->connect()->prepare($sql);
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
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$acd_year_id]);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			return array("e" => $e->getMessage());
		}
	}

	public function insertAcademicYear($data){
		try{
			$sql = "INSERT INTO academic_year(academic_descr) VALUES (?);";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			$id = $this->connect()->lastInsertId();
			return $id;
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
	public function getByFacultyId($username){
		try{
			$sql = "SELECT * FROM faculty WHERE faculty_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$username]);
			return $stmt->fetch();
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
			$sql = "SELECT * FROM faculty";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
		
	}


	/*
	#	Function will run query to select only HOD if his faculty_id matches.   
	#	@params usernme = faculty_id for staff.
	#	@returns Associative array contanining single row.
	*/
	public function getHodBy($username){ 
		try{
			$sql = "SELECT * FROM faculty WHERE faculty_id = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$username]);
			$result = $stmt->fetch();
			return $result;
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
	public function getAllHod(){
		try{
			$sql = "SELECT * FROM faculty WHERE role_id = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
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
	public function insertOneFaculty($faculty_id, $first_name, $last_name, $dept, $role, $password){
		try{
			$sql = "INSERT INTO faculty(faculty_id, first_name, last_name, dept_id, role, password) VALUES (?,?,?,?,?,?);";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$faculty_id, $first_name, $last_name, $dept, $role, $password]);
			return array(true, null);
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
			$sql = "DELETE * FROM faculty WHERE faculty_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$faculty_id]);
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
			$sql = "SELECT * FROM student";
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
			$sql = "SELECT * FROM student WHERE prn_no = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$prn_no]);
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
			$sql = "INSERT INTO student VALUES(?,?,?,?,?,?,?,?)";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($data);
			if($stmt->rowCount()){
				return true;
			}
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

	/*
	#	This function will insert the department into database
	#	@params $data:= Array containing all the details of department.
	#	@returns 
	*/
	public function insertDepartment($data){
		try{
			$sql = "INSERT INTO department VALUES(?,?);";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$data]);
			return $stmt->fetch();
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

	public function updateDepartment($dept_id,$data){
		$setPart = array();
        $bindings = array();

        foreach ($data as $key => $value)
        {
            $setPart[] = "{$key} = :{$key}";
            $bindings[":{$key}"] = $value;
    	}
        $bindings[":dept_id"] = $dept_id;
        try{
			$sql = "UPDATE department SET".implode(',',$setPart)." WHERE dept_id = :dept_id;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute($bindings);
		}
		catch(PDOException $e){
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
			$sql = "DELETE * FROM department WHERE dept_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$dept_id]);
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
			$sql = "SELECT * FROM semester WHERE s_class_id = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$year_id]);
			return $stmt->fetch();
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
			return $stmt->fetch();
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
			return $stmt->fetch();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}

	public function getCourses(){
		try{
			$sql = "SELECT * FROM courses";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			return $stmt->fetch();
		}
		catch (PDOException $e){
			return array("e" => $e->getMessage());
		}
	}
};