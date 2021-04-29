<?php
    namespace app\admin;
    require_once __DIR__ . '\..\vendor\autoload.php';
    session_start();
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) && !isset($_SESSION['faculty_id']) && !$_SESSION['role_id'] == 1){
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
    <script src="../assets/js/admin/script.js"></script>
    <title>Add Department</title>
</head>
<body>
    <?php include "adminHeader.php"; ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#courseAddModal">
                    Add Course
                </button>

                <!-- The Modal -->
                <div class="modal" id="courseAddModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h1>Course Details</h1>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="add-course">
                                    <div class="form-group">
                                        <label for="course_id">Course Code: </label>
                                        <input type="text" name="course_id" class="form-control form-control-sm" placeholder="Course Code">
                                    </div>
                                    <div class="form-group">
                                        <label for="course_id">Course Name: </label>
                                        <input type="text" name="course_name" class="form-control form-control-sm" placeholder="Course Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="course-dept">Department: </label>
                                        <select id="course-dept" name="course_dept" class="form-control form-control-sm">
                                        <?php 
                                            $data = $user->getDepartment();
                                            if(!$data) die("<option>Department Not Available</option>");
                                            foreach($data as $d){
                                                echo '<option value="'.$d['dept_id'].'">'.$d['dept_name'].'</option>';
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="class_year">Class: </label>
                                        <select id="class_year" name="course_class" class="form-control form-control-sm">
                                        <option value=" "> </option>
                                        <?php 
                                            $data = $user->getClassYear();
                                            if(!$data) die("<option>Department Not Available</option>");
                                            foreach($data as $d){
                                                echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_sem"><b>Semester</b></label>
                                        <select name="s_sem" name="course_sem" id="s_sem" class="form-control form-control-sm" disabled>
                                            <option value=" ">Select Year</option>
                                        </select>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">ADD</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    <!-- <button type="button" class="btn cancel" onclick="closeForm()">Close</button> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="course-table">
            <thead>
                <tr border="3px">
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Department</th>
                    <th>Class</th>
                    <th>Semester</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getCourses();
                    if(!$data) echo "<tr><td>Nothing Found<td></tr>";
                    foreach($data as $d){
                        echo '<tr>
                                <td>'.$d['course_id'].'</td>
                                <td>'.$d['course_name'].'</td>
                                <td>'.$d['dept_name'].'</td>
                                <td>'.$d['s_class_name'].'</td>
                                <td>'.$d['sem_name'].'</td>
                                <td>
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'.$d['course_id'].'" data-toggle="modal" data-target="#viewModal">View Details</button>
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'.$d['course_id'].'">Delete</button>
                                </td>
                            </tr>';
                    }
                ?>
            </tbody>
        </table>




    </main>

</body>

</html>