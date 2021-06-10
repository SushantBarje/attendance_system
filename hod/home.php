<?php
    namespace app\hod;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) || !isset($_SESSION['faculty_id']) || $_SESSION['role_id'] != 1){
        echo '<script> alert("Invalid User")</script>';
        header('Location:../index.php');
    }
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <script defer src="../assets/fontawesome/js/brands.js"></script>
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <script src="../assets/js/hod/script.js"></script>
    <title>Manage Classes</title>
</head>

<body>

<body>
<?php   include "hodHeader.php" ?>
    <main>
    
    </main>
</body>

</html>