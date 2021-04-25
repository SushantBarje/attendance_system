<?php
    require_once __DIR__ . '\vendor\autoload.php';
    use app\controller\FacultyController;
    use app\controller\StudentController;
    session_start();
    $user = new FacultyController();
    $student = new StudentController;
    if(isset($_REQUEST['faculty-login'])){
        $err = $user->userLogin();
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
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-1"></div>
            <div class="col-sm-4">
                <div class="header">
                    <h3>Login</h3>
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
                    <button class="btn btn-primary" name="faculty-login" type="submit">Log In</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <div class="header">
                    <h3>Login</h3>
                </div>
                <form id="student-login">
                    <div class="form-group">
                        <label for="prn_no">PRN</label>
                        <div class="input-group mb-3 input-group-sm">
                            <input type="text" class="form-control" name="prn_no" placeholder="Enter PRN">
                        </div>
                    </div>
                    <button class="btn btn-primary" name="stundet-login" type="submit">Log In</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
</body>
</html>