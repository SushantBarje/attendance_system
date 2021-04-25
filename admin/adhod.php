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
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Add Hod</title>
</head>
<body>
    <?php include 'adminHeader.php'; ?>
    <main>
        <div class="cards">
            <div class="container">

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                    Add HOD
                </button>

                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add HOD</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="#" class="modal-body">
                                    
                                    <label for="fname"><b>First Name</b></label>
                                    <input type="text" placeholder="Fisrst Name" name="fname" required><br>
                                    <label for="mname"><b>Middle Name</b></label>
                                    <input type="text" placeholder="Middle Name" name="mname" required><br>
                                    <label for="lname"><b>Last Name</b></label>
                                    <input type="text" placeholder="Last Name" name="lname" required><br>
                                    
                                    <label for="dept"><b>Department</b></label>
                                    <select name="dept" id="dept" form="dept">
                                        <option value="na">NA</option>
                                        <option value="cse">CSE</option>
                                        <option value="entc">EN & TC</option>
                                        <option value="civil">CIVIL</option>
                                        <option value="mechanical">MECHANICAL</option>
                                        <option value="electrical">ELECTRIACL</option>
                                    </select>
                                    <br>
                                    <!-- <label for="deptName"><b>Department Name</b></label>
                                    <input type="text" placeholder="Department name" name="Department" required> -->
                                    <label for="password"><b>Password</b></label>
                                    <input type="password" placeholder="Enter Password" name="password" required>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">

                                        <button type="submit" class="btn btn-success">ADD</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    <!-- <button type="button" class="btn cancel" onclick="closeForm()">Close</button> -->
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <table class="">
            <tr border="4px">
                <th>First Name </th>
                <th>Middlle Name </th>
                <th>Last Name </th>
                <th>Department Name </th>
                <th>Password </th>
                <th>Edit</th>
            </tr>
            <tr>
                <td>Prakash </td>
                <td>Vitthal</td>
                <td>Gadeker</td>
                <td>Computer Science & Engineering</td>
                <td>Prakash@123</td>
            </tr> 
        </table>
    </main>
</body>
</html>