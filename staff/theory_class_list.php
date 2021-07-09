<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }

    $last_academic_year = $user->getLastAcademicYear();
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

    <style>
         #show_class{
            text-align: center;
        }
        

        #show_class a{
            color :black;
            text-decoration: none;
            margin-left : 1.5rem;
            padding: 0 !important;
            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php   include "staffHeader.php" ?>
    <main>
        <div class="row">
            <div class="col-12 col-sm-12">
                <h2 class="head">Attendance</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form id="attend-class-theory">
                    <div class="form-group">
                        <label for="acd_id">Academic Year</label>
                        <select class="form-control" name="academic_year" id="acd_id">
                            <option value="<?php echo isset($last_academic_year["acedemic_id"]) ?? '' ?>" selected disabled hidden><?php echo $last_academic_year['academic_descr'] ?? ''?></option>
                            <?php 
                                    $result = $user->getAcademicYear();
                                    if(!$result){
                                        echo "<option value=''>Nothing Found</option>";
                                    }
                                    foreach($result as $r){
                            ?>
                            <option value="<?php echo $r['acedemic_id']?>"><?php echo $r['academic_descr'] ?></option>
                            <?php
                                    }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <?php
            $result = $user->getStaffTheoryClassByAcademicYearAndFacultyID([$last_academic_year["acedemic_id"], $_SESSION['faculty_id']]);
            ?>

            <div class="d-flex flex-wrap" id="show_class">
                <?php 
                    foreach($result as $r){
                ?>
                    <a href="theory_mark_attend.php?theory_class=<?php echo $r['class_id']; ?>" class="shadow p-3 mb-4 bg-white rounded">
                        <div class="class-box">
                            <div class="div">
                                <div><strong>Course: </strong><?php echo $r['course_name'] ?></div>
                                <div><strong>Class: </strong><?php echo $r['s_class_name'] .' <strong>Div: </strong>'. $r['div_name']?></div>
                                <div><strong>Dept: </strong><?php echo $r['dept_name']; ?></div>
                            </div>
                        </div>
                    </a>    

                <?php } ?>
            </div>
    </main>

    <script src="../assets/js/staff/script.js"></script>

</body>

</html>