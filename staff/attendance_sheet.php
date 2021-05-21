<?php
    namespace app\staff;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 2){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php'); 
    }
    $_SESSION['class'] = isset($_GET['class']) ? $user->verifyInput($_GET['class']) : '';
    if(empty($_SESSION['class'])) {
        echo '<script> 
                alert("Failed to load attendance list");
                location.href = "markattendence.php";
            </script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets//js//staff/script.js"></script>
    <title>Document</title>
</head>
<body>
   <?php 
        
        include "staffHeader.php";
        
   ?> 

   <main>
        <div class="d-flex flex-wrap bg-light align-items-center">
            <div id="container">
                <form id="attend">
                    <div id="attend-class">
                        <?php 
                                $data = $user->selectStudentByDeptAndClassForAttend([(int)$_SESSION['dept'],(int)$_SESSION['class']]); 
                                if(!$data){
                                    echo '<script> 
                                            alert("Failed to load attendance list");
                                            location.href = "markattendence.php";
                                        </script>';
                                }
                                foreach($data as $d){
                                    echo '<div class="row" id="box" style=" margin: 10px; width: 100px">
                                            <span class="col-sm-6">'.$d['roll_no'].'</span>
                                            <a class="att btn btn-success col-sm-6" data-id="'.$d['roll_no'].'" data-control="1">P</a>
                                        </div>';
                                }        
                            ?>
                        <button type="submit">Submit</button>
                    </div>
                </form> 
            </div>
        </div>
   </main>
</body>
</html>


