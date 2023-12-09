<?php
include "connecttodb.php";

//error checking for radio buttons
if (isset($_POST["q2_radios"])) {
	//get choice from radio button
	$choice =$_POST["q2_radios"]; //variable getting tauserid
} else {
	die("<h1>You did not pick an option!</h1>");
}

// Function to check if the image URL is valid and display it
function displayImageIfValid($url, $width = 69, $height = 69) {
    $headers = @get_headers($url);

    if ($headers && strpos($headers[0], '200') !== false) {
        // Valid URL with a 200 status code, display the image with specified width and height
        $image = "<img src='$url' alt='Image' width='$width' height='$height'>";
    } else {
        // Display a default image if the URL is invalid or unreachable
        //echo "(No valid image available - showing generic head)<br />";
        $image = "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Head_ap_anatomy.jpg/800px-Head_ap_anatomy.jpg' alt='Default Image' width='$width' height='$height'>";
    }
	return $image;
}

//image dimensions
$width = 69;
$height = 69;

//get choice from radio buttons
$choice =$_POST["q2_radios"]; //variable to store choice, either 'masters' or 'phd'
//echo $choice; //debugging: see radio button choice

//change query based on button choice, although a better way to do this more dynamically is in the vetoffice assignment's addnewpet.php 
if ($choice == "masters") {
	//echo 'masters if branch';
	$query = "SELECT * FROM ta WHERE degreetype = 'Masters'";
} elseif ($choice == "phd") { 
	$query = "SELECT * FROM ta WHERE degreetype = 'PhD'";
} else { //no selection
	die("<h1>You did not pick an option!</h1>"); //halts php execution
}	

$result = mysqli_query($connection,$query);
if (!$result) {
die("databases query failed.");
}

// Display a message before the table
echo "<h2>TAs with degree type: $choice</h2>";

echo "<table border='1'>"; // Opening table tag

// create table column headers
echo "<tr>";
echo "<th>TA user ID</th>"; //first column name
echo "<th>First name</th>";
echo "<th>Last name</th>";
echo "<th>Student #</th>";
echo "<th>Degree</th>";
echo "<th>Image URL</th>";
echo "<th>Image</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>"; // Display a table row for each result

    // Iterate through each key-value pair in the row
    foreach ($row as $value) {
        // Display table data for each value
        echo "<td>{$value}</td>";
    }
	
	//var_dump($row);
	//echo "<td><img src='" . $row['image'] . "' alt='Image' width='$width' height='$height'></td>"; //show actual img from url
	$image = displayImageIfValid($row['image']);
	echo "<td> {$image} </td>";
    echo "</tr>"; //end of table row
}

mysqli_free_result($result);
mysqli_close($connection) 
?>