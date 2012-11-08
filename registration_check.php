<?
	$Username = $_POST["Username"];
    $Page = $_POST["Page"];
	//the example of inserting data with variable from HTML form
	//input.php
	mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
	mysql_select_db("c_cs147_goizueta");
	//inserting data order
	$order = "INSERT INTO Users
	            (Username)
	            VALUES
	            ('$Username')";
	 
	//declare in the order variable
	$result = mysql_query($order);  //order executes
	if($result){
	   	session_start();
	       	$_SESSION["Username"] = $Username;
		if ($Page == "Welcome") {
		     header("location:loggedIn.php");
		} else if ($Page == "Pinch") {
		      header("location:pinch.php");
		}
	} else{
         	if ($Page == "Welcome") {
		     header("location:index.php");
		} else if ($Page == "Pinch") {
		      header("location:loginPinch.php");
		}
	}
?>