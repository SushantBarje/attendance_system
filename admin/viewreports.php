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
</head>
<script>
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

</script>
<body>

<?php
    include "adminHeader.php"; 
?>  
<main style="background-color:white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="acd-year">Academic Year</label>
                            <select class="form-control" name="academic_year" id="acd-year">
                                <option value=" "> </option>
                                <?php 
                                    $data = $user->getAcademicYear();
                                    if(!$data) echo '<option value=" ">Nothing Found</option>';
                                    foreach($data as $d){
                                        echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="acd-year">Select Department</label>
                            <select class="form-control" name="deptartment" id="dept" disabled>
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
                        <div class="form-group col-sm-3">
                            <label for="acd-year">Select Class</label>
                            <select class="form-control" name="classyear" id="class-year" disabled>
                                <option value=" "> </option>
                                <?php 
                                    $data = $user->getClassYear();
                                    if(!$data) echo '<option value=" ">Nothing Found</option>';
                                    foreach($data as $d){
                                        echo '<option value="'.$d['s_class_id'].'">'.$d['s_class_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-sm-12 ">
                <button class="btn btn-success">
                    <i class="bi bi-printer-fill "></i> Generate Report
                </button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-12">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
        </div>
    </div> 
</main>

<!-- <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script> -->
<script src="../assets/js/admin/script.js"></script>
<script src="../assets/js/jquery.canvasjs.min.js"></script>
</body>

</html>
