<?
session_start();
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");
$Username = $_SESSION['Username'];
$Latitude = $_GET['latitude'];
$Longitude = $_GET['longitude'];

$query = "SELECT * 
		FROM Pinches
	    WHERE Datetime = ( 
		SELECT MAX(Datetime)
		FROM Pinches)";


/*$query =  "SELECT * , SQRT( POW( 69.1 * ( Latitude -$Latitude ) , 2 ) + POW( 69.1 * ($Longitude - Longitude ) * COS( Latitude / 57.3 ) , 2 ) ) AS distance
FROM Pinches
WHERE Latitude IS NOT NULL
ORDER BY distance, Datetime DESC
LIMIT 1"; 
 */
$result = mysql_query($query);  //Needs to check that it's only 1 row. I think this just grabs the first one.
$row = mysql_fetch_assoc($result);
echo json_encode(array("url" => $row['Photo'], "id" => $row['GUID']));
?>
