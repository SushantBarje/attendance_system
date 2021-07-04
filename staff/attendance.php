<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }

    if(isset($_REQUEST['submit-attend'])){
        unset($_POST['submit-attend']);
        $result = $user->saveAttendance();
        if($result['error'] == "none"){
            echo '<script> alert("Attendance Submitted")</script>';
        }else if($result['error'] == "already"){
            echo '<script> alert("Attendance Already Taken...")</script>';
        }else if($result['error'] == "empty"){
            echo '<script> alert("Fill all details...")</script>';
        }else if($result['error'] == "update"){
            echo '<script> alert("Attendance Updated...")</script>';
        }
    }
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
        <h2 class="head">Attendance</h2>
        <div class="row mt-3">
            <div class="col-sm-3">
                <a href="markattendance.php" class="btn btn-secondary"> + New Theory Attendance</a>
            </div>
            <div class="col-sm-3">
                <a href="new_attendance.php" class="btn btn-secondary"> + New Practical Attendance</a>
            </div>
            <div class="col-sm-*">
            </div>
        </div>
        <h2 class="head mt-4 mb-4">History</h2>
        <form id="attend-details">
            <div class="row mt-3">
                <div class="col-sm-4">
                    <label for="select-acd">Academic Year</label>
                    <select class="form-control form-control-sm select-attend-input" name="select-acd" id="select-acd">
                        <option value=" "> </option>
                        <?php 
                            $data = $user->getAcademicYear();
                            if(!$data) echo "<option value=' '>class not found</option>";
                            foreach($data as $d){
                                echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                
                <div class="col-sm-4">
                    <label for="select-year">Class</label>  
                    <select class="form-control form-control-sm" name="select-class" id="select-class">
                        <option value=" "> </option>
                        <?php 
                            // $data = $user->getYearBelongsDept([$_SESSION['dept']]);
                            // if(!$data) echo "<option value=' '>class not found</option>";
                            // foreach($data as $d){
                            //     echo '<option value="'.$d['year_id'].'">'.$d['s_class_name'].'</option>';
                            // }
                        ?>
                    </select>
                </div>
                <?php 
                    //$data = $user->getDivBelongsDept([$_SESSION['dept']]);
                    //if(count($data) > 1){?>
                        <!-- <div class="col-sm-4">
                            <div id="div-element">
                                <label for="select-year">Div</label>  
                                <select class="form-control form-control-sm select-attend-input" name="select-year" id="select-year">
                                    <option value=" "> </option> -->
                                    <?php 
                                        // foreach($data as $d){
                                        //     echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
                                        // }
                                    ?>
                                <!-- </select>
                            </div>
                        </div> -->
                    <?php //}
                ?>
                <div class="col-sm-4 mt-4">
                    <button class="btn btn-success" id="check-details" type="button">Check</button>
                </div>
            </div>
                                            
        </form> 
        <div class="box">
            <div class="d-flex align-content-start flex-wrap" id="box-content">
                                          
            </div>
        </div>
    </main>

    <script src="../assets/js/staff/script.js"></script>
</body>

</html>