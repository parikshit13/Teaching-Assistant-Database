<?php
include "connecttodb.php";

$coid = $_POST["coid"];
$tauserid = $_POST["tauserid"];
$hours = $_POST["hours"];

if (is_numeric($hours) == False){
 echo "Student Number must be numeric";
} else {
$query = "INSERT INTO hasworkedon VALUES ('".$tauserid."','".$coid."','".$hours."')";
}
//echo $query;

$result = mysqli_query($connection,$query);
//echo $result;

if (!$result) {
die("TA is already assigned to this course offering");
}

else{
	echo"<h1>TA has been assigned the course offering</h1>";
}

//mysqli_free_result($result);
?>

<a href="mainmenu.php">Back to Main Menu</a>