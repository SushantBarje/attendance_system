<?php
    namespace app;
    require_once __DIR__ . '\vendor\autoload.php';
    use app\controller\FacultyController;
    use \PDO;
    use \PDOException;

    $user = new FacultyController();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
	<!-- <style>
	   th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: 800px;
			margin: 0 auto;
		}
	</style> -->
</head>
<body>
<?php echo date('Y-m-d H:i:s' , strtotime('2021-05-27T17:35'));?>
<?php
$dbh = $user->connect();
try{
    //$sql = "SET @sql = NULL;";
    // $stmt = $con->prepare($sql);
    // $stmt->execute();
    // $sql = "SELECT GROUP_CONCAT(DISTINCT CONCAT( 'MAX(IF(a.date_time = ''', date_time, ''', a.status, NULL)) AS ', CONCAT('`',date_time,'`'))) INTO @sql FROM attendance;";
    // $stmt = $con->prepare($sql);
    // $stmt->execute();
    // $sql = "SET @sql = CONCAT('SELECT a.class_id, a.student_id, b.roll_no, CONCAT(b.last_name, b.first_name, b.middle_name) as student_Name, ', @sql ,' FROM attendance as a JOIN student as b ON a.student_id = b.prn_no JOIN class as c ON a.class_id = c.class_id AND a.class_id = 102 GROUP BY a.student_id ORDER BY b.roll_no+0')";
    // $stmt = $con->prepare($sql);
    // $stmt->execute();
    // $sql = $con->prepare("PREPARE stmt FROM @sql");
    // $stmt->execute();
    // $result = $stmt->fetchAll();
    // var_dump($result);

    // $dbh->query("SET @sql = NULL");
    // $stmt = $dbh->prepare("SELECT GROUP_CONCAT(DISTINCT CONCAT( 'MAX(IF(a.date_time = ''', date_time, ''', a.status, NULL)) AS ', CONCAT('`',date_time,'`'))) INTO @sql FROM attendance WHERE class_id = ?;");
    // $stmt->execute([102]);
    // $stmt = $dbh->prepare("SET @sql = CONCAT('SELECT a.class_id, a.student_id, b.roll_no, CONCAT(b.last_name, b.first_name, b.middle_name) as student_Name, ', @sql ,' FROM attendance as a JOIN student as b ON a.student_id = b.prn_no JOIN class as c ON a.class_id = c.class_id GROUP BY a.student_id ORDER BY b.roll_no+0')");
    // $stmt->execute();
    // $stmt = $dbh->prepare("PREPARE stmt FROM @sql");
    // $stmt->execute();
    // $stmt = $dbh->prepare("EXECUTE stmt");
    // $result = $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($result);
    // $dbh->query("DEALLOCATE PREPARE stmt");

    $col = $user->getCoursesByDept([$_SESSION['dept']]);   
}catch(PDOException $e){
    die($e->getMessage());
}
?>

<table id="example" class="stripe row-border order-column">
    <thead>
        <tr>
            <th colspan="2">Class :TE CSE</th>
            
            <th colspan="2">Intersaction Session</th>
            <th colspan="2">Total</th>
            <th style="display:none"></th>
        </tr>
        
    </thead>
    <tbody>
        <tr>
            <th rowspan="2">Roll no.</th>
            <th>Name of Student</th>
            <!-- LOOPs -->
            <th>Unix</th>
            <th>Operating System</th>
            <!-- -->
            <th>Total</th>
            <th>%</th>
        </tr>
        <tr>
            <td>No of lectures</td>
             <!-- LOOPs -->
            <td>10</td>
            <td>20</td>
            <td>30</td>
            <!-- -->
            <td>100%</td>
        </tr> 
        <tr>
            <td>1</td>
            <td>Sushant H Barje</td>
            <td>5</td>
            <td>10</td>
            <td>15</td>
            <td>50%</td>
        </tr>

    </tbody>
</table>



<script>
$(document).ready(function(){
    $("#example").DataTable({
        fixedColumns:   {
            leftColumns: 2
        },
    });
})

</script>
</body>
</html>