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
<!-- Start of loginPinch page: #loginPinch -->
<div data-role="page" id="loginPinch">

	<div data-role="header">
       	  <h1>Pinch</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<h2>Please log-in with a username to enable pinch </h2>		
		<div data-role="fieldcontain" class="ui-hide-label">
        <form action="registration_check.php" method="post">
        <input type="Text" name="Username" placeholder="Username"/><br>
	<input type="hidden" name="Page" value="Pinch">		  
        <input type="submit" value="Submit"/>
	</form>
      </div>
	</div><!-- /content -->
	
   <div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
        <div data-role="navbar" class="nav-glyphish-example">
            <ul>
                <li><a href="index.php" id="home" data-icon="custom">Home</a></li>
                <li><a href="loginPinch.php" id="beer" data-icon="custom" class="ui-btn-active">Pinch</a></li>
                <li><a href="loginHelp.php" id="help" data-icon="custom">Help</a></li>
            </ul>
        </div>
  </div>
</div><!-- end of #loginHelpPage -->
</body>
</html>
