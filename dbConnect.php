<?php

//Connection to the Local MySQL Database

//Please complete with relevant connection details

$db = new mysqli('localhost','USERNAME','PASSWORD','db_NAME');
if($db->connect_error) {
	die("Unable to connect database: " . $db->connect_error);
}