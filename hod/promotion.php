<?php
    namespace app\admin;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 1){
        header('Location:../index.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <title>Add Department</title>

    <style>
        .from_class{
            /* display: flex;
            align-items:center;
            justify-content: center; */
            text-align:center;
            margin: 50px;
        }

        .button-box{
            margin:50px;
        }

        .promote-btn {
            width: 500px;
            height: 100px;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <?php include "hodHeader.php"; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="from_class">
                            <?php
                                $data = $user->getClassYear();
                                if(!$data){
                                    echo '<h5>No Class Found!</h5>';
                                }else{
                                    for($i = 1; $i < count($data); $i++){
                                        echo '<div class="button-box"><button class="btn btn-success btn-lg promote-btn" aria-pressed="false" data-prev-id="'.$data[$i-1]['s_class_id'].'" data-id="'.$data[$i]['s_class_id'].'">'.$data[$i-1]['s_class_name'].' to '.$data[$i]['s_class_name'].'</button></div>';
                                    } 
                                    echo '<div class="button-box"><button class="btn btn-success btn-lg promote-btn" aria-pressed="false" data-prev-id="'.$data[$i-1]['s_class_id'].'" data-id="5">Promote '.$data[$i-1]['s_class_name'].'</button></div>';
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../assets/js/admin/script.js"></script>
</body>
</html>