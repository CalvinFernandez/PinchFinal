<?
header('cache-control: no-cache');
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');
mysql_select_db("c_cs147_goizueta");
$GUID = $_POST["guid"];
$Long = $_POST["longitude"];
$Lat = $_POST["latitude"];
echo "Here is my guid:";
echo $GUID;
		$date_t = date("Y-m-d H:i:s");
		$query = "UPDATE Pinches 
				SET Datetime = '$date_t', Longitude = '$Long', Latitude = '$Lat'
				WHERE GUID = '$GUID'";
		
		$result = mysql_query($query);
		//echo $query;
		if(!($result)){
			echo "bad query";
		}

?>