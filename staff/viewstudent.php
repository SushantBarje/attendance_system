<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>View Students</title>
</head>

<body>
<?php   include "staffHeader.php" ?>
    <main>
        <table class="">
            <tr border="4px">
                <th>Roll NO</th>
                <th>First Name </th>
                <th>Middlle Name </th>
                <th>Last Name </th>
                <th>View</th>
            </tr>
            <tr>
                <th>49</th>
                <td>Vishal</td>
                <td>Tanaji</td>
                <td>Phule</td>
                <td>
                    <div class="container">

                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                            View
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h2>Students Information </h2>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <table class="">
                                        <tr>
                                               <th>First Name</th>
                                               <td>Vishal </td>
                                            </tr>                                              
                                            <tr>
                                               <th>Middle Name</th>
                                               <td> Tanaji </td>
                                            </tr>
                                            <tr>
                                               <th>Last Name</th>
                                               <td> Phule</td>
                                            </tr>  
                                            <tr>
                                               <th>PRN NO</th>
                                               <td>2018034500246932</td>
                                            </tr>                                              
                                            <tr>
                                               <th>Roll No</th>
                                               <td>49</td>
                                            </tr>
                                            <tr>
                                               <th>Class</th>
                                               <td>TY</td>
                                            </tr>
                                            <tr>
                                               <th>Division</th>
                                               <td>NA</td>
                                            </tr>
                                            <tr>
                                               <th>Batch</th>
                                               <td>3</td>
                                            </tr> 
                                        </table>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </main>
</body>
</html>