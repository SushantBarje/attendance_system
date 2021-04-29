<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashbord</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">

</head>

<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span><span>Student Dashboard</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="header.php" class="active"><span class="fa fa-fw fa-home"></span>
                        <span>Home</span></a>
                </li>
                <li>
                    <a href="viewattendence.php"><span class="las la-users"></span>
                        <span>View Attendence</span></a>
                </li>
               
                <li>
                    <a href="generatereport.php"><span class="las la-clipboard-list"></span>
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
                </label>
                Online Attendence System
            </h2>

            <div class="user-wrapper">
                <img src="../img/2.jpg" width="30px" height="30px" alt="">
                <div>
                    <h4>vishal phule</h4>
                    <small>

                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn">Admin</button>
                            <div id="myDropdown" class="dropdown-content">

                                <a href="../login.php"><i class="fa fa-fw fa-user"></i>Logout</a>

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
    <h3>ONRELDSA</h3>
</body>

</html>