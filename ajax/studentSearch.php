<?php
include '../dbConnect.php'; //Connect to the Database

//$table = "";
$rows = array(); //Initialise an array for the results



if (isset($_POST['className']))	{ //Test to see if classname is being searched

	$className = ($_POST['className']); //Get Classname

	$result = $db->query("SELECT * FROM students WHERE class = '$className' ORDER BY id DESC");
	if($result->num_rows > 0)	{ //If we have results
		while($row = $result->fetch_assoc()){ //Loop through the results and populate array with results
              $rows[] = $row; 
		}   
	}
}elseif (isset($_POST['searchName']))	{
	
	$searchName = ($_POST['searchName']); //Test to see if Name is being searched
	$result = $db->query("SELECT * FROM students WHERE name LIKE '%$searchName%' ORDER BY id DESC"); //Search MySQL based on the name containing any of the dearched text
	if($result->num_rows > 0)	{ // If we have results then loop through and populate the array
		while($row = $result->fetch_assoc()){
              $rows[] = $row;
		}   
	}
}else	{ // Display all results
	$result = $db->query("SELECT * FROM students ORDER BY id DESC"); 
	if($result->num_rows > 0)	{ //Loop and Populate array
		while($row = $result->fetch_assoc()){
			  $rows[] = $row;
		}   
	}
}

echo json_encode($rows); //Encode as JSON and send back

?>