<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <title>View Students</title>
</head>

<body>
<?php   include "staffHeader.php" ?>
    <main>
    <table id="student-table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
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
                <!-- <tfoot>
                    <tr border="4px">
                        <th></th>
                        <th>PRN</th>
                        <th>Name</th>
                        <th>Roll no</th>
                        <th>Class </th>
                        <th>Department</th>
                        <th>Div</th>
                        <th>Batch</th>
                        <th>Edit</th>
                    </tr>
                </tfoot> -->
                
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
    </main>
    <script>
        $("#student-table").DataTable({})
    </script>
</body>
</html>