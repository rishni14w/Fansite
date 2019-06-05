<?php
require_once "connect.php";
	if(isset($_POST["submit"]))
			{
				echo "b";
				if(!((empty($_POST["fname"]))||(empty($_POST["lname"]))||(empty($_POST["username"]))||(empty($_POST["pwd"]))||(empty($_POST["cpwd"]))))
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
						$lname=$_POST["lname"];
						$email=$_POST["email"];
						$bday=$_POST["bday"];
						$gender=$_POST["gender"];
						$username=$_POST["username"];
						$pwd=$_POST["pwd"];
						$cpwd=$_POST["cpwd"];
						$biasArray=$_POST["biases"];
						$biases=implode(",",$biasArray);				
						$sql="INSERT INTO registration (FirstName,LastName,Email,Birthday,Gender,Bias,UserName,Password,ConfirmPassword) VALUES ('$fname','$lname','$email','$bday','$gender','$biases','$username','$pwd','$cpwd')";
						$query=mysqli_query($connection,$sql);
						if($query)
						{
							header("Location: home.html");
						}
						echo $fname;
						echo " ...... ";
						echo $lname;
						echo " ...... ";
						echo $email;
						echo " ...... ";
						echo $bday;
						echo " ...... ";
						echo $gender;
						echo " ...... ";
						echo $username;
						echo " ...... ";
						echo $pwd;
						echo " ...... ";
						echo $cpwd;
						echo " ...... ";
						echo "d";
						echo " ...... ";
						echo $biases;
					}
					
					mysqli_close($connection);
				}
			}
?>