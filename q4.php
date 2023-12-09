<?php
include "connecttodb.php"; // Include database connection

//error checking for radio buttons
if (isset($_POST["q4_radios"])) {
	//get choice from radio button
	$choice =$_POST["q4_radios"]; //variable getting tauserid
} else {
	die("<h1>You did not pick an option!</h1>");
}

// $choice = $_POST["q4_radios"];

// Delete Query
$query = "DELETE FROM ta WHERE tauserid = '" . $choice . "'";

echo "<h1>Are you sure you want to obliterate this TA?</h1>";

//error checking for confirmation buttons
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    $yn = $_POST["confirm_delete"];
	
	// checking which confirmation button was selected (Yes/No)
    if ($yn == "Yes") {
        $result = mysqli_query($connection, $query); //Get results from the delete query
        if (!$result) {
            die("<h1>You cannot delete this TA. They are in a course listing!</h1>");
        }
      echo "<h2>TA with ID: " . htmlspecialchars($choice) . " deleted successfully.</h2>";
    } else {
        echo "<h2>Deletion canceled. TA not deleted.</h2>";
    }
}

//Display Yes or No buttons
echo '<form action="q4.php" method="post">';
echo '<input type="hidden" name="q4_radios" value="' . $choice . '">';
echo '<input type="submit" name="confirm_delete" value="Yes">';
echo '<input type="submit" name="confirm_delete" value="No">';
echo '</form>';

mysqli_close($connection);
?>