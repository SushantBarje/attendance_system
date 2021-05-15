<?php
    namespace app\admin;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 0){
        header('Location:../index.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Add Department</title>
</head>
<body>
    <?php include "adminHeader.php"; ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addAcdModal">
                    Add Academic Year
                </button>
                <!-- The Modal -->
                <div class="modal" id="addAcdModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add Academic Year</h2>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="academic-form" method="POST">
                                    <div class="form-group">
                                        <label for="acd_year">Academic Year</label>
                                        <input type="text" class="form-control" placeholder="e.g. 2020-2021" name="academic_year" required>
                                    </div>
                                     
                                    <div class="modal-footer">
                                        <button type="submit" form="academic-form" class="btn btn-success">ADD</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </form> 
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="acad-table" class="table table-bordered table-hover">
            <thead>
                <tr border="4px">
                    <th>Academic Year</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getAcademicYear();
                    if(!$data){
                        echo "<tr><td colspan='2'>Nothing Found</td></tr>";
                    }
                    foreach($data as $d){
                        echo '<tr><td>'.$d['academic_descr'].'</td><td><button type="button" class="btn btn-danger" id="del-btn" data-control="'.$d['acedemic_id'].'">Delete</button></td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </main>
    <script src="../assets/js/admin/script.js"></script>
</body>
</html>