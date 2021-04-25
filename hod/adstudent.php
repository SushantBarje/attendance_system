<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Add Students</title>
</head>

<body>
<?php   include "hodHeader.php" ?>
    <main>
        <div class="cards">
            <div class="container">

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                    Add
                </button>

                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h2>Add Students Details</h2>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="#" class="modal-body">

                                    <label for="prn"><b>PRN NO</b></label>
                                    <input type="text" placeholder="Enter PRN" name="prn" required><br>
                                    <label for="fname"><b>First Name</b></label>
                                    <input type="text" placeholder="Fisrst Name" name="fname" required><br>
                                    <label for="mname"><b>Middle Name</b></label>
                                    <input type="text" placeholder="Middle Name" name="mname" required><br>
                                    <label for="lname"><b>Last Name</b></label>
                                    <input type="text" placeholder="Last Name" name="lname" required><br>

                                    <label for="dept"><b>Class</b></label>
                                    <select name="dept" id="dept" form="dept">
                                        <option value="na">NA</option>
                                        <option value="fy">FY</option>
                                        <option value="sy">SY</option>
                                        <option value="ty">TY</option>
                                        <option value="btech">BTECH</option>

                                    </select>

                                    <label for="dept"><b>Div</b></label>
                                    <select name="dept" id="dept" form="dept">
                                        <option value="na">NA</option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                        <option value="d">D</option>

                                    </select>

                                    <label for="dept"><b>Batch</b></label>
                                    <select name="dept" id="dept" form="dept">
                                        <option value="na">NA</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>

                                    </select>

                                    <!-- <label for="deptName"><b>Department Name</b></label>
                                    <input type="text" placeholder="Department name" name="Department" required> -->


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
                <th>PRN</th>
                <th>First Name </th>
                <th>Middlle Name </th>
                <th>Last Name </th>
                <th>Roll NO</th>
                <th>Class </th>
                <th>Div</th>
                <th>Batch</th>
                <th>Edit</th>

            </tr>
            <tr>
                <td>787878787679 </td>
                <td>Vishal</td>
                <td>Tanaji</td>
                <td>Phule</td>
                <td>49</td>
                <td>TY</td>
                <td>NA</td>
                <td>3</td>
            </tr>

        </table>
    </main>

</body>

</html>