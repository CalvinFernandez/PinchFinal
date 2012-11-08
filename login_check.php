<?php
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");
$Username = $_POST["Username"];
$Password = $_POST["Password"];

//needs to check for SQL injection and stuff

$sql="SELECT * FROM Users WHERE Username='$Username' and Password='$Password'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count==1){
	//session_register("$Username");
	//session_register("$Password");
	//session_start();
	header("location:#send");
} else {
	header("location:index.php#log");
	echo "<br> You fucked up</br>";
}
?>
