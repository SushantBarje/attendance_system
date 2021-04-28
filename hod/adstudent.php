<?php
    namespace app\hod;
    require_once __DIR__ . '\..\vendor\autoload.php';
    session_start();
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) && !isset($_SESSION['faculty_id']) && !$_SESSION['role_id'] == 2){
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
    <script src="../assets/js/hod/script.js"></script>
    <title>Add Students</title>
</head>

<body>
<?php   include "hodHeader.php" ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addModal">
                    Add
                </button>
                <!-- The Modal -->
                <div class="modal" id="addModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add Students Details</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="add-student" class="modal-body">
                                    <label for="prn"><b>PRN NO</b></label>
                                    <input type="text" placeholder="Enter PRN" name="prn" required><br>
                                    <label for="fname"><b>First Name</b></label>
                                    <input type="text" placeholder="Fisrst Name" name="fname" required><br>
                                    <label for="mname"><b>Middle Name</b></label>
                                    <input type="text" placeholder="Middle Name" name="mname" required><br>
                                    <label for="lname"><b>Last Name</b></label>
                                    <input type="text" placeholder="Last Name" name="lname" required><br>
                                    <label for="roll_no"><b>Roll No.</b></label>
                                    <input type="text" placeholder="Roll No" name="roll_no" required><br>
                                    <label for="class-year"><b>Class</b></label>
                                    <select name="class_year" id="class_year">
                                        <option value=" "> </option>
                                        <?php 
                                            $data = $user->getClassYear();
                                            foreach($data as $d){
                                                echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="s_sem"><b>Semester</b></label>
                                    <select name="s_sem" id="s_sem" disabled>
                                        <option value=" ">Select Year</option>
                                    </select>
                                    <br>
                                    <label for="s_dept"><b>Department</b></label>
                                    <select name="s_dept" id="s_dept">
                                        <option value=" "> </option>
                                    <?php 
                                            $data = $user->getDepartment();
                                            foreach($data as $d){
                                                echo '<option value="'.$d['dept_id'].'">'.$d['dept_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <br>
                                    <label for="s_div"><b>Division</b></label>
                                    <select name="s_div" id="s_div">
                                        <?php 
                                         $data = $user->getAllDivision();
                                         foreach($data as $d){
                                             echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
                                         }
                                        ?>
                                    </select>
                                    <br>
                                    <label for="dept"><b>Batch</b></label>
                                    <select name="dept" id="dept" form="dept">
                                    <?php 
                                        $data = $user->getBatch();
                                        foreach($data as $d){
                                            echo '<option value="'.$d['batch_id'].'">'.$d['batch_name'].'</option>';
                                        }
                                    ?>
                                    </select>

                                    <!-- <label for="deptName"><b>Department Name</b></label>
                                    <input type="text" placeholder="Department name" name="Department" required> -->


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

        <table class="">
            <tr border="4px">
                <th>PRN</th>
                <th>Name</th>
                <th>Roll NO</th>
                <th>Class </th>
                <th>Div</th>
                <th>Batch</th>
                <th>Edit</th>
            </tr>
            <?php 
                $data = $user->getAllStudent();
            ?>
        </table>
    </main>

</body>

</html>