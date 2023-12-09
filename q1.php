<?php
include "connecttodb.php";

//error checking for radio buttons
if (isset($_POST["q1_radios"])) {
	//get choice from radio button
	$choice =$_POST["q1_radios"]; //variable getting tauserid
} else {
	die("<h1>You did not pick an option!</h1>");
}

//change query based on button choice 
if ($choice == "All") {
	//All TAs if branch
	$query = "SELECT tauserid, firstname, lastname, studentnum, degreetype FROM ta";
}
elseif ($choice == "LNA") {
	//Ordered by Last Name ASC
	$query = "SELECT tauserid, firstname, lastname, studentnum, degreetype FROM ta ORDER BY lastname ASC";
} 
elseif ($choice == "DNA") { 
	//Ordered by Degree Type ASC
	$query = "SELECT tauserid, firstname, lastname, studentnum, degreetype FROM ta ORDER BY degreetype ASC";
}
elseif ($choice == "LND") {
	//Ordered by Last Name DSC
	$query = "SELECT tauserid, firstname, lastname, studentnum, degreetype FROM ta ORDER BY lastname DESC";
}
elseif ($choice == "DND") { 
	//Ordered by Degree Type DSC
	$query = "SELECT tauserid, firstname, lastname, studentnum, degreetype FROM ta ORDER BY degreetype DESC";
}
else { //no selection
	die("<h1>You did not pick an option!</h1>");
}	

//Get the results of the SELECT queries
$result = mysqli_query($connection,$query);
if (!$result) {
die("databases query failed.");
}

//Display a message before the table
echo "<h2>Here are the TAs:</h2>";

echo "<table border='1'>"; //Opening table tag

//Create table column headers
echo "<tr>";
echo "<th>TA user ID</th>"; //Column name
echo "<th>First name</th>";
echo "<th>Last name</th>";
echo "<th>Student #</th>";
echo "<th>Degree</th>";
echo "<th>Actions</th>"; //New column for buttons
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>"; // Display a table row for each result
    
    // Display table data for each column except the last one
    echo "<td>{$row['tauserid']}</td>";
    echo "<td>{$row['firstname']}</td>";
    echo "<td>{$row['lastname']}</td>";
    echo "<td>{$row['studentnum']}</td>";
    echo "<td>{$row['degreetype']}</td>";
    
    // Button column - create a button that links to q1p2.php with the tauserid as a parameter
    echo "<td>";
    echo "<form action='q1p2.php' method='post'>";
    echo "<input type='hidden' name='q1p2_radios' value='{$row['tauserid']}'>";
    echo "<input type='submit' value='View Details'>";
    echo "</form>";
    echo "</td>";
    
    echo "</tr>";
}

mysqli_free_result($result);
mysqli_close($connection);
?>