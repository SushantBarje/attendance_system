<?php
    namespace app\hod;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 1){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }
    $dept_name = $user->getDepartmentById([isset($_SESSION['dept']) ? $_SESSION['dept'] : '']);
    echo '<script> var dept_name = "'.$dept_name[0]['dept_name'].'"</script>';
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script type="text/javascript"  src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" />
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
<script src="../assets/blob.js/Blob.js-master/Blob.js"></script>
<script src="../assets/sheetjs/sheetjs-master/dist/xlsx.core.min.js"></script>
<script src="../assets/FileSaver/FileSaver.js-master/FileSaver.min.js"></script>
<script src="../assets/TableExport/TableExport-master/src/stable/js/tableexport.min.js"></script>
<script src="../assets/table2excel/jquery-table2excel-master/dist/jquery.table2excel.min.js"></script>
<script src="../assets/js/hod/script.js"></script>

<!-- <script>
    // $(document).ready(function() {
    //     var table = $('#example').DataTable( {
    //         scrollY:        "300px",
    //         scrollX:        true,
    //         scrollCollapse: true,
    //         paging:         false,
    //         fixedColumns:   {
    //             leftColumns: 1,
    //             rightColumns: 1
    //         }
    //     });
    // });
</script> -->

<style> 
    th, td { white-space: nowrap;}
</style>
</head>
<body>
<script>start_load();</script>
<?php   include "hodHeader.php" ?>
<main>
 
    <h2 class="head">Practical Report</h2>
    <form id="report-pract">
        <div class="row mt-3">
            <div class="form-group col-sm-2">
                <label for="acd-year">Academic Year</label>
                <select class="form-control form-control-sm report-select-input" name="academic_year" id="select-acd">
                    <option value=""></option>
                    <?php 
                        $data = $user->getAcademicYear();
                        if(!$data) echo '<option value=">Nothing Found</option>';
                        foreach($data as $d){
                            echo '<option value="'.$d['acedemic_id'].'">'.$d['academic_descr'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="select-year" class="mr-sm-2">Year: </label>
                <select id="select-year" name="year" class="form-control form-control-sm mr-3 report-select-input"> 
                    <option value=""></option>
                    <?php 
                        $data = $user->getYearBelongsDept([$_SESSION['dept']]);
                        if(!$data) echo '<option value="">Nothing Found</option>';
                        foreach($data as $d){
                            echo '<option value="'.$d['year_id'].'" >'.$d['s_class_name'].'</option>';
                        }
                    ?>  
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label for="select-class">Select Semester :</label>
                <select class="form-control form-control-sm report-select-input" name="sem" id="s_sem" disabled>
                    <option value=""></option>
                </select>
            </div>  
            <div class="form-group col-sm-2">
                <label for="select-div">Select Division :</label>
                <select class="form-control form-control-sm report-select-input" name="div_id" id="select-div">
                    <option value=""></option>
                    <?php 
                        $data = $user->getDivBelongsDept([$_SESSION['dept']]);
                        if(!$data) echo '<option value="'.' '.'">Nothing Found</option>';
                        foreach($data as $d){
                            echo '<option value="'.$d['div_id'].'">'.$d['div_name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="select-class">Select Class :</label>
                <select class="form-control form-control-sm" name="class" id="select-class" disabled>
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="row">
            <?php date_default_timezone_set("Asia/Kolkata");?>
            <div class="form-group col-sm-4">
                <label for="from-date">FROM :</label>
                <input class="form-control form-control-sm" type="date" max="<?php echo date("Y-m-d") ?>" name="from-date" id="from-date">
            </div>
            <div class="form-group col-sm-4">
                <label for="till-date">Till :</label>
                <input class="form-control form-control-sm" type="date" max="<?php echo date("Y-m-d") ?>" name="till-date" id="till-date">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 offset-sm-5 offset-xs-4">
                <button class="btn btn-success mt-4" id="get-report" type="submit">Check</button>
            </div>
        </div>
    </form>

    <div class="report-tables">
        
    </div>
    <button type="button" class="btn btn-success" id="export">Print</button hidden>
        <div id="tableWrap">
            <table id="hod-report-adv" class="table cell-border stripe row-border order-column" style="width:100%">
                <thead>
                </thead>   
                <tbody>
                </tbody>            
            </table>
        </div>
</main>
<script>end_load();</script>
</body>
</html>