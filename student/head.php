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