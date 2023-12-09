<?php
include "connecttodb.php";

// Function to check if the image URL is valid and display it
function displayImageIfValid($url, $width = 200, $height = 200) {
    $headers = @get_headers($url);

    if ($headers && strpos($headers[0], '200') !== false) {
        // Valid URL with a 200 status code, display the image with specified width and height
        echo "<img src='$url' alt='Image' width='$width' height='$height'>";
    } else {
        // Display a default image if the URL is invalid or unreachable
        echo "(No valid image available - showing generic head)<br />";
        echo "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Head_ap_anatomy.jpg/800px-Head_ap_anatomy.jpg' alt='Default Image' width='$width' height='$height'>";
    }
}


$choice = $_POST["q1p2_radios"]; // Retrieving the selected choice from the form

//query to fetch details about the selected TA
$query = "SELECT ta.tauserid, ta.firstname, ta.lastname, ta.studentnum, ta.degreetype, ta.image, loves.lcoursenum AS love_course, hates.hcoursenum AS hate_course 
          FROM ta
          LEFT JOIN loves ON ta.tauserid = loves.ltauserid
          LEFT JOIN hates ON ta.tauserid = hates.htauserid
          WHERE ta.tauserid = '$choice'";

//get results from the query
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

//get the first row from results
$row = mysqli_fetch_assoc($result);

//TA details displaying 
echo "<h2>Here are the Details:</h2>";
echo "<p>TA User ID: " . $row['tauserid'] . "</p>";
echo "<p>Name: " . $row['firstname'] . " " . $row['lastname'] . "</p>";
echo "<p>Student #: " . $row['studentnum'] . "</p>";
echo "<p>Degree: " . $row['degreetype'] . "</p>";

//Show TA Image
echo "<h2>Here Is Their Image:</h2>";
displayImageIfValid($row['image']);

echo "<h2>Courses that the TA loves or hates:</h2>";

$lovedCourses = array();
$hatedCourses = array();

// Collect all loved and hated courses
do {
    if ($row['love_course']) {
        $lovedCourses[] = $row['love_course'];
    }

    if ($row['hate_course']) {
        $hatedCourses[] = $row['hate_course'];
    }
} while ($row = mysqli_fetch_assoc($result));

// Display the loved and hated courses
if (!empty($lovedCourses) || !empty($hatedCourses)) {
    echo "<ul>";

    if (!empty($lovedCourses)) {
        echo "<li>Loves: " . implode(", ", $lovedCourses) . "</li>";
    }

    if (!empty($hatedCourses)) {
        echo "<li>Hates: " . implode(", ", $hatedCourses) . "</li>";
    }

    echo "</ul>";
} else {
    echo "<p>This TA has not picked courses that they love or hate.</p>";
}

mysqli_free_result($result);
mysqli_close($connection);
?>