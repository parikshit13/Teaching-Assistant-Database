<?php
include "connecttodb.php";

//error checking for TA choice
if (isset($_POST["q8_radios"])) {
	//get choice from radio button
	$choice =$_POST["q8_radios"]; //variable to store choice of TA as their userID
} else {
	die("<h1>Error: never picked a TA!</h1>");
}
//echo $choice; //debugging: see radio button choice

//1st query (course offerings)
$query = "SELECT DISTINCT course.coursename, courseoffer.whichcourse, courseoffer.term, courseoffer.year, hasworkedon.hours   
FROM ta
INNER JOIN hasworkedon ON ta.tauserid = hasworkedon.tauserid
INNER JOIN courseoffer ON courseoffer.coid = hasworkedon.coid
INNER JOIN course ON course.coursenum = courseoffer.whichcourse
WHERE  ta.tauserid = '" . $choice . "'";
//echo $query; //debugging: see query 

$result = mysqli_query($connection,$query);
if (!$result) {
die("database query 1 failed.");
}

//2nd query (loves)
$query2 = "SELECT lcoursenum 
FROM loves 
WHERE ltauserid = '" . $choice . "'";
//echo $query2; //debugging: see query2

$result2 = mysqli_query($connection,$query2);
if (!$result2) {
die("database query 2 failed.");
}

//3rd query (loves)
$query3 = "SELECT hcoursenum 
FROM hates 
WHERE htauserid = '" . $choice . "'";
//echo $query2; //debugging: see query2

$result3 = mysqli_query($connection,$query3);
if (!$result3) {
die("database query 3 failed.");
}


// Display a message before the table
echo "<h2>Course offerings with $choice</h2>";

echo "<table border='1'>"; // Opening table tag

// create table column headers
echo "<tr>";
echo "<th>Course Name</th>"; //first column name
echo "<th>Code</th>";
echo "<th>Term</th>";
echo "<th>Year</th>";
echo "<th>Hours</th>";
echo "<th>Likes?</th>";
echo "<th>Hates?</th>";
echo "</tr>";


//while ($row = mysqli_fetch_assoc($result)) {
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($rows as $row) {
    echo "<tr>"; // Display a table row for each result

    // Iterate through each key-value pair in the row
    foreach ($row as $value) {
        // Display table data for each value
        echo "<td>{$value}</td>";
    }
	
	//echo $row['whichcourse']; //debugging

	// Reset the internal pointer of $result2 and $result3 to the beginning
	mysqli_data_seek($result2, 0);
	mysqli_data_seek($result3, 0);

	//check if row contains loved course
	$loves_rows = mysqli_fetch_all($result2, MYSQLI_ASSOC);
	$found = false;
	foreach ($loves_rows as $loves_row) {
	
		//echo $loves_row['lcoursenum']; //debugging: see loved course codes
		if ($row['whichcourse'] == $loves_row['lcoursenum']) {
			//echo 'found a match!!!';
			echo "<td>ヽ(♡‿♡)ノ</td>";
			$found = true;
		}
	}
	
	if ($found == false) { //if this course is not loved, fill with empty cell 
		echo "<td></td>";
	}
	
	//check if row contains hated course
	$hates_rows = mysqli_fetch_all($result3, MYSQLI_ASSOC);
	$found = false;
	foreach ($hates_rows as $hates_row) {
	
		//echo $hates_row['hcoursenum']; //debugging: see hated course codes
		if ($row['whichcourse'] == $hates_row['hcoursenum']) {
			//echo 'found a match!!!';
			echo "<td>( ͠° ͟ʖ ͡°)</td>";
			$found = true;
		}
	}
	
	if ($found == false) {
		echo "<td></td>";
	}

    echo "</tr>";
}

mysqli_free_result($result);
mysqli_free_result($result2);
mysqli_free_result($result3);
mysqli_close($connection) 
?>