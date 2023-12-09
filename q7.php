<?php
include "connecttodb.php";

//error checking for course choice
if (isset($_POST["q7_radios"])) {
	//get choice from radio button
	$choice =$_POST["q7_radios"]; //variable getting coursenum
} else {
	die("<h1>Error: never picked a course!</h1>");
}
//echo $choice; //debugging: see radio button choice

$start_year = $_POST["start_year"]; //entered start year text from textbox
$end_year = $_POST["end_year"]; 

//if text blocks left blank, fill with default value
if($start_year == "") {
	$start_year = 0;
}
if($end_year == "") {
	$end_year = 9999;
}

//type error checking
if (!is_numeric($start_year) || !is_int($start_year + 0 )) { //check if an int
	die("<h1>Error: $start_year is NOT an int</h1>");
}
if (!is_numeric($end_year) || !is_int($end_year + 0 )) {
	die("<h1>Error: $end_year is NOT an int</h1>");
}

//check start_year is before end_year
if ($start_year >= $end_year) {
	die("<h1>Error: $start_year is NOT before $end_year</h1>");
}

$query = "SELECT * FROM courseoffer 
WHERE whichcourse = '" . $choice ."' 
AND year >= " . $start_year . " 
AND year <= " . $end_year;
//echo $query;

$result = mysqli_query($connection,$query);
if (!$result) {
die("databases query failed.");
}

// Display a message before the table
echo "<h2>Course offerings for course: $choice between years $start_year and $end_year</h2>";

echo "<table border='1'>"; // Opening table tag

// create table column headers
echo "<tr>";
echo "<th>coid</th>"; //first column name
echo "<th># students</th>";
echo "<th>term</th>";
echo "<th>year</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>"; // Display a table row for each result

    
    // Display table data for each value
    echo "<td>{$row['coid']}</td>";
    echo "<td>{$row['numstudent']}</td>";
	echo "<td>{$row['term']}</td>";
	echo "<td>{$row['year']}</td>";

    echo "</tr>"; //end of table row
}

mysqli_free_result($result);
mysqli_close($connection) 	
?>	