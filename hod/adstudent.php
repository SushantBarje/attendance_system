<?php
    namespace app\hod;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 1){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }
    if(isset($_REQUEST['upload'])){
        $result = $user->saveBulkStudent();
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <!-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css" rel="stylesheet"/>
    <script src="//cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
    <link href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet"/>  
    <script src="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>  --> 
    <title>Add Students</title>
    
    <script src="../assets/js/hod/script.js"></script>
</head>

<body>
<?php   include "hodHeader.php" ?>
    <main>
        <div class="cards">
            <div class="container">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addModal">Add</button>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#bulkUploadModal">Upload File</button>

                <div class="modal fade" id="bulkUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="add-bulk-student" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="class" class="mr-sm-2">Class</label>
                                        <select class="form-control form-control-sm" name="class" id="class">
                                            <option value=" "> </option>
                                            <?php
                                                $data = $user->getClassYear();
                                                if(!$data) echo '<option value=" "> </option>';
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fileupload">Upload File</label>
                                        <input type="file" name="file" class="form-control-file border" id="fileupload" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                    </div> 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="upload" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                    <div class="form-group">
                                        <label for="prn"><b>PRN NO</b></label>
                                        <input type="text" placeholder="Enter PRN" name="prn" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label for="fname"><b>First Name</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Fisrst Name" name="fname" required>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="mname"><b>Middle Name</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Middle Name" name="mname" required>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="lname"><b>Last Name</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Last Name" name="lname" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-5">
                                            <label for="roll_no"><b>Roll No.</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Roll No" name="roll_no" required>
                                        </div>
                                        <div class="form-group col-sm-7">
                                            <label for="class-year"><b>Class</b></label>
                                            <select name="class_year" class="form-control form-control-sm" id="class_year">
                                                <option value=" "> </option>
                                                <?php 
                                                    $data = $user->getClassYear();
                                                    foreach($data as $d){
                                                        echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-6">
                                            <label for="s_div"><b>Division</b></label>
                                            <select name="s_div" class="form-control form-control-sm" id="s_div">
                                                <?php 
                                                $data = $user->getAllDivision();
                                                foreach($data as $d){
                                                    echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="s_batch"><b>Batch</b></label>
                                            <select name="s_batch" class="form-control form-control-sm" id="s_batch" >
                                            <?php 
                                                $data = $user->getBatch();
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="student-table" class="table table-sm table-bordered table-hover cell-border nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr border="4px">
                        <th>PRN</th>
                        <th>Name</th>
                        <th>Roll no</th>
                        <th>Class </th>
                        <th>Department</th>
                        <th>Div</th>
                        <th>Batch</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $data = $user->getStudentByDept([$_SESSION['dept']]);
                        foreach($data as $d){
                            echo '<tr>
                                    <td class="edit-prn">'.$d['prn_no'].'</td>
                                    <td class="edit-name">'.$d['last_name'].' '.$d['first_name'].' '.$d['middle_name'].'</td>
                                    <td class="edit-roll">'.$d['roll_no'].'</td>
                                    <td class="edit-year" id="'.$d['year_id'].'">'.$d['s_class_name'].'</td>
                                    <td class="edit-dept" id="'.$d['dept_id'].'">'.$d['dept_name'].'</td>
                                    <td class="edit-div" id="'.$d['div_id'].'">'.$d['div_name'].'</td>
                                    <td class="edit-batch" id="'.$d['batch_id'].'">'.$d['batch_name'].'</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" id="edit-btn" data-control="'.$d['prn_no'].'" data-toggle="modal" data-target="#editStudentModal"><span> <i class="fas fa-edit"></i></span> Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'.$d['prn_no'].'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>
                                    </td>        
                                </tr>';
                        }                           
                    ?>
                </tbody>   
            </table>
        </div> 

        <div class="modal" id="editStudentModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h2>Edit Students Details</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="edit-student" class="modal-body">
                            <div class="form-group">
                                <label for="prn-no"><b>PRN NO</b></label>
                                <input type="text" placeholder="Enter PRN" id="prn-no" name="prn" class="form-control form-control-sm prn-no" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="fname"><b>First Name</b></label>
                                    <input type="text" class="form-control form-control-sm fname" id="fname" placeholder="Fisrst Name" name="fname" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="mname"><b>Middle Name</b></label>
                                    <input type="text" class="form-control form-control-sm mname" id="mname" placeholder="Middle Name" name="mname" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="lname"><b>Last Name</b></label>
                                    <input type="text" class="form-control form-control-sm lname" id="lname" placeholder="Last Name" name="lname" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-5">
                                    <label for="roll_no"><b>Roll No.</b></label>
                                    <input type="text" class="form-control form-control-sm roll" id="roll" placeholder="Roll No" name="roll_no" required>
                                </div>
                                <div class="form-group col-sm-7">
                                    <label for="year"><b>Class</b></label>
                                    <select name="class_year" class="form-control form-control-sm year" id="year">
                                        <option value=" "> </option>
                                        <?php 
                                            $data = $user->getClassYear();
                                            foreach($data as $d){
                                                echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="s_div"><b>Division</b></label>
                                    <select name="s_div" class="form-control form-control-sm div" id="div">
                                        <?php 
                                        $data = $user->getAllDivision();
                                        foreach($data as $d){
                                            echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="s_batch"><b>Batch</b></label>
                                    <select name="s_batch" class="form-control form-control-sm batch" id="batch" >
                                    <?php 
                                        $data = $user->getBatch();
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>