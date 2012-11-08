

<?
$Username = $_POST["Username"];
$Photo = $_POST["Photo"];
mysql_connect('mysql-user-master.stanford.edu', 'ccs147goizueta', 'nookohte');//database connection
mysql_select_db("c_cs147_goizueta");


echo $Username;
echo "BUULLASD";
echo $Photo;



//needs to check for SQL injection and stuff

$order = "INSERT INTO Pinches
	            (Username, Photo)
	            VALUES
	            ('$Username',
	            '$Photo')";

//declare in the order variable
	$result = mysql_query($order);  //order executes
	if($result){
		echo "Nice job, punk!";
	} else{
	    echo "You fucked up.";
	    //needs to check if register is good
	}
?>
