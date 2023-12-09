<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Assign TA to Course Offering</title>
</head>
<body>

    <form action="q6submit.php" method="post">
        <label for="tauserid">Select TA:</label>
        
       	<?php
	include("connecttodb.php");
        $ta_query = mysqli_query($connection, "SELECT tauserid, firstname, lastname FROM ta");
        echo "<select name='tauserid'>";
        while ($ta_row = mysqli_fetch_assoc($ta_query)) {
            echo "<option value='" . $ta_row['tauserid'] . "'>" . $ta_row['firstname'] . " " . $ta_row['lastname'] . "</option>";
        }
	echo "</select><br><br>";
        mysqli_close($connection);
        ?>

	<label for="coid">Select Course Offering:</label>
        
       	<?php
	include("connecttodb.php");
        $course_query = mysqli_query($connection, "SELECT coid, whichcourse FROM courseoffer");
        echo "<select name='coid'>";
        while ($course_row = mysqli_fetch_assoc($course_query)) {
            echo "<option value='" . $course_row['coid'] . "'>" . $course_row['coid'] . "</option>";
        }
	echo "</select><br><br>";
        //mysqli_close($connection);
        ?>

	<label for="hours">Number of Hours:</label>
        <input type="number" name="hours" required>
        <br><br>
        <input type="submit" value="Assign TA">
    </form>

</body>
</html>


<br>