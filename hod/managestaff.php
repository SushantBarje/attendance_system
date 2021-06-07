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
    <!-- <link rel="stylesheet" href="../CSS/tables.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <script src="../assets/js/hod/script.js"></script>
    <title>Add Hod</title>
</head>
<body>
    <?php include 'hodHeader.php'; ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addStaffModal">
                    Add Staff
                </button>
                <!-- The Modal -->
                <div class="modal" id="addStaffModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add Staff</h2>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="add-staff">
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
                                    <label for="password"><b>Password</b></label>
                                    <input type="password" class="form-control form-control-sm" placeholder="Enter Password" name="password" required>

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
        <table id="staff-table"  class="table table-sm table-bordered table-hover cell-border nowrap" cellspacing="0" width="100%">
            <thead>
                <tr border="4px">
                    <th>Faculty ID</th>
                    <th>Name </th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $data = $user->getFacultyByDept([$_SESSION['dept']]);
                    foreach($data as $d){
                        echo '<tr>
                                <td class="faculty-id">'.$d['faculty_id'].'</td>
                                <td class="faculty-name">'.$d['last_name'].' '.$d['first_name'].'</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'.$d['faculty_id'].'" data-toggle="modal" data-target="#editStaffModal"><span> <i class="fas fa-edit"></i></span> Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'.$d['faculty_id'].'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>
                                </td>
                            </tr>';
                    }
                ?>
            </tbody>
        </table>
        <div class="modal" id="editStaffModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h2>Edit Department</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="edit-staff-form"  enctype="multipart/form-data">
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