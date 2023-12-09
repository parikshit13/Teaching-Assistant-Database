<?php
include "connecttodb.php";

//error checking for radio buttons
if (isset($_POST["dType"])) {
	//get choice from radio button
	//$choice =$_POST["dType"]; //variable getting tauserid
} else {
	die("<h1>You did not complete the input form!</h1>");
}

$ta_userid = $_POST["uID"];
$first_name = $_POST["fName"];
$last_name = $_POST["lName"];
$student_number = $_POST["sNum"];

$degree_type = $_POST["dType"];

$userid_check = mysqli_query($connection,"SELECT * FROM ta WHERE tauserid = '".$ta_userid."'");
$userid_count = mysqli_num_rows($userid_check);


$snum_check = mysqli_query($connection,"SELECT * FROM ta WHERE studentnum = '".$student_number."'");
$snum_count = mysqli_num_rows($snum_check);


if($userid_count == 0 && $snum_count == 0){
if (is_numeric($student_number) == False){
 echo "Student Number must be numeric";
}if (ctype_alpha($first_name) == False || ctype_alpha($last_name) == False) {
 echo  "First and Last name must be alphabetic values<br />";
}
 else {
$query = "INSERT INTO ta VALUES ('".$ta_userid."','".$first_name."','".$last_name."',".$student_number.",'".$degree_type."','temp')";
}
//echo $query;

$result = mysqli_query($connection,$query);
//echo $result;

if (!$result) {
die("insert databases query failed.");
}

$loves = $_POST["loves"];
//echo "$loves";

if($loves!='select'){

$queryl = "INSERT INTO loves VALUES ('".$ta_userid."','".$loves."')";
//echo $queryl;
$resultl = mysqli_query($connection,$queryl);
//echo $resultl;
} 

else {
	$resultl = "temp";
}


if (!$resultl) {
    die("loves databases query failed.");
    }

$hates = $_POST["hates"];

if($hates!='select'){ 

$queryh = "INSERT INTO hates VALUES ('".$ta_userid."','".$hates."')";
//echo $queryh;
$resulth = mysqli_query($connection,$queryh);
//echo $resulth;
} 
else {
	$resulth = "temp";
}
    
if (!$resulth) {
    die("hates databases query failed.");
    
    
}
echo "<h1>TA succesfully inserted</h1>";
    } 
else {
    echo 'TA already exists, try again';}
    
    
    ?>
    <br><br>
    <a href="mainmenu.php">Back to Main Menu</a>