<?php
include "connecttodb.php";

//error checking for TA choice 
if (isset($_POST["q9_radios"])) {
	//get choice from radio button
	$choice =$_POST["q9_radios"]; //variable to store choice of course offering
} else {
	die("<h1>Error: never picked a course offering!</h1>");
}
//echo $choice; //debugging: see radio button choice

$query = "SELECT * FROM hasworkedon, courseoffer, ta
WHERE hasworkedon.coid = courseoffer.coid 
AND hasworkedon.tauserid = ta.tauserid
AND courseoffer.coid = '" . $choice . "'";
//echo $query; //debugging: see query 

$result = mysqli_query($connection,$query);
if (!$result) {
die("databases query failed.");
}
//var_dump($result); //debugging

$query2 = "SELECT * FROM courseoffer, course 
WHERE courseoffer.whichcourse = course.coursenum
AND courseoffer.coid = '" . $choice . "'";
//echo $query; //debugging

$result2 = mysqli_query($connection,$query2);
if (!$result2) {
die("databases query2 failed.");
}
//var_dump($result); //debugging

$firstrow = mysqli_fetch_assoc($result2);
//var_dump($firstrow); //debugging

// Display a message before the table
echo "<h2>TAs from course offering: $choice </h2>";
echo "Course code: ". $firstrow["whichcourse"] . "<br>Course name: ". $firstrow["coursename"]; 

echo "<table border='1'>"; // Opening table tag

// create table column headers
echo "<tr>";
echo "<th>First name</th>"; //first column name
echo "<th>Last name</th>";
echo "<th>TA user ID</th>"; 
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>"; // Display a table row for each result

    // Display table data for each value
    echo "<td>{$row['firstname']}</td>";
    echo "<td>{$row['lastname']}</td>";
	echo "<td>{$row['tauserid']}</td>";

    echo "</tr>"; //end of table row
}

mysqli_free_result($result);
mysqli_free_result($result2);
mysqli_close($connection) 
?>