<?php
require_once "connect.php";
	if(isset($_POST["submit"]))
			{
				echo "b";
				if(!empty($_POST["username"]))
				{
					echo "a";
					
					$connection=connect();
					
					if(!$connection)
					{
						die("connection failed :" + mysqli_connect_error());
					}
					else
					{
						echo "c";
						$fname=$_POST["fname"];
						$username=$_POST["username"];
						$pwd=$_POST["pwd"];
						$sql="INSERT INTO registration (FirstName,UserName,Password) VALUES ('$fname','$username','$pwd')";
						$query=mysqli_query($connection,$sql);
						if($query)
						{
							header("Location: home.html");
						}
					}
					
					mysqli_close($connection);
				}
			}
?>