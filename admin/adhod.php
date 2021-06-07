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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <script src="../assets/js/admin/script.js"></script>
    <title>Add Hod</title>
</head>
<body>
    <?php include 'adminHeader.php'; ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                    Add HOD
                </button>
                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add HOD</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="add-hod">
                                    <div class="form-group">
                                        <label for="faculty_id"><b>Faculty ID</b></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Faculty ID" name="faculty_id" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-6">
                                            <label for="fname"><b>First Name</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Fisrst Name" name="fname" required>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="lname"><b>Last Name</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Last Name" name="lname" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="dept"><b>Department</b></label>
                                        <select name="dept" class="form-control form-control-sm" id="dept">
                                            <?php 
                                                $data = $user->getDepartment();
                                                if(!$data) echo "<option>Department Not Available</option>";
                                                else{
                                                    foreach($data as $d){
                                                        echo '<option value="'.$d['dept_id'].'">'.$d['dept_name'].'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><b>Password</b></label>
                                        <input type="password" class="form-control form-control-sm" placeholder="Enter Password" name="password" required>
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
        <table class="table-bordered table-hover cell-border nowrap" cellspacing="0" width="100%" id="hod-table">
            <thead>
                <tr border="4px">
                    <th>Faculty ID</th>
                    <th>Name </th>
                    <th>Department</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getFacultyByRole([1]);
                    foreach($data as $d){
                        echo '<tr>
                                <td class="faculty-id">'.$d['faculty_id'].'</td>
                                <td class="faculty-name">'.$d['last_name'].' '.$d['first_name'].'</td>
                                <td class="dept-name" id="'.$d['dept_id'].'">'.$d['dept_name'].'</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'.$d['faculty_id'].'" data-toggle="modal" data-target="#editHodModal"><span> <i class="fas fa-edit"></i></span> Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'.$d['faculty_id'].'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>
                                </td>
                            </tr>';
                    }
                ?>
            </tbody>
        </table>
        <div class="modal" id="editHodModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h2>Edit Department</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="edit-hod-form"  enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="faculty_id"><b>Faculty ID</b></label>
                                <input type="text" class="form-control form-control-sm" id="edit-faculty-id" placeholder="Faculty ID" name="faculty_id" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="fname"><b>First Name</b></label>
                                    <input type="text" class="form-control form-control-sm" id="edit-fname" placeholder="Fisrst Name" name="fname" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lname"><b>Last Name</b></label>
                                    <input type="text" class="form-control form-control-sm" id="edit-lname" placeholder="Last Name" name="lname" required>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="dept"><b>Department</b></label>
                                <select name="dept-id" class="form-control form-control-sm" id="edit-dept" form="dept">
                                    <option id="dept-select"></option>
                                    <?php 
                                        $data = $user->getDepartment();
                                        if(!$data) die("<option>Department Not Available</option>");
                                        foreach($data as $d){
                                            echo '<option value="'.$d['dept_id'].'">'.$d['dept_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <!-- <label for="password"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="password" required> -->
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save</button>
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