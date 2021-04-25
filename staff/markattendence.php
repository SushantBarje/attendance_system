<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Mark Attendence</title>
</head>

<body>
<?php   include "staffHeader.php" ?>
    <main>
        <label for="course"><b>Course</b></label>
        <select name="dept" id="dept" form="dept">
            <option value="na">NA</option>
            <option value="ai">AI</option>
            <option value="unix">UNIX </option>
            <option value="oomd">OOMD</option>
            <option value="cc">CC</option>
            <option value="coa">COA</option>
        </select>
        <label for="course"><b>Attendence</b></label>
        <select name="dept" id="dept" form="dept">
            <option value="na">NA</option>
            <option value="cse">Theory</option>
            <option value="cse">Practical</option>
        </select>

        <label for="datetime"><b>Date and Time:</b></label>
        <input type="datetime-local" id="birthdaytime" name="birthdaytime">
        <input type="submit">
        <br>
        <table class="">
            <tr border="3px">
                <th>Roll No</th>
                <th> Name</th>
                <th>Mark Attendence</th>
            </tr>
            <tr>
                <td>49</td>
                <td>Vishal Tanaji Phule</td>
                <td>
                    <div class="container">
                        <form>
                            <label class="radio-inline">
                                Present <input type="radio" name="optradio" checked>
                            </label>
                            <label class="radio-inline">
                                Absent <input type="radio" name="optradio">
                            </label>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td>49</td>
                <td>Vishal Tanaji Phule</td>
                <td>
                    <div class="container">
                        <form>
                            <label class="radio-inline">
                                Present <input type="radio" name="optradio" checked>
                            </label>
                            <label class="radio-inline">
                                Absent <input type="radio" name="optradio">
                            </label>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3"> 
                    <button   type="submit" class="btn btn-secondary" >Submit Attendence</button>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>