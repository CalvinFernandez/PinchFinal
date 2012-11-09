<?
header('cache-control: no-cache');
function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

//session_start();
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");
$Receiver = $_POST["Receiver"];
if ($_FILES["file"]["error"] > 0)
{
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else
{
		echo $_FILES["file"];
		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);

		$path = "upload/" . $_FILES["file"]["name"];
		$guid = GUID();
		echo $guid;

		$CurrUser = $_SESSION['Username'];
		$date_t = date("Y-m-d H:i:s");
		$query = "INSERT INTO Pinches 
				(Username, Photo, GUID,  Receiver, Datetime) 
				VALUES
				('$CurrUser','$path', '$guid', '$Receiver', '$date_t')";
		
		$result = mysql_query($query);
		//echo $query;
		if(!($result)){
			echo "something";
		}
}

?>