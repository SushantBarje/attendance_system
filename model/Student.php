<?php
namespace app\model;
use app\database\Database;
use PDOException;

class Student extends Database {

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

    public function getStudentReport($data){
        try{
            $sql = "SELECT  a.class_id, c.course_name , SUM(status) as present, (COUNT(status) - SUM(status)) as absent, COUNT(status) as total_lectures, (SUM(status)/COUNT(status))*100 as percent FROM attendance as a JOIN class as b ON a.class_id = b.class_id JOIN courses as c ON b.course_id = c.course_id WHERE a.student_id = ? GROUP BY a.class_id;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($data);
            return $stmt->fetchAll();
        }
        catch(PDOException $e){
            return json_encode(array("error" => $e));
        }
    }

    public function getClassReport($data){
        try{
            $con = $this->connect();
            $sql = "SELECT date_time, status from attendance WHERE class_id = ? AND student_id = ?;";
            $stmt = $con->prepare($sql);
            if($stmt->execute($data)) return $stmt->fetchAll();

        }catch(PDOException $e){
            return json_encode(array("error" => $e));
        }
    }

    public function getStudentReportPractical($data){
        try{
            $sql = "SELECT  a.p_class_id, c.course_name , SUM(status) as present, (COUNT(status) - SUM(status)) as absent, COUNT(status) as total_lectures, (SUM(status)/COUNT(status))*100 as percent FROM pract_attend as a JOIN practical_class as b ON a.p_class_id = b.p_class_id JOIN courses as c ON b.course_id = c.course_id WHERE a.prn_no= ? GROUP BY a.p_class_id;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($data);
            return $stmt->fetchAll();
        }
        catch(PDOException $e){
            return json_encode(array("error" => $e));
        }
    }
	
    public function getClassReportPractical($data){
        try{
            $con = $this->connect();
            $sql = "SELECT date_time, status from pract_attend WHERE p_class_id = ? AND prn_no = ?;";
            $stmt = $con->prepare($sql);
            if($stmt->execute($data)) return $stmt->fetchAll();

        }catch(PDOException $e){
            return json_encode(array("error" => $e));
        }
    }
};