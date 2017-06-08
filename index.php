<?php

include 'dbConnect.php';

//Bootstrap Alerts for the results box

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Student data has been inserted successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}

?>


<!DOCTYPE html>
<head>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

/* Styling. Generally I would create a seperate .css page for styling the site. But as this was not the focus for speed I have just included some basic styling here and some inline styling. */

.navbar-default {
    background-color: #28A740;
    border-color: #249639;
	height:100px;
}

.step	{
	min-height:80px;
	text-align:center;
}
</style>

</head>
<html>
<body>

<div class="container"> <!-- Createw the BS Container and setup the header -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">
			<img alt="Brand" src="img/logo.png">
		  </a>
		</div>
	  </div>
	</nav>

    <?php if(!empty($statusMsg)){
        echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
    } ?>
	
	<div class="row"> <!-- Set up the various input panels and buttons for the page-->
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Student CSV Import
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<form action="importData.php" method="post" enctype="multipart/form-data" id="importFrm">
								<div class="panel panel-default">
									<div class="panel-heading">
										Step 1
									</div>
									<div class="panel-body step">
										<input type="file" name="file" />							
									</div>
								</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									Step 2
								</div>
								<div class="panel-body step">
									<input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
								</div>
							</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Student Search
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									Search by Name
								</div>
								<div style="text-align:center" class="panel-body">
									<input type="text" class="form-control" id="searchName" placeholder="Enter Name">
									<button style="margin-top:10px;" type="button" class="btn btn-primary" id="nameClick">Search</button>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									Search By Class
								</div>
								<div style="text-align:center" class="panel-body">
									<input type="text" class="form-control" id="searchClass" placeholder="Enter Class">
									<button style="margin-top:10px;" type="button" class="btn btn-primary" id="classClick">Search</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class = "panel panel-default">
								<div style="text-align:center;" class = "panel-body">
									<button style="margin-top:10px;" type="button" class="btn btn-primary" id="showAll">Show All</button>
									<button style="margin-top:10px;" type="button" class="btn btn-primary" id="clearTable">Clear Table</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


    <div class="panel panel-default"> <!-- Define the Table and Table headers to be updated via jquery with the returned data-->
        <div class="panel-heading">
            Student list
        </div>
        <div class="panel-body">
            
            <table id ="studentTable" class="table table-bordered">
                <thead>
                    <tr>                      
					  <th>Student ID</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Detail 1</th>
                      <th>Detail 2</th>
                      <th>Detail 3</th>
                    </tr>
					
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="test"></div>


<script>

// Button functions which call the .php search 

$("#classClick").click(function(){
	var className = {};
	className.className = $("#searchClass").val();
	searchStudents(className);
});

$("#nameClick").click(function(){
	var searchName = {};
	searchName.searchName = $("#searchName").val();
	searchStudents(searchName);
});

$("#showAll").click(function(){
	var data = {};
	searchStudents(data);
});

$("#clearTable").click(function(){
	$("#studentTable tbody").empty();
});

//Ajax POST call to send the searched details to the .php updates the table with the returned data
function searchStudents(data){
    $.ajax({
        type: 'POST',
        url: "ajax/studentSearch.php",
        data: data,
        success: function(data) {
			var students =  JSON.parse(data);	//Parse returned results
			$("#studentTable tbody").empty(); //Empty previous results from the table
			if (students.length > 0)	{ //If we have results

				for(var i=0;i<students.length;i++)    { //Loop through the results and update the table body
					var tr = "<tr>";
					var id = "<td>"+students[i]["id"]+"</td>";
					var name = "<td>" + students[i]["name"] + "</td>";
					var className = "<td>" + students[i]["class"] + "</td>";
					var details1 = "<td>" + students[i]["details1"] + "</td>";
					var details2 = "<td>" + students[i]["details2"] + "</td>";
					var details3 = "<td>" + students[i]["details3"] + "</td></tr>";
					
					$("#studentTable tbody").append(tr + id + name + className + details1 + details2 + details3); //Apply the updated results to the table
				}   
			}else	{
				$("#studentTable tbody").append("<tr><td colspan='6'>No Students found.....</td></tr>"); //If no results then Populate with No results
			}

        },	
        error: function(data) { // if error occured
            alert("Error occured, please try again");
        },
    });
};
</script>

</body>
</html>