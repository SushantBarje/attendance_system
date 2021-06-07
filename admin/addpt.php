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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <script src="../assets/js/admin/script.js"></script>
    <title>Add Department</title>
</head>
<body>
    <?php include "adminHeader.php";?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                   + Add Departments
                </button>
                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add Departments</h2>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="dpt-form" class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="fname"><b>Department Name</b></label>
                                            <input type="text" id="dptname" class="form-control form-control-sm" placeholder="Department Name" name="dptname">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="year_s">Select Year</label>
                                            <select class="form-control selectpicker " name="year[]" id="year_s" multiple data-live-search="true">
                                                <?php 
                                                    $data = $user->getClassYear();
                                                    if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                    foreach($data as $d){
                                                        echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="div_s">Select Divisions</label>
                                            <select class="form-control selectpicker " name="div[]" id="div_s" multiple data-live-search="true">
                                                <?php 
                                                    $data = $user->getAllDivision();
                                                    if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                                                    foreach($data as $d){
                                                        echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
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
        <table class="table table-sm table-bordered table-hover cell-border nowrap" cellspacing="0" width="100%" id="dept-table">
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getDepartment();
                    if(!$data) die("<tr><td colspan='2'>Nothing Found</td></tr>");
                    foreach($data as $d){
                        echo '<tr>
                                <td class="dept-name">'.$d['dept_name'].'</td>
                                <td>
                                    <button type="button" class="btn btn-primary mr-1" id="edit-btn" data-control="'.$d['dept_id'].'" data-toggle="modal" data-target="#editModal">Edit</button>
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'.$d['dept_id'].'">Delete</button>
                                </td>
                            </tr>';
                    }
                ?>
            </tbody>
        </table>
        <div class="modal" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h2>Edit Department</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="edit-dept" class="modal-body">
                            <label for="fname"><b>Department Name</b></label>
                            <input type="text" id="modalinput" placeholder="Department Name" name="editdptname">
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
    </main>
</body>

</html>