<?php
include "connecttodb.php";

//error checking for TA choice 
if (isset($_POST["q5_radios"])) {
	//get choice from radio button
	$choice =$_POST["q5_radios"]; //variable to store choice of TA as their userID
} else {
	die("<h1>Error: never picked a TA!</h1>");
}
//echo $choice; //debugging: see radio button choice

$url = $_POST["new_url"]; //entered url text from textbox

$query = "UPDATE ta SET image = '" . $url . "' WHERE tauserid = '" . $choice . "'";
//echo $query; //debugging: see query 

$result = mysqli_query($connection,$query);
if (!$result) {
die("databases query failed.");
}

// Confirmation message
echo "<h1>Image url has been updated!</h1>";


//mysqli_free_result($result);
mysqli_close($connection) 
?>