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
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                    Add Academic Year
                </button>
                <!-- The Modal -->
                <div class="modal" id="myModal">
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
                                    <input type="text" placeholder="Academic Year" name="acd" required> 
                                    <button type="submit" form="academic-form" class="btn btn-success">ADD</button>
                                </form> 
                                
                            </div>
                            <div class="modal-footer">
                                
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="acad-table">
            <tr border="4px">
                <th>Academic Year</th>
                <th>Edit</th>
            </tr>
            <?php 
                $data = $user->getAcademicYear();
                if(!$data){
                    echo "<tr><td colspan='2'>Nothing Found</td></tr>";
                }
                foreach($data as $d){
                    echo '<tr><td>'.$d['academic_descr'].'</td><td><button type="button" class="btn btn-primary">Edit</button><button class="btn btn-danger">Delete</button></td></tr>';
                }
            ?>
        </table>
    </main>
    <script src="../assets/js/admin/script.js"></script>
</body>
</html>