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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
</head>
<!-- <script>
    var options = {
            animationEnabled: true,
            
            title:{
                text: "Academic Record" ,
                fontFamily: "tahoma",  
            },
            axisY:{
                title:"Total number of Students"
            },
            toolTip: {
                shared: true,
                reversed: true
            },
            data: [{
                type: "stackedColumn",
                name: "Present",
                showInLegend: "true",
                yValueFormatString: "0",
                dataPoints: [
                    { y: 50 , label: "CSE" },
                    { y: 1, label: "Mech" },
                    { y: 1, label: "ENTC" },
                ]
            },
            {
                type: "stackedColumn",
                name: "Absent",
                showInLegend: "true",
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                yValueFormatString: "0",
                dataPoints: [
                    { y: 13, label: "CSE" },
                    { y: 1, label: "Mech" },
                    { y: 1, label: "ENTC" },
                    
                ]
            }]
        };
        
        $("#chartContainer").CanvasJSChart(options);

</script> -->
<body>

<?php
    include "adminHeader.php"; 
?>  
<main style="background-color:white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form id="report">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="acd-year">Academic Year</label>
                            <select class="form-control form-control-sm report-select-input" name="academic_year" id="select-acd">
                                <option value=" "> </option>
                                <?php 
                                    $data = $user->getAcademicYear();
                                    foreach($data as $d){
                                        echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="select-dept">Select Department</label>
                            <select class="form-control form-control-sm report-select-input" name="dept" id="select-dept">
                                <option value=" "> </option>
                                <?php 
                                    $data = $user->getDepartment();
                                    if(!$data) echo '<option value=" ">Nothing Found</option>';
                                    foreach($data as $d){
                                        echo '<option value="'.$d['dept_id'].'">'.$d['dept_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="select-year">Select Year</label>
                            <select class="form-control form-control-sm report-select-input" name="year" id="select-year" disabled>
                                <option value=" "> </option>
                                
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="select-div">Select Division</label>
                            <select class="form-control form-control-sm report-select-input" name="div" id="select-div" disabled>
                                <option value=" "> </option>
                                
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="select-div">Select Class</label>
                            <select class="form-control form-control-sm" name="class" id="select-class" disabled>
                                <option value=" "> </option> 
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label for="from-date">Start Date</label>
                            <input type="date" class="form-control form-control-sm" name="from-date" id="from-date">
                        </div>
                        <div class="col-sm-6">
                            <label for="till-date">End Date</label>
                            <input type="date" class="form-control form-control-sm" name="till-date" id="till-date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col offset-5">
                            <button class="btn btn-success mt-2" id="get-report" type="button">Check</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <table id="admin-report" class="stripe row-border order-column" style="width:100%">
        <thead>
            <tr>
            </tr>
        </thead>
        <tbody>
        
        </tbody>
    </table>
</main>

<!-- <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="../assets/js/admin/script.js"></script>
<script src="../assets/js/jquery.canvasjs.min.js"></script>

</body>

</html>
