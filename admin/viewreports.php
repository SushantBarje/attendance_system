<?php
    namespace app\admin;
    require_once __DIR__ . '\..\vendor\autoload.php';
    session_start();
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(!isset($_SESSION['role_id']) && !isset($_SESSION['faculty_id']) && !$_SESSION['role_id'] == 1){
        header('Location:../index.php');
    }
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../CSS/AddDept.css">

</head>
<body>

<?php
           include "adminHeader.php";
          //  include('titlehead.php'); 
        
    ?>  

         

<main>

</main>
</body>

</html>
