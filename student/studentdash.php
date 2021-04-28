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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashbord</title>
    <link rel="stylesheet" href="../CSS/style.css">

    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">

</head>

<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span><span>Student</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="index.html" class="active"><span class="fa fa-fw fa-home"></span>
                        <span>Home</span></a>
                </li>
                <!-- <li>
                    <a href=""><span class="las la-users"></span>
                        <span>Departments</span></a>
                </li> -->
                <li>
                    <a href=""><span class="las la-clipboard-list"></span>
                        <span>View Attendence</span></a>
                </li>
                <!-- <li>
                    <a href=""><span class="las la-shopping-bag"></span>
                        <span>Courses</span></a>
                </li>
                <li>
                    <a href=""><span class="las la-receipt"></span>
                        <span>Students</span></a>
                </li>
                -->
                <!-- <li>
                    <a href=""><span class="las la-user-circle"></span>
                        <span>Users</span></a>
                </li> -->
                <li>
                    <a href=""><span class="las la-clipboard-list"></span>
                        <span> Generate Reports</span></a>
                </li>
            </ul>
        </div>
    </div>


    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label class="label">
                 Student Dashboard
            </h2>
          
            <div class="user-wrapper">
                <img src="../img/2.jpg" width="30px" height="30px" alt="">
                <div>
                    <h4>vishal phule</h4>
                   <small>

                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];?></button>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="#"><i class="fa fa-fw fa-user"></i> Login</a>
                          <a href="#"><i class="fa fa-fw fa-user"></i>Logout</a>
                          <a href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
                        </div>
                   </small>


                        <script>
                            /* When the user clicks on the button, 
                            toggle between hiding and showing the dropdown content */
                            function myFunction() {
                              document.getElementById("myDropdown").classList.toggle("show");
                            }
                            
                            // Close the dropdown if the user clicks outside of it
                            window.onclick = function(event) {
                              if (!event.target.matches('.dropbtn')) {
                                var dropdowns = document.getElementsByClassName("dropdown-content");
                                var i;
                                for (i = 0; i < dropdowns.length; i++) {
                                  var openDropdown = dropdowns[i];
                                  if (openDropdown.classList.contains('show')) {
                                    openDropdown.classList.remove('show');
                                  }
                                }
                              }
                            }
                            </script>
                            
                      </div>
                      
                </div>
            </div>
        </header>
        <main>

            <div class="cards">
                <div class="cards-single">

                    <div>
                        <h1></h1>
                        <span>  <a class="active" href="#"> View Attendence</a> </span>
                    </div>
                    <div>
                        <span class="fa fa-fw fa-home"></span>
                        <!-- <span class="las la-users"></span> -->
                    </div>
                </div>
                <div class="cards-single">

                    <div>
                        <h1></h1>
                        <span> <a class="active" href="#"> See Reports</a></span>
                    </div>
                    <div>
                        <span class="las la-clipboard"></span>
                    </div>
                <!-- </div>
                <div class="cards-single">

                    <div>
                        <h1></h1>
                        <span> <a class="active" href="#"> UPDATE</a></span>
                    </div>
                    <div>
                        <span class="las la-shopping-bag"></span>
                    </div>
                </div>
                <div class="cards-single">

                    <div>
                        <h1></h1>
                        <span> <a class="active" href="#"> DELETE</a></span>
                    </div>
                    <div>
                        <span class="lab la-google-wallet"></span>
                    </div>
                </div> -->
                <!-- <div class="recent-grid">
                    <div class="projects">
                        <div class="card">
                            <div class="card-header">
                                <h2>Recent Project</h2>
                                <button>See All <span class="las la-arrow-right"></span></button>
                            </div>
                            <div class="card-body">
<!-- <table>
    <th>
        <tr>
            <td>Project Title</td>
            <td>Departments</td>
            <td>Status</td>
          
        </tr>
    </th>
    <tbody>
        <tr>
            <td>UI/UX DESign</td>
            <td>Departments</td>
            <td>Status</td>
          
        </tr>
    </tbody>
</table> -->
                            </div>
                        </div>
                    </div>
                    <div class="customers">

                    </div>
                </div> -->
        </main>
    </div>
    </div>
</body>

</html>