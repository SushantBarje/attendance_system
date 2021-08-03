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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript"  src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../assets/TableExport/TableExport-master/src/stable/css/tableexport.min.css">
    <style> 
        th, td { white-space: nowrap;}
    </style>
    
</head>
<body>
<?php
    include "adminHeader.php"; 
?>  
<main style="background-color:white">
    <h2 class="head">Practical Report</h2>
    <div class="container">
        <div class="row  mt-3">
            <div class="col-sm-12">
                <form id="report-pract" method="post">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="acd-year">Academic Year</label>
                            <select class="form-control form-control-sm report-select-input-report" name="academic_year" id="select-acd-report">
                                <option value=""></option>
                                <?php 
                                    $data = $user->getAcademicYear();
                                    foreach($data as $d){
                                        echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="select-dept">Select Department</label>
                            <select class="form-control form-control-sm report-select-input-report" name="dept" id="select-dept-report">
                                <option value=""></option>
                                <?php 
                                    $data = $user->getDepartment();
                                    if(!$data) echo '<option value="">Nothing Found</option>';
                                    foreach($data as $d){
                                        echo '<option value="'.$d['dept_id'].'">'.$d['dept_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="select-year">Select Year</label>
                            <select class="form-control form-control-sm report-select-input-report" name="year" id="select-year-report" disabled>
                                <option value=""></option>
                                
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="select-div">Select Semester</label>
                            <select class="form-control form-control-sm report-select-input-report" name="sem" id="select-sem-report" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="select-div">Select Division</label>
                            <select class="form-control form-control-sm report-select-input-report" name="div_id" id="select-div-report" disabled>
                                <option value=""></option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-group col-sm-3">
                            <label for="select-div">Select Class</label>
                            <select class="form-control form-control-sm" name="class" id="select-class-report" disabled>
                                <option value=""></option> 
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="from-date">Start Date</label>
                            <input type="date" class="form-control form-control-sm" name="from-date" id="from-date">
                        </div>
                        <div class="col-sm-3">
                            <label for="till-date">End Date</label>
                            <input type="date" class="form-control form-control-sm" name="till-date" id="till-date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col offset-5">
                            <button class="btn btn-success mt-4" id="get-report" type="submit">Check</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <div class="row mt-3">
        <div class="col-sm-6">
            <div id="faculty_header"></div>
        </div>
        <div class="col-sm-6" style="text-align: end;">
            <div id="lecture_header"></div>
        </div>
    </div>
    <div class="report-tables">
        
    </div>
    <button type="button" class="btn btn-success" id="export">Print</button>
    <div id="tableWrap">
        <table id="hod-report-adv" class="table cell-border stripe row-border order-column" style="width:100%">
            <thead>
            </thead>   
            <tbody>
            </tbody>            
        </table>
    </div>
</main>

<!-- <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script> -->

<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="../assets/blob.js/Blob.js-master/Blob.js"></script>
<script src="../assets/sheetjs/sheetjs-master/dist/xlsx.full.min.js"></script>
<script src="../assets/FileSaver/FileSaver.js-master/FileSaver.min.js"></script>
<script src="../assets/TableExport/TableExport-master/src/stable/js/tableexport.min.js"></script>
<script src="../assets/table2excel/jquery-table2excel-master/dist/jquery.table2excel.min.js"></script>
<script src="../assets/js/admin/script.js"></script>

</body>

</html>
