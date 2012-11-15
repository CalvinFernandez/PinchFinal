<?
session_start();
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");
$Username = $_SESSION['Username'];
$query = "SELECT * 
		FROM Pinches
	    WHERE Datetime = ( 
		SELECT MAX(Datetime) 
		FROM Pinches )";

$result = mysql_query($query);  //Needs to check that it's only 1 row. I think this just grabs the first one.
$row = mysql_fetch_assoc($result);
echo json_encode(array("url" => $row['Photo'], "id" => $row['GUID']));
?>
