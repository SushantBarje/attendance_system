<?php
    namespace app;
    require_once __DIR__ . '\vendor\autoload.php';
    require_once __DIR__.'\links\links.php';
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
    <?php
        OfflineStylesFiles();
    ?>
</head>
<body>
    <button class="btn btn-primary">Submit</button>
    
    <table id="tables">
        <thead>
            <tr>
                <th>Name</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <td>Hi</td>
            <td>HI</td>
        </tbody>
    </table>
    <?php 
        OffileJsFiles();
    ?>
    <script>
        $("#tables").DataTable({});
    </script>
</body>
</html>