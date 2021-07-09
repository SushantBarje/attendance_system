<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }


    $class_id = $_GET['class_id'];
    $date_time = $_GET['datetime'];
    $formated_date_time = date('d/m/Y h:i:s a ', strtotime($date_time));
    $info = $user->getClassById([$_SESSION['faculty_id'], $class_id]);
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="../CSS/attendance_list.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
    <title>Mark Attendence</title>
</head>
<body>
<?php   include "staffHeader.php" ?>
    <main>
        <h2 class="head">Take Attendance</h2>
        <form class="form mt-3" method="post" id="check-attend-theory">
            <input type="hidden" value = <?php echo $class_id;?> name="class" id="class_id">
            <input type="date" class="form-control form-control-sm sheet-input-field-pract" id="date-pract" value="<?php echo date('Y-m-d', strtotime($date_time));;?>" name="date" hidden>
            <input type="time" class="form-control form-control-sm sheet-input-field-theory" id="time-theory" name="time" value="<?php echo date('H:i:s', strtotime($date_time));;?>" hidden>
            <div class="row">
                <div class="container">
                    <div class="col">
                        <div class="row mt-2 offset-1">
                            <div class="col-sm-4" id="class-header">
                                <p>Subject:- <?php echo $info['course_name']; ?></p>
                            </div>
                            <div class="col-sm-2">
                                <p>Div:- <?php echo $info['div_name']; ?> </p>
                            </div> 
                            <div class="col-sm-6" id="date-header">
                                <p>Date & Time:- <?php echo $formated_date_time;?> </p>
                            </div> 
                        </div>
                        <div class="row mt-1 offset-5">
                            <div class="col-sm-2">
                                <button class="btn btn-primary" id="save-btn" type="submit" >Save</button>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center flex-wrap mt-2" id="attend-list" hidden>
                                <?php 
                                    //$data = $user->getTheoryAttendance([$class_id, $date_time]);
                                    // $total = $user->getAttendanceTotalofEachStudentByClass([$class_id]);
                                    // var_dump($total);
                                    //$c = array_combine($data,$total);
                                    //var_dump($c);
                                    $data = json_decode($user->showStudentByClassForAttendance($class_id, $date_time), TRUE);
                                    
                                    for($i = 0; $i < count($data["total"]); $i++){
                                        $present = (int)$data["total"][$i]['total_present'];
                                        if($data["data"][$i]['status'] == 0){
                                            echo '<div class="grid-item m-2 mark-attend">
                                                <input type="hidden" name="attend['.$data["data"][$i]['prn_no'].']" value="0" data-id="'.$data["data"][$i]['prn_no'].'"/>
                                                <span class="btn roll_no"><a href="#?prn_no='.$data["data"][$i]['prn_no'].'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'.$data["data"][$i]['roll_no'].'</b></a></span> : <span class="present">'.$present.'</span>
                                                <button type="button" class="btn btn-danger rounded-0 marker">A</button>
                                            </div>';
                                        }else{
                                            echo '<div class="grid-item m-2 mark-attend">
                                                <input type="hidden" name="attend['.$data["data"][$i]['prn_no'].']" value="1" data-id="'.$data["data"][$i]['prn_no'].'"/>
                                                <span class="btn roll_no"><a href="#?prn_no='.$data["data"][$i]['prn_no'].'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'.$data["data"][$i]['roll_no'].'</b></a></span> : <span class="present">'.$present.'</span>
                                                <button type="button" class="btn btn-success rounded-0 marker">P</button>
                                            </div>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>   
                    </div>
                </div>
                    
            </div> 
        </form>
    </main>

    <script src="../assets/js/staff/script.js"></script>
</body>

</html>