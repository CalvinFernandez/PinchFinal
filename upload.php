<?
session_start();
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");
$Receiver = $_POST["Receiver"];
echo 'Script Path: ' .$_SERVER['SCRIPT_NAME'] . '<br/>Absolute Path: ' . $_SERVER['SCRIPT_FILENAME'] . '<br/>';
if ($_FILES["file"]["error"] > 0)
{
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else
{
		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
		echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		$path = "upload/" . $_FILES["file"]["name"];
		echo "Check this user out: ";
		$CurrUser = $_SESSION['Username'];
		echo $CurrUser;
		$query = "INSERT INTO Pinches 
				(Username, Photo, Receiver) 
				VALUES
				('$CurrUser','$path', '$Receiver')";
		
		$result = mysql_query($query);
		if(!($result)){
		echo "You suck, really\n";
		echo "Also, here's the query:'$query'";
		} else{
		echo "good job, minger!";
		echo "Also, here's the query:'$query'";
		}
}
?>
