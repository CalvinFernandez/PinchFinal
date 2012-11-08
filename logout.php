<?PHP
session_start();
$Username = $_SESSION['Username'];
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");

$query = "DELETE FROM Users WHERE Username = '$Username'";
$result = mysql_query($query);
session_destroy();
header("location:index.php");
exit();
?>
