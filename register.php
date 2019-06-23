<?php
require_once "connect.php";
	if(isset($_POST["submit"]))
	{
		$userid=uniqid(mt_rand()."EXOL");
		
		$role=$_POST["role"];
		
		if($role=="Aeri")
		{
			$role="2";
			if(!((empty($_POST["fname"]))||(empty($_POST["lname"]))||(empty($_POST["username"]))||(empty($_POST["pwd"]))||(empty($_POST["cpwd"]))))
			{
				
				$connection=connect();
				
				if(!$connection)
				{
					die("connection failed :" + mysqli_connect_error());
				}
				else
				{
					$fname=test_input($_POST["fname"]);
					$lname=test_input($_POST["lname"]);
					$email=test_input($_POST["email"]);
					$bday=$_POST["bday"];
					
					if(!empty($_POST["gender"]))
					{
						$gender=$_POST["gender"];
					}
					else
					{
						$gender=null;
					}
					if(!empty($_POST["biases"]))
					{
						$biasArray=$_POST["biases"];
						$biases=implode(",",$biasArray);
					}
					else
					{
						$biases=null;
					}
					$username=test_input($_POST["username"]);
					$pwd=test_input($_POST["pwd"]);
					$hashed_pwd=password_hash($pwd,PASSWORD_DEFAULT);
					$cpwd=$_POST["cpwd"];
									
					$sql="INSERT INTO user (UserId,FirstName,LastName,Email,Birthday,Gender,Bias,UserName,Password) VALUES ('$userid','$fname','$lname','$email','$bday','$gender','$biases','$username','$hashed_pwd')";
					$query=mysqli_query($connection,$sql);
					if($query)
					{
						$sql2="INSERT INTO userrole (UserId,RoleId) VALUES ('$userid','$role')";
						$query2=mysqli_query($connection,$sql2);
						if($query2)
						{
							header("Location: login.html");
						}						
					}
				}
				
				mysqli_close($connection);
			}
		}
		else
		{
			if(!((empty($_POST["username"]))||(empty($_POST["pwd"]))||(empty($_POST["cpwd"]))))
			{
				$connection=connect();
				
				if(!$connection)
				{
					die("connection failed :" + mysqli_connect_error());
				}
				else
				{
					$username=test_input($_POST["username"]);
					$pwd=test_input($_POST["pwd"]);
					$cpwd=$_POST["cpwd"];
									
					$sql="UPDATE user SET Password='$pwd' WHERE UserName='$username'";
					$query=mysqli_query($connection,$sql);
					echo "role1";
					if($query)
					{
						header("Location: login.html");
					}
					
				}
				
				mysqli_close($connection);
			}
		}
		
	}
	
	function test_input($data)
	{
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
?>