<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../CSS/AddDept.css">
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
</main>
</body>
</html>
