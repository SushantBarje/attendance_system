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
    <title>Add Department</title>
</head>

<body>

    <?php
    include "adminHeader.php";
    //  include('titlehead.php'); 

    ?>

    <main>

        <div class="cards">
            <div class="container">

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                    Add Departments
                </button>

                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add Departments</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="#" class="modal-body">


                                    <label for="fname"><b>Department Name</b></label>
                                    <input type="text" placeholder="Department Name" name="dptname" required>

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
                <th>Department Name</th>

                <th>Edit</th>


            </tr>
            <tr>
                <td>Computer Science And Engineering</td>

            </tr>
            <tr>
                <td>Electrical Engineering</td>

            </tr>
            <td>Civil Engineering</td>
            </tr>

            </tr>
            <td>Electronic And Telecumminication Engineering</td>
            </tr>
            </tr>
            <td>Mechanical Engineering</td>
            </tr>
        </table>


    </main>

</body>

</html>