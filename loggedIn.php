<?php session_start(); ?>
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
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script>
function getLocation()
  {
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
  else{x.innerHTML="Geolocation is not supported by this browser.";}
  }

function showPosition(position)
  {
  lat=position.coords.latitude;
  lon=position.coords.longitude;
  latlon=new google.maps.LatLng(lat, lon)
  mapholder=document.getElementById('mapholder')
  mapholder.style.height='100px';
  mapholder.style.width='160px';

  var myOptions={
  center:latlon,zoom:14,
  mapTypeId:google.maps.MapTypeId.ROADMAP,
  mapTypeControl:false,
  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
  };
  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
  var marker=new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
  }

function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="User denied the request for Geolocation."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="Location information is unavailable."
      break;
    case error.TIMEOUT:
      x.innerHTML="The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="An unknown error occurred."
      break;
    }
  }
  </script>



</head> 

<body>

<!-- Start of page -->
<div data-role="page" id="one">
  
<div data-role="header">
<h1>Pinch</h1>
<a href="logout.php">Log Out <?php echo $_SESSION['Username'] ?> </a>
</div><!-- header -->

<div data-role="content">	
   <h4>Welcome   <?php
          echo $_SESSION['Username'];
          ?> </h4>
    <p>You are currently at: </p> 
  <script> //getLocation();  
  </script>
 
<div id="mapholder"></div>
    </div><!-- /content -->
     

<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
<div data-role="navbar" class="nav-glyphish-example">
	<form action="upload.php" method="post" enctype="multipart/form-data">
        	<input type="file" id="imageSelect" style="display:none" onchange="handleFiles(this.files)">
		  
	</form>
		<ul>
                <li><a href="loggedIn.php" id="home" data-icon="custom" class="ui-btn-active">Home</a></li>
                <li><a href="pinch.php" id="beer" data-icon="custom" rel="external">Pinch</a></li>
                <li><a href="help.php" id="help" data-icon="custom">Help</a></li>
  		</ul>
</div>
</div>
</div><!-- /page one-->
</body>
</html>
