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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

    <style>
        #show_pract_class{
            text-align: center;
        }

        #show_pract_class a{
            color :black;
            text-decoration: none;
            margin-left : 10px;
        }
    </style>
</head>
<body>
<?php
$con = $user->connect();

$last_academic_year = $user->getLastAcademicYear();
var_dump($last_academic_year);
$result = $user->getStaffPracticalClassByAcademicYearAndFacultyID([$last_academic_year["acedemic_id"], $_SESSION['faculty_id']]);
var_dump($result);

?>

<div class="d-flex flex-wrap" id="show_pract_class">
    <?php 
        foreach($result as $r){
    ?>
        <a href="mark_pract_attendance.php?practical_class=<?php echo $r['p_class_id']; ?>" class="shadow p-3 mb-5 bg-white rounded">
            <div><strong>Course: </strong><?php echo $r['course_name'] ?></div>
            <div><strong>Class: </strong><?php echo $r['s_class_name'] .' Div: '. $r['div_name']?></div>
            <div><strong>Batch: </strong><?php echo $r['batch_name']?></div>
        </a>    

    <?php } ?>
</div>
</body>
</html>