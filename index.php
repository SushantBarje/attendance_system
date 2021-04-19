<!DOCTYPE html>
<html>
<head>
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

      <form class="justify-content-center">
        <div class="form-group">
		
          <label for="exampleInputEmail1">Student Username</label>
          <input type="username" class="form-control" id="exampleInputusername" placeholder="Enter Your PRN " >
        </div>
        
        
        <button type="submit" class="btn btn-primary">Login</button>
   
        

      </form>

    </div>


    </span>
  </div>
</body>
<?php
    require_once __DIR__ . '\vendor\autoload.php';
    session_start();
    use app\controller\FacultyController;
    $user = new FacultyController();
    if(isset($_REQUEST['btn-login'])){
        $user->userLogin();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="password">
        <input type="submit" name="btn-login" value="Login">  
    </form>
</body>
</html>
