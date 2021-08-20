<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashbord</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
</head>
<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span><span>Hod Dashboard</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="home.php" class="active"><span class="fa fa-fw fa-home"></span>
                        <span>Home</span></a>
                </li>

                <li>
                    <a href="adstudent.php"><span class="las la-users"></span>
                        <span>Add Students</span></a>
                   
                </li>
                <li>
                    <a href="managestaff.php"><span class="las la-users"></span>
                        <span>Manage Staff</span></a>
                   
                </li>
                <li>
                    <a href="mangecourses.php"><span class="las la-users"></span>
                        <span>Manage Courses</span></a>
                </li>
                
                <li>
                    <a href="manageclass.php"><span class="las la-users"></span>
                        <span>Manage Classes</span></a>
                </li>
                <!-- <li>
                    <a href="markattendence.php"><span class="las la-shopping-bag"></span>
                        <span>Mark Attendence</span></a>
                </li> -->
                <!-- <li>
                    <a href="addhod.php"><span class="las la-clipboard-list"></span>
                        <span>Hod</span></a>
                </li> -->
                <!-- <li>
                    <a href="faculty.html"><span class="las la-user-circle"></span>
                        <span>Faculty</span></a>
                </li>
                <li>
                    <a href="../admin/addstudent.php"><span class="las la-receipt"></span>
                        <span>Students</span></a>
                </li> -->

                <li>
                    <a href="generatereport.php"><span class="las la-clipboard-list"></span>
                        <span> Theory Reports</span></a>
                </li>
                <li>
                    <a href="practical_report.php"><span class="las la-users"></span>
                        <span>Practical Report</span></a>
                </li>
                <li>
                <a href="promotion.php"><span class="las la-users"></span>
                        <span>Promotion</span></a>
                </li>
            </ul>
        </div>
    </div>


    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                Online Attendence System
            </h2>

            <div class="user-wrapper">
                <div>
                    <h4><?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']?></h4>
                    <small>

                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn">Admin</button>
                            <div id="myDropdown" class="dropdown-content">

                                <a href="../logout.php"><i class="fa fa-fw fa-user"></i>Logout</a>

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

</body>

</html>