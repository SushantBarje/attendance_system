<?php
    namespace app\hod;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 1){
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <script src="../assets/js/hod/script.js"></script>
    <title>Manage Classes</title>
</head>

<body>

<body>
<?php   include "hodHeader.php" ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#manageClassModal">
                   + Allocate Theory Class
                </button>

                <!-- The Modal -->
                <div class="modal" id="manageClassModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Allocate Class</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="add-class">
                                    <div class="form-group">
                                        <label for="acd_year">Academic Year</label>
                                        <select name="acd_year" id="acd_year" class="form-control form-control-sm">
                                            <option value=" "></option>
                                            <?php
                                                $data = $user->getAcademicYear();
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="faculty_S">Select Faculty</label>
                                        <select name="faculty_s" class="form-control form-control-sm" id="faculty_s">
                                            <option value=" "> </option>
                                            <?php 
                                                $data = $user->getFacultyByDept([$_SESSION['dept']]);
                                                if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['faculty_id'].'">'.$d['first_name'].' '.$d['last_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="courses_s">Select Courses</label>
                                        <select class="form-control selectpicker " name="courses[]" id="courses_s" multiple data-live-search="true">
                                            <?php 
                                                $data = $user->getCoursesByDept([$_SESSION['dept']]);
                                                if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['course_id'].'">'.$d['course_name'].'</option>';
                                                }
                                            ?>
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

        <table id="class-table" class="table table-sm table-bordered table-hover cell-border nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th colspan="5">Theroy</th>
                </tr>
                <tr>
                    <th>Class ID</th>
                    <th>Course Name</th>
                    <th>Faculty</th>
                    <th>Class</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getClassByDept([$_SESSION['dept']]);
                    if(!$data) echo "<tr><td>Nothing Found</td</tr>";
                    foreach($data as $d){
                        echo '<tr>
                                <td>'.$d['class_id'].'</td>
                                <td>'.$d['course_name'].'</td>
                                <td>'.$d['first_name'].' '.$d['last_name'].'</td>
                                <td>'.$d['s_class_name'].'</td>
                                <td>
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'.$d['class_id'].'">Delete</button>
                                </td>        
                            </tr>';
                    }
                ?>
            </tbody>
        </table>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#managePracticalClassModal">
                   + Allocate Practical Class
                </button>

                <!-- The Modal -->
                <div class="modal" id="managePracticalClassModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Allocate Practical Class</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="add-pract-class">
                                    <div class="form-group">
                                        <label for="acd_year">Academic Year</label>
                                        <select name="acd_year" id="acd_year" class="form-control form-control-sm">
                                            <option value=" "></option>
                                            <?php
                                                $data = $user->getAcademicYear();
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="faculty_S">Select Faculty</label>
                                        <select name="faculty_s" class="form-control form-control-sm" id="faculty_s">
                                            <option value=" "> </option>
                                            <?php 
                                                $data = $user->getFacultyByDept([$_SESSION['dept']]);
                                                if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['faculty_id'].'">'.$d['first_name'].' '.$d['last_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="courses_s">Select Course</label>
                                        <select class="form-control" name="courses" id="courses_s">
                                            <?php 
                                                $data = $user->getCoursesByDept([$_SESSION['dept']]);
                                                if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['course_id'].'">'.$d['course_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="div">Select Division</label>
                                            <select class="form-control" name="div" id="div_s">
                                                <?php 
                                                    $data = $user->getAllDivision();
                                                    if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                    foreach($data as $d){
                                                        echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="batch">Select Batches</label>
                                            <select class="form-control selectpicker " name="batches[]" id="batch_s" multiple data-live-search="true">
                                                <?php 
                                                    $data = $user->getBatch();
                                                    if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                    foreach($data as $d){
                                                        echo '<option value="'.$d['batch_id'].'">'.$d['batch_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
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
        <table id="pract-class-table" class="table table-sm table-bordered table-hover cell-border nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th colspan="5">Practical</th>
                </tr>
                <tr>
                    <th>Class ID</th>
                    <th>Course Name</th>
                    <th>Faculty</th>
                    <th>Class</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getClassByDept([$_SESSION['dept']]);
                    if(!$data) echo "<tr><td>Nothing Found</td</tr>";
                    foreach($data as $d){
                        echo '<tr>
                                <td>'.$d['class_id'].'</td>
                                <td>'.$d['course_name'].'</td>
                                <td>'.$d['first_name'].' '.$d['last_name'].'</td>
                                <td>'.$d['s_class_name'].'</td>
                                <td>
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'.$d['class_id'].'">Delete</button>
                                </td>        
                            </tr>';
                    }
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>