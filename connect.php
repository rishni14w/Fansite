<?php
function connect()
{
	$dbname="fansite";
	$con=mysqli_connect("localhost","root","",$dbname);
	
	return $con;
	
}
?>