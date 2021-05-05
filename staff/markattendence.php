<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    session_start();
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/staff/script.js"></script>
    <title>Mark Attendence</title>
</head>
<body>
<?php   include "staffHeader.php" ?>
    <main>
        <form class="form-inline" method="post" id="check-attend">
            <label for="email" class="mr-sm-2">Select Academic Year: </label>
            <select id="select-acd" name="academic_year" class="form-control form-control-sm mr-3"> 
                <option value=" "> </option>
                <?php 
                    $data = $user->getAcademicYear();
                    if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                    foreach($data as $d){
                        echo '<option value="'.$d['acedemic_id'].'" >'.$d['academic_descr'].'</option>';
                    }
                ?>  
            </select>
            <label for="email" class="mr-sm-2">Select Class:</label>
            <select id="select-class" name="class" class="form-control form-control-sm"> 
                <option value=" " data-class=" "> </option>
                <?php 
                    $data = $user->getClassByStaff([$_SESSION['faculty_id']]);
                    if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                    foreach($data as $d){
                        echo '<option value="'.$d['class_id'].'" data-class="'.$d['s_class_id'].'">'.$d['course_name'].'</option>';
                    }
                ?>  
            </select>
            <table id="attendance-table" class="table mt-4" hidden>
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
            <button class="btn btn-primary" id="save-btn" type="submit" hidden>Save</button> 
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
</body>

</html>