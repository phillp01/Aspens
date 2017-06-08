<?php
//import db config file
include 'dbConnect.php';

if(isset($_POST['importSubmit'])){
    
    //file validation - is this a csv ?
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){ //Checks the file is uploaded via http post
            
            //opens the csv file
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r'); //read only mode
            
            //skip first line
            fgetcsv($csvFile);
            
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether student already exists - basing this on a student ID.
                $prevQuery = "SELECT id FROM students WHERE studentID = '".$line[0]."'";
                $prevResult = $db->query($prevQuery);
                if($prevResult->num_rows > 0){
                	    
                	//If the student ID exists then UPDATED the member data
                    $db->query("UPDATE students SET studentID = '$line[0]', name = '$line[1]', class = '$line[2]', details1 = '$line[3]', details2 = '$line[4]', details3 = '$line[5]' WHERE studentID = '$line[0]'");
                }else{
                //If member does not exist then INSERT member data into database
                  	$insResult = $db->query("INSERT INTO students (studentID, name, class, details1, details2, details3) VALUES ('$line[0]', '$line[1]', '$line[2]', '$line[3]', '$line[4]', '$line[5]')");       
                }
            }
            
            //close opened csv file
            fclose($csvFile);

            $qstring = '?status=succ';  //Return status based on result.
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

//Send the user back to the main page with success message
header("Location: index.php".$qstring);