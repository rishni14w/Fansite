<?php
require_once "connect.php";
	if(isset($_POST["submit"]))
	{
		//echo "b";
		$userid=uniqid(mt_rand()."EXOL");
		
		$role=$_POST["role"];
		$err="";
		if($role=="Aeri")
		{
			$role="2";
			//echo $role;
			if(!((empty($_POST["fname"]))||(empty($_POST["lname"]))||(empty($_POST["email"])||(empty($_POST["username"]))||(empty($_POST["pwd"]))||(empty($_POST["cpwd"])))))
			{				
				$connection=connect();
				
				if(!$connection)
				{
					die("connection failed :" + mysqli_connect_error());
				}
				else
				{
					$fname=test_input($_POST["fname"]);
					$fname=filter_var($fname,FILTER_SANITIZE_STRING);

					$lname=test_input($_POST["lname"]);
					$lname=filter_var($lname,FILTER_SANITIZE_STRING);

					$email=test_input($_POST["email"]);	
					$email=filter_var($email,FILTER_SANITIZE_EMAIL);
				
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
					$username=filter_var($username,FILTER_SANITIZE_STRING);

					$pwd=test_input($_POST["pwd"]);
					$pwd=filter_var($pwd,FILTER_SANITIZE_STRING);
					$hashed_pwd=password_hash($pwd,PASSWORD_DEFAULT);

					$cpwd=test_input($_POST["cpwd"]);
					$cpwd=filter_var($cpwd,FILTER_SANITIZE_STRING);

					$username_sql="SELECT * FROM user WHERE UserName='$username'";
					$username_query=mysqli_query($connection,$username_sql);
					if(!mysqli_num_rows($username_query)>0)
					{	
					/** --not working--
					$username_sql=mysqli_prepare($connection,"SELECT * FROM user WHERE UserName=?");
					mysqli_stmt_bind_param($username_sql,'s',$username);
					$username_query=mysqli_stmt_execute($username_sql);
					echo "no= ".mysqli_stmt_num_rows($username_sql);
					if(!mysqli_stmt_num_rows($username_sql)>0)
					{
						mysqli_stmt_close($username_sql);
					**/
						echo "c";
						if((ctype_alpha($fname))&&(ctype_alpha($lname)))
						{
							echo "d";
							if(filter_var($email,FILTER_VALIDATE_EMAIL))
							{
								echo "e";
								$email=$email;
								
								if(getAge($bday)>6)
								{
									echo "f";
									if((strlen($username)<16)&&(preg_match("/^[a-zA-Z0-9_]+$/",$username)))
									{
										echo "g";
										if((strlen($pwd)>7)&&($pwd===$cpwd))
										{
											echo "h";
											/** --this works perfectly--
											$sql="INSERT INTO user (UserId,FirstName,LastName,Email,Birthday,Gender,Bias,UserName,Password) VALUES ('$userid','$fname','$lname','$email','$bday','$gender','$biases','$username','$hashed_pwd')";
											$query=mysqli_query($connection,$sql);
											echo "query= ".$query;
											**/
											
											//$bday=date("Y-m-d");  //this gives the current date
											//echo "bdate=".$bday;
											$bday=DateTime::createFromFormat("Y-m-d",$bday);  //for prepared statement
											$bday=$bday->format("Y-m-d");  //for prepared statement
											
											$sql=mysqli_prepare($connection,"INSERT INTO user (UserId,FirstName,LastName,Email,Birthday,Gender,Bias,UserName,Password) VALUES (?,?,?,?,?,?,?,?,?)");
											mysqli_stmt_bind_param($sql,'sssssssss',$userid,$fname,$lname,$email,$bday,$gender,$biases,$username,$hashed_pwd);
											$query=mysqli_stmt_execute($sql);

											if($query)
											{
												echo "i";
												/** --this works perfectly--
												$sql2="INSERT INTO userrole (UserId,RoleId) VALUES ('$userid','$role')";
												$query2=mysqli_query($connection,$sql2);
												if($query2)
												{
													echo "<script type='text/javascript'>window.location.href='login.html'; alert('Successfully registered');</script>";
													
													//header("Location: login.html");
												}		
												**/
												$sql2=mysqli_prepare($connection,"INSERT INTO userrole (UserId,RoleId) VALUES (?,?)");
												mysqli_stmt_bind_param($sql2,'ss',$userid,$role);
												$query2=mysqli_stmt_execute($sql2);
												if($query2)
												{
													echo "<script type='text/javascript'>window.location.href='login.html'; alert('Successfully registered');</script>";
													
													//header("Location: login.html");
												}
												mysqli_stmt_close($sql2);
											}
											mysqli_stmt_close($sql);
										}
									}
								}
							}
							else
							{
								
							}
							
						}
						else
						{
							echo "bla";
							echo "<script type='text/javascript'>alert('bla');</script>";
						} 
					}
					else
					{
						
						
						//$usernameTakenErr="This Username is not available";
						header("Location: signup.html");
						echo "<script type='text/javascript'>alert('Username taken');</script>";
						
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
					$userid="";
					$roleid="";

					$username=test_input($_POST["username"]);
					$username=filter_var($username,FILTER_SANITIZE_STRING);

					$pwd=test_input($_POST["pwd"]);
					$pwd=filter_var($pwd,FILTER_SANITIZE_STRING);
					$hashed_pwd=password_hash($pwd,PASSWORD_DEFAULT);

					$cpwd=test_input($_POST["cpwd"]);
					$cpwd=filter_var($cpwd,FILTER_SANITIZE_STRING);
					
					if((strlen($username)<16)&&(preg_match("/^[a-zA-Z0-9_]+$/",$username)))
					{
						echo "**  annyeong **";
						
						$username_sql="SELECT UserId,Password FROM user WHERE UserName='$username'";
						$username_query=mysqli_query($connection,$username_sql);
						if(mysqli_num_rows($username_query)===1)
						{
						
						/** --not working--
						$username_sql=mysqli_prepare($connection,"SELECT UserId,Password FROM user WHERE UserName=?");
						mysqli_stmt_bind_param($username_sql,'s',$username);
						$username_query=mysqli_stmt_execute($username_sql);
						echo "no= ".mysqli_stmt_num_rows($username_sql);
						if(mysqli_stmt_num_rows($username_sql)===1)
						{
						**/
							echo "**  oppa **";
							if($username_query)
							{
								echo "**  oraboni **";
								while($object=mysqli_fetch_object($username_query))
								{
									$userid=($object->UserId);
									$password=($object->Password);
								}
								
								//mysqli_stmt_bind_result($username_sql,$userid,$password);  --not working--
								echo "userid=".$userid."end of userid";
								echo "password=".$password."end of password";
								//echo "<script type='text/javascript'>alert($userid);</script>";
								//mysqli_stmt_close($username_sql); --not working--
								$role_sql="SELECT RoleId FROM userrole WHERE UserId='$userid'";
								$role_query=mysqli_query($connection,$role_sql);
								while($object_role=mysqli_fetch_object($role_query))
								{
									$roleid=($object_role->RoleId);
								}
								echo " roleid=".$roleid."end of roleid ";
								//echo "<script type='text/javascript'>alert($roleid);</script>";
								if((mysqli_num_rows($role_query)===1)&&($roleid==3))
								{
									echo " **eottoke** ";
									if(empty($password))
									{
										if((strlen($username)<16)&&(preg_match("/^[a-zA-Z0-9_]+$/",$username)))
										{
											echo "j";
											if((strlen($pwd)>7)&&($pwd===$cpwd))
											{
												echo "k";
												/** --this works perfectly--
												$sql="UPDATE user SET Password='$hashed_pwd' WHERE UserName='$username'";
												$query=mysqli_query($connection,$sql);
												echo "role1";
												**/
	
												$sql=mysqli_prepare($connection,"UPDATE user SET Password=? WHERE UserName=?");
												mysqli_stmt_bind_param($sql,'ss',$hashed_pwd,$username);
												$query=mysqli_stmt_execute($sql);
												if($query)
												{
													header("Location: login.html");
												}
											}
										}	
									}
									else
									{
										//echo "Already registered";
										//echo "<script type='text/javascript'>alert('Already registered');</script>";
										//header("Location: signup.html");
										echo "<script type='text/javascript'>window.location.href='signup.html'; alert('Already registered');</script>";
										
									}
																
								}
								else
								{
									echo "<script type='text/javascript'>window.location.href='signup.html'; alert('You are not a staff member. Please enter a valid username.'); </script>";
									//echo "You are not a staff member. Please enter a valid username";
									//header("Location: signup.html");
								}
							}
							
						}	
						else
						{
							
							header("Location: signup.html");
							
						}
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
	
	function getAge($bday)
	{
		$today=date("Y-m-d");
		$today=DateTime::createFromFormat("Y-m-d",$today);
		$birthdate=$bday;
		$birthdate=DateTime::createFromFormat("Y-m-d",$birthdate);
		$age=($today->format("Y"))-($birthdate->format("Y"));
		$month=($today->format("m"))-($birthdate->format("m"));
		$day=($today->format("d"))-($birthdate->format("d"));
		if(($month<0)||(($month===0)&&($day<0)))
		{
			$age=$age-1;
		}
		return $age;
	}
	
?>