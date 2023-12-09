<!DOCTYPE html>
<html>
<head>
    <title>Assignment 3</title>
    <link rel="stylesheet" type="text/css" href="museum.css">
    <link href="https://fonts.googleapis.com/css?family=Mali" rel="stylesheet">
</head>
<body>
    <?php
    include "connecttodb.php";
    ?>
    <h1>TA Database</h1>
	<h3>Hello there! Welcome to the TA Database. I am your receptionist, how can I help you?<h3>
    <img src="https://cs3319.gaul.csd.uwo.ca/vm336/phpworkshop/uploadarea/dog1.jpg" alt="Receptionist Image" width="216" height="260">


    <!-- Adding 10 buttons with "Question 1", "Question 2", etc. above each button -->

        <p><h5>Question 1:</h5> List all the information except image about the teaching assistants. Allow the user to order the data by Last Name OR by degree type(you might want to use a radio button for this choice). 
		For last name,allow the user to either order them in ascending or descending order (you could also use a radio button for this choice). 
		</p>
		
		<p>
		Allow the user to select a t.a and if they select a t.a., then display all the data about that t.a. and display the picture if the image field has a valid URL in it. If the image field is null just display the generic outline of a head. 
		</p>
		
		<p>
		Also show all the courses that the selected t.a. loves and the courses that the selected t.a. hates. If the t.a. doesn't have any courses that they love or hate, do not show anything (or put a message like "This t.a. has not picked courses that they love")
		</p>
	
		<form action = "q1.php" method = "post">
		
        <input type="radio" name="q1_radios" value="All">
		<label for="q1">All TAs</label><br>
		
		<input type="radio" name="q1_radios" value="LNA">
		<label for="q1">ALL TAs - Ordered by Last Name (Ascending)</label><br>
		
		<input type="radio" name="q1_radios" value="DNA">
		<label for="q1">ALL TAs - Ordered by Degree Type (Ascending)</label><br>
		
		<input type="radio" name="q1_radios" value="LND">
		<label for="q1">ALL TAs - Ordered by Last Name (Descending)</label><br>
		
		<input type="radio" name="q1_radios" value="DND">
		<label for="q1">ALL TAs - Ordered by Degree Type (Descending)</label><br>
		
		<input type="submit" value="Get TAs">
		
		</form>
		
		
		
        <p><h5>Question 2:</h5> Allow the user to select one of either Masters or PhD and then list all the ta information about tas studying for this degree.</p>
        
		<form action = "q2.php" method = "post"> <!--wrap the form tags around all buttons or inputs for your question, and set action to your new php script-->
		<input type="radio" name="q2_radios" value="masters"> <!--value becomes what is passed into the php script if selected-->
		<label for="Masters">Masters</label><br> <!--label for radio buttons, different from vet office example-->
		<input type="radio" name="q2_radios" value="phd">
		<label for="PhD">PhD</label><br>
		<input type="submit" value="Get TAs"> <!--value becomes the label of this button-->
		</form>



        <p><h5>Question 3:</h5> Insert a new teaching assistant. Prompt for the necessary data.  The user may also enter the courses that this t.a. loves or hates.  they must pick from existing courses, so you could give a list of courses to pick from (using a dropdown box or radio buttons). Note: if the user types in an existing Western User Id OR an existing student number, your program should output an error message and not let the new ta be added. </p>
        
		<form action =  "q3.php" method = "post">
			User ID: <input type="text" name="uID" ><br>
            First Name: <input type = "text" name = "fName" value=""><br>
			Last Name: <input type = "text" name = "lName" value = ""><br>
			Student Number: <input type = "text" name = "sNum" value = "" maxlength = "9"><br>
			Degree Type: <input type ="radio" id = "Masters" name = "dType" value = "Masters">
						<label for = "Masters">Masters</label>
						<input type = "radio" id = "PhD" name = "dType" value = "PhD">
						<label for = "PhD">PhD</label><br>

			Loves: <?php
					$query = "select * from course;";
					$result = mysqli_query($connection,$query);
			if (!$result) {
				die("databases query failed.");
			}
			echo "<select name='loves'>";
			echo "<option value='select'>None</option>";
			  while ($row = mysqli_fetch_assoc($result)) {
				 echo "<option value='" . $row["coursenum"] ."'>" . $row["coursename"] . "</option>";
			   }
			echo "</select>";
			   mysqli_free_result($result);
			?><br>
			Hates: <?php
					$query = "select * from course;";
					$result = mysqli_query($connection,$query);
			  if (!$result) {
				die("databases query failed.");
			  }
			echo "<select name='hates'>";
			echo "<option value='select'>None</option>";
			  while ($row = mysqli_fetch_assoc($result)) {
				 echo "<option value='" . $row["coursenum"] ."'>" . $row["coursename"] . "</option>";
			   }
			echo "</select>";
			   mysqli_free_result($result);
			?><br>

			<button type="submit" name="action" value="button3">Insert TA</button><br>
		</form>



        <p><h5>Question 4:</h5> Delete an existing ta. Either prompt for the ta Western User ID or you could display the list of tas and allow the user to pick the one they want to delete. If you decide to prompt for the Western User ID, make sure you remember to give an error message if the user tries to delete a non-existent ta. If the ta is assigned to a course offering, output a message that you cannot delete this ta.  Also remember that any permanent deletions should always allow the user the chance to back out (e.g. "Are you sure you want to delete this person?").</p>
		
		<form action = "q4.php" method = "post">
		<?php //run php to dynamically create list of ta's with radio buttons
			$query = "SELECT * FROM ta";
			$result = mysqli_query($connection,$query);
			if (!$result) {
				die("databases query failed.");
			}
			while ($row = mysqli_fetch_assoc($result)) { //create radio buttons for each TA
				echo '<input type="radio" name="q4_radios" value="';
				echo $row["tauserid"]; //note that it is tauserid sent to 15.php for the ta selected, but first name and last name are only shown
				echo '">' . $row["firstname"] . " " . $row["lastname"] . "<br>";
			}
			mysqli_free_result($result);
		?> <!--end of php snippet-->
		<br> <!--line break so button is on next line-->
        <input type="submit" value="Obliterate TA">
		</form>



        <p><h5>Question 5:</h5> Modify a ta - Allow the user to change the image URL. </p>
		
		<form action = "q5.php" method = "post">
		<?php //run php to dynamically create list of ta's with radio buttons
			$query = "SELECT * FROM ta";
			$result = mysqli_query($connection,$query);
			if (!$result) {
				die("databases query failed.");
			}
			while ($row = mysqli_fetch_assoc($result)) { //create radio buttons for each TA
				echo '<input type="radio" name="q5_radios" value="';
				echo $row["tauserid"]; //note that it is tauserid sent to 15.php for the ta selected, but first name and last name are only shown
				echo '">' . $row["firstname"] . " " . $row["lastname"] . "<br>";
			}
			mysqli_free_result($result);
		?> <!--end of php snippet-->
		<label for="textbox">New url:</label>
		<input type="text" id="textbox" name="new_url">
		<br> <!--line break so button is on next line-->
        <input type="submit" value="Update TA's image">
		</form>


        <p><h5>Question 6:</h5> Assign a ta to a course offering. Do not allow this if the relationship already exists (output a warning like "Ta is already assigned to this course offering"). Allow the user to select a ta and a course offering and then create the relationship.  Prompt for the number of hours.</p>
		<?php
		include "q6.php";
		?>



        <p><h5>Question 7:</h5> Allow the user to select a course and see all the course offering for the course.  Show the course offering id number, the number of students that term, the term and the year it was offered for each course.  Also allow the user to pick a start year and end year and just show the course offerings between (and including) those years. </p>

		<form action = "q7.php" method = "post">
		<?php
			$query = "SELECT * FROM course";
			$result = mysqli_query($connection,$query);
			if (!$result) {
				die("databases query failed.");
			}
			while ($row = mysqli_fetch_assoc($result)) { //create radio buttons for each course
				echo '<input type="radio" name="q7_radios" value="';
				echo $row["coursenum"];
				echo '">' . $row["coursenum"] . " " . $row["coursename"] . "<br>";
			}
			mysqli_free_result($result);
		?> 
		<label for="textbox">(Optional) start year:</label> 
		<input type="text" id="textbox" name="start_year">
		<br> <!--line break so next textbook is below-->
		<label for="textbox">(Optional) end year:</label>
		<input type="text" id="textbox" name="end_year">
		<br>
        <input type="submit" value="See course offerings">
		</form>
		


        <p><h5>Question 8:</h5> Allow the user to select a ta. and see all the course offerings that this t.a. has worked on. Make sure you show the course number and course name for the course offering as well as the term and the term and the year and the hours and if this t.a. loved this course or hated this course (maybe put a happy face or sad face next to it).</p>
		
		<form action = "q8.php" method = "post">
		<?php
			$query = "SELECT * FROM ta";
			$result = mysqli_query($connection,$query);
			if (!$result) {
				die("databases query failed.");
			}
			while ($row = mysqli_fetch_assoc($result)) { //create radio buttons for each TA
				echo '<input type="radio" name="q8_radios" value="';
				echo $row["tauserid"]; //note that it is tauserid sent to 15.php for the ta selected, but first name and last name are only shown
				echo '">' . $row["firstname"] . " " . $row["lastname"] . "<br>";
			}
			mysqli_free_result($result);
		?> 
        <input type="submit" value="See TA's courses">
		</form>



        <p><h5>Question 9:</h5> Allow the user to select a course offering and display the course number and name and the first and last names and user ids of all t.a.s  who have worked on this course. </p>

		<form action = "q9.php" method = "post">
		<?php
			$query = "SELECT * FROM courseoffer";
			$result = mysqli_query($connection,$query);
			if (!$result) {
				die("databases query failed.");
			}
			while ($row = mysqli_fetch_assoc($result)) { //create radio buttons for each TA
				echo '<input type="radio" name="q9_radios" value="';
				echo $row["coid"]; //note that it is coid sent to q9.php for the course offering selected, but first name and last name are only shown
				echo '">' . $row["coid"] . " " . $row["whichcourse"] . " " . $row["year"] . " " . $row["term"] .  "<br>";
			}
			mysqli_free_result($result);
		?> 
        <input type="submit" value="See course offering's TAs">
		</form>

</body>
</html>
