<?php
    require_once __DIR__ . '\vendor\autoload.php';
    session_start();
    use app\controller\FacultyController;
    use app\controller\StudentController;
    $err = [];
    if(isset($_REQUEST['btn-login'])){
      $user = new FacultyController();
        $user->userLogin();
    }
    if(isset($_REQUEST['student-login'])){
      $student = new StudentController();
      $err = $student->studentLogin();
      echo '<script>alert("'.$err["invalid"].'")</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>skn online attendence</title>
	<link rel="stylesheet" href="style.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>     
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link">SKN Sinhgad College Of Engineering Korti,Pandharpur</a>
    </li>
  </ul>
</nav>
<header>
  <h1>Online Attendance System </h1>
</header>
</br></br>
<div class="back">
  <div class="div-center">
    <div class="content">
      <h3>Student Login</h3>
      <hr />
      <form class="justify-content-center" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Student Username</label>
          <input type="text" class="form-control" id="exampleInputusername" name="prn_no" placeholder="Enter Your PRN " >
        </div>
        <button type="submit" name ="student-login" class="btn btn-primary">Login</button>
      </form>
    </div>
    </span>
  </div>
</body>
