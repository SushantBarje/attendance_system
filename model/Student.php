<?php
namespace app\model;
use app\database\Database;
use PDOException;

class Student extends Database {

	private $prn_no;

    public function getStudentById($data){
        try{
            $sql = "SELECT * FROM student WHERE prn_no = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($data);
            return $stmt->fetchAll();
        }
        catch(PDOException $e){
            return json_encode(array("error" => $e));
        }
    }
	
};