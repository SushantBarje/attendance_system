<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }

    // if(isset($_REQUEST['submit-attend'])){
    //     unset($_POST['submit-attend']);
    //     $result = $user->saveAttendance();
    //     if($result['error'] == "none"){
    //         echo '<script> alert("Attendance Submitted")</script>';
    //     }else if($result['error'] == "already"){
    //         echo '<script> alert("Attendance Already Taken...")</script>';
    //     }else if($result['error'] == "empty"){
    //         echo '<script> alert("Fill all details...")</script>';
    //     }else if($result['error'] == "update"){
    //         echo '<script> alert("Attendance Updated...")</script>';
    //     }
    // }

    $class_id = $_GET['theory_class'];
    $class_info = $user->getTheoryClassById([$class_id, $_SESSION['faculty_id']]);
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
    <script type='text/javascript'>
     $(document).ready(function () {
     if ($("[rel=tooltip]").length) {
            $("[rel=tooltip]").tooltip();
        }
    });
    </script>
</head>
<body>
<?php   include "staffHeader.php" ?>
    <main>
        <h2 class="head">Take Theory Attendance</h2>
        <form class="theory-form mt-3" method="post" id="check-attend-theory">
            <div class="row offset-0">
                <?php date_default_timezone_set("Asia/Kolkata");?>
                <div class="col-sm-1"></div>
                <div class="col-sm-5">
                    <label for="date" class="mr-sm-2">Date</label>
                    <input type="date" class="form-control form-control-sm sheet-input-field-theory" id="date-theory" max="<?php echo date("Y-m-d") ?>" name="date">
                </div>
                <div class="col-sm-5">
                    <label for="time" class="mr-sm-2">Time</label>
                    <input type="time" class="form-control form-control-sm sheet-input-field-theory" id="time-theory" name="time">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <!-- <table id="attendance-table" class="table mt-4" hidden>
                <thead>
                    <tr>
                        <th>Roll no.</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                        <th hidden>Prn</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table> 
            <button class="btn btn-primary" id="save-btn" type="submit" hidden>Save</button>  -->
            <div class="row">
                <div class="container">
                    <div class="row mt-5">
                        <div class="col">
                            <div class="row offset-1">
                                <div class="col-sm-3" id="class-header">
                                    <input type="hidden" value = <?php echo $class_info['class_id'];?> name="class" id="class_id">
                                    <h5><b>Class- </b><?php echo $class_info["s_class_name"]?></h5>
                                </div>
                                <div class="col-sm-5" id="class-header">
                                    <h5><b>Course:- </b><?php echo $class_info["course_name"]?></h5>
                                </div>
                                <div class="col-sm-4" id="date-header">
                                    <!-- <h5><b>Date:- </b><?php echo date('d-m-Y', $class_info['date_time'])?></h5>-->
                                    <h5><b>Div:- </b> <?php echo $class_info['div_name']; ?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1 offset-5 mt-3">
                                    <button class="btn btn-primary" id="save-btn" type="submit" >Save</button>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center flex-wrap mt-2" id="theory-attend-list">
                            <?php 
                                $data = $user->getStudentByDeptDivisionAndYear([$class_info['dept_id'],$class_info['s_class_id'], $class_info['div_id'], $class_id]);
                                if(!$data){
                                    echo "<h3>No student found!</h3>";
                                }
                                foreach($data as $d){
                                    $present = (int)$d['total_present']+1;
                                    echo '<div class="grid-item m-2 mark-attend">
                                            <input type="hidden" name="attend['.$d['prn_no'].']" value="1" data-id="'.$d['prn_no'].'"/>
                                            <span class="btn roll_no"><a href="#?prn_no='.$d['prn_no'].'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'.$d['roll_no'].'</b></a></span> : <span class="present">'.$present.'</span>
                                            <button type="button" class="btn btn-success marker">P</button>
                                        </div>';
                                }
                                //echo '<p>'.$user->getCountAttendanceByClassAndRoll([$_SESSION['class_id'],$d['roll_no']]).'</p>';
                            ?>
                        </div>
                    </div>   
                </div>    
            </div> 
        </form>
        
        <!-- <table id="class-table">
            <thead>
                <tr>
                    <th>Class ID</th>
                    <th>Course</th>
                    <th>Class</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // $data = $user->getClassByStaff([$_SESSION['faculty_id']]);
                    // if(!$data) echo "<tr><td>Nothing Found</td</tr>";
                    // foreach($data as $d){
                    //     echo '<tr>
                    //             <td>'.$d['class_id'].'</td>
                    //             <td>'.$d['course_name'].'</td>
                    //             <td>'.$d['s_class_name'].'</td>
                    //             <td>
                    //                 <a href="attendance_sheet.php?dept='.$_SESSION['dept'].'&class='.$d['s_class_id'].'" class="btn btn-primary">Take Attendance</a>
                    //             </td>        
                    //         </tr>';
                    // }
                ?>
            </tbody>
        </table> -->
    </main>

    <script src="../assets/js/staff/script.js"></script>
</body>

</html>