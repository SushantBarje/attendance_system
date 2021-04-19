<?php

  session_start();
  use app\controller\StudentController;
?>

<!DOCTYPE html>
<html>
    <head>
    <title>skn online attendence</title>
	<link rel="stylesheet" href="../assests/css/student/style.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link">SKN Sinhgad College Of Engineering Korti,Pandharpur</a>
      <button type="submit" class="btn btn-primary">Logout</button>
    </li>
  </ul>
</nav>
<header>
</br>
  <h1>Student Panel </h1>
  <h2><?php echo $_SESSION['prn_no'] ?></h2>
</br></br>
  <div class="report">
  <a href="">Generate Report </a>
</div>
</br></br>
<div class="view">
  <a href="">View attendence </a>
</div>
</br></br>
</header>
</body>
</html>