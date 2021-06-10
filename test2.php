<?php
    namespace app;
    require_once __DIR__ . '\vendor\autoload.php';
    use app\controller\StudentController;
    use \PDO;
    use \PDOException;
    $user = new StudentController();
    // if(!isset($_SESSION['prn_no'])){
    //     header('Location:../index.php');
    // }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
    <table class="table table-bordered" style="vertical-align : middle;text-align:center;">
        <thead>
            <tr style="vertical-align : middle;text-align:center;">
                <th style="vertical-align : middle;text-align:center;" rowspan="2"> Name of Subject</th>
                <!-- LOOP-->
                <th style="vertical-align : middle;text-align:center;" rowspan="2">01/01/2021</th>
                <th style="vertical-align : middle;text-align:center;"  rowspan="2">01/01/2021</th>
                <th style="vertical-align : middle;text-align:center;" rowspan="2">01/01/2021</th>
                <th style="vertical-align : middle;text-align:center;" rowspan="2">01/01/2021</th>
                <!-- LOOP-->
                <th colspan="2">
                    Total
                </th>
            </tr>
            <tr>
                <th>Total</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>STP-6</b></td>
                <td>A</td>
                <td>P</td>
                <td>P</td>
                <td>A</td>
                <td>2</td>
                <td>50.00%</td>
            </tr>
            <tr>
                <td><b>UOS</b></td>
                <td>A</td>
                <td>P</td>
                <td>P</td>
                <td>A</td>
                <td>2</td>
                <td>50.00%</td>
            </tr>
            <tr>
                <td><b>Android</b></td>
                <td>A</td>
                <td>P</td>
                <td>P</td>
                <td>A</td>
                <td>2</td>
                <td>50.00%</td>
            </tr>
        </tbody>
    </table>
</body>
</html>