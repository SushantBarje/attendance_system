<?php
    require_once __DIR__ . '\vendor\autoload.php';
    use app\controller\FacultyController;
    use app\controller\StudentController;
    $user = new FacultyController();
    $student = new StudentController();
    if(isset($_REQUEST['faculty-login'])){
        $err = $user->userLogin();
        if(isset($err["invalid"])) echo '<script> alert("'.$err['invalid'].'")</script>';
    }
    if(isset($_REQUEST['student-login'])){
        $err = $student->studentLogin();
        if(isset($err["invalid"])) echo '<script> alert("'.$err['invalid'].'")</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <div class="container-fluid" id="heading">
        <div class="row mb-5">
            <div class="col-sm-4"></div>
            <div class="col-sm-6">
                <h1>Online Attendance System</h1>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-4" id="faculty-section">
                <div class="header">
                    <h3>Faculty</h3>
                </div>
                <form method="post">
                    <div class="form-group">
                        <label for="faculty_id">Faculty ID</label>
                        <div class="input-group mb-3 input-group-sm">
                            <input type="text" class="form-control" name="faculty_id" placeholder="Faculty ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group mb-3 input-group-sm">
                            <input type="password" class="form-control" name="password" placeholder="Password" />
                        </div>
                    </div>
                    <button class="btn btn-primary" name="faculty-login" value="submit" type="submit">Log In</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-4" id="student-section">
                <div class="header">
                    <h3>Student</h3>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <label for="prn_no">PRN</label>
                        <div class="input-group mb-3 input-group-sm">
                            <input type="text" class="form-control" name="prn_no" placeholder="Enter PRN">
                        </div>
                    </div>
                    <button class="btn btn-primary" name="student-login" value="submit" type="submit">Log In</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>

    <!-- <form method="post">
        <input type="text" name="pwd">
        <button type="submit" name="log">Submit</button>
    </form> -->
</body>
</html>
<?php
    
?>