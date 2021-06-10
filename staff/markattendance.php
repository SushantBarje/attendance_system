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
        <h2 class="head">Take Attendance</h2>
        <form class="form mt-3" method="post" id="check-attend">
            <div class="row">
                <div class="col-sm-2">
                    <label for="select-acd" class="mr-sm-2">Academic Year: </label>
                    <select id="select-acd" name="academic_year" class="form-control form-control-sm mr-3 sheet-input-field"> 
                        <option value=" "> </option>
                        <?php 
                            $data = $user->getAcademicYear();
                            if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                            foreach($data as $d){
                                echo '<option value="'.$d['acedemic_id'].'" >'.$d['academic_descr'].'</option>';
                            }
                        ?>  
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="select-year" class="mr-sm-2">Year: </label>
                    <select id="select-year" name="year_id" class="form-control form-control-sm mr-3 sheet-input-field"> 
                        <option value=" "> </option>
                        <?php 
                            $data = $user->getYearBelongsDept([$_SESSION['dept']]);
                            if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                            foreach($data as $d){
                                echo '<option value="'.$d['year_id'].'" >'.$d['s_class_name'].'</option>';
                            }
                        ?>  
                    </select>
                </div>
                <div class="col-sm-1">
                    <label for="select-div" class="mr-sm-2">Division: </label>
                    <select id="select-div" name="div_id" class="form-control form-control-sm mr-3 sheet-input-field"> 
                        <option value=" "> </option>
                        <?php 
                            $data = $user->getDivBelongsDept([$_SESSION['dept']]);
                            if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                            foreach($data as $d){
                                echo '<option value="'.$d['div_id'].'" >'.$d['div_name'].'</option>';
                            }
                        ?>  
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="select-div">Select Semester :</label>
                    <select class="form-control form-control-sm report-select-input" name="sem" id="s_sem">
                        <option value=""> </option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="class" class="mr-sm-2">Class:</label>
                    <select id="select-class" name="class" class="form-control form-control-sm sheet-input-field" disabled> 
                        <option value=" " data-class=" "> </option>
                        <!-- <?php 
                            $data = $user->getClassByStaff([$_SESSION['faculty_id']]);
                            if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                            foreach($data as $d){
                                echo '<option value="'.$d['class_id'].'" data-class="'.$d['s_class_id'].'">'.$d['course_name'].'</option>';
                            }
                        ?>   -->
                    </select>
                </div>
                <?php date_default_timezone_set("Asia/Kolkata");?>
                <div class="col-sm-2">
                    <label for="date" class="mr-sm-2">Date</label>
                    <input type="date" class="form-control form-control-sm sheet-input-field" id="date" max="<?php echo date("Y-m-d") ?>" name="date">
                </div>
                <div class="col-sm-2">
                    <label for="time" class="mr-sm-2">Time</label>
                    <input type="time" class="form-control form-control-sm sheet-input-field" id="time" name="time">
                </div>
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
                    <div class="col">
                        <div class="row mt-5 offset-0">
                            <div class="col-sm-2">
                                <button class="btn btn-primary ml-5" id="save-btn" type="submit" name="submit-attend" hidden>Save</button>
                            </div>
                            <div class="col-sm-6 offset-1" id="class-header">
                                
                            </div>
                            <div class="col-sm-3" id="date-header">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center flex-wrap mt-2" id="attend-list" hidden>
                                <?php 
                                    // $data = $user->getStudentByDept([$_SESSION['dept']]);
                                    // foreach($data as $d){
                                    //     echo '<div class="grid-item m-2 mark-attend">
                                    //             <input type="hidden" name="attend['.$d['prn_no'].']" value="1" data-id="'.$d['prn_no'].'"/>
                                    //             <p>'.$d['roll_no'].'</p>
                                    //             <button type="button" class="btn btn-success rounded-0 marker">P</button>
                                    //         </div>';
                                    // }
                                    //<p>'.$user->getCountAttendanceByClassAndRoll([$_SESSION['class_id'],$d['roll_no']]).'</p>
                                ?>
                            </div>
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
                    $data = $user->getClassByStaff([$_SESSION['faculty_id']]);
                    if(!$data) echo "<tr><td>Nothing Found</td</tr>";
                    foreach($data as $d){
                        echo '<tr>
                                <td>'.$d['class_id'].'</td>
                                <td>'.$d['course_name'].'</td>
                                <td>'.$d['s_class_name'].'</td>
                                <td>
                                    <a href="attendance_sheet.php?dept='.$_SESSION['dept'].'&class='.$d['s_class_id'].'" class="btn btn-primary">Take Attendance</a>
                                </td>        
                            </tr>';
                    }
                ?>
            </tbody>
        </table> -->
    </main>

    <script src="../assets/js/staff/script.js"></script>
</body>

</html>