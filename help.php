<?php 
session_start(); 
?>
<!DOCTYPE html> 
<html>
<head>
<title>Pinchapp</title>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
<link rel="stylesheet" href="style.css" />
<link rel="apple-touch-icon" href="appicon.png" />
<link rel="apple-touch-startup-image" href="upstart.png">

<script src="jquery-1.8.2.min.js"></script>
<script src="jquery.mobile-1.2.0.js"></script>
<script src="hammer.js"></script>
<script src="jquery.hammer.js"></script>
<script src="myLogic.js"></script>
</head> 

<body>
<!-- Start of help page: #helpPage -->
<div data-role="page" id="helpPage">
      <div data-role="header">
       	  <h1>Pinch</h1>
<a href="logout.php">Log Out <?php echo $_SESSION['Username'] ?> </a>       
	</div><!-- /header -->

	<div data-role="content">
		<h2>Help</h2>		
		<p>After logging in, click on the Pinch page to:</p>
		<p>- Select or take a photo and "pinch" it with your fingers so others can access it.</p>
		<p>- Do the opposite gesture to get a picture someone nearby has already pinched.</p>
	</div><!-- /content -->
	
   <div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
        <div data-role="navbar" class="nav-glyphish-example">
            <ul>
                <li><a href="loggedIn.php" id="home" data-icon="custom">Home</a></li>
                <li><a href="pinch.php" id="beer" data-icon="custom">Pinch</a></li>
                <li><a href="help.php" id="help" data-icon="custom"class="ui-btn-active">Help</a></li>
            </ul>
        </div>
  </div>
</body>
</html>