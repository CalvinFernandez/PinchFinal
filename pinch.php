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

  <script>
    window.URL = window.URL || window.webkitURL;
    $(document).ready(function() {

        var imageSelect = document.getElementById("imageSelect");
            fileSelect = document.getElementById("fileSelect");
   		databaseQ = document.getElementById("getImage");
	databaseQ.addEventListener("click", function(e)
	{
		//Here you want to query the database for any image with my id as the owner or recipient.
		//Do this with ajax get request. Make a new file called QueryDatabase.php where you will 
		//be doing this. Additionally, look at upload.php and store stuff into the sql table 
		//there so that they can be accessed by QueryDatabase.php. Displaying images can be done
		//by looking at the function HandleFiles, two below this one.   
		var xhr;
		if (window.XMLHttpRequest) 
		{
  		xhr = new XMLHttpRequest();
 		}
		xhr.onreadystatechange = xhrHandler;
		var senderName = "FinalAttempt";
		var url= "QueryDatabase.php";
		xhr.open("GET", url, true);
		xhr.send();
	
	
		function HandleResponse(response)
		{
 		var img = document.createElement("img");
        img.setAttribute('id', "newPhoto");
        img.setAttribute('src', response);
        
        var parent = document.getElementById('pinch');
        parent.appendChild(img);
        
        if (img.height > img.width)
			img.height = 200;
                else
			img.width = 200;
		
		}
		
		function xhrHandler() 
		{
 			if (this.readyState == 4) 
 			{
 				HandleResponse(xhr.responseText);
 			}
 		}
		
	 });
	 
	 
        fileSelect.addEventListener("click", function (e)
        {
            if (imageSelect)
            {
                imageSelect.click();
            }
            e.preventDefault();
        }, false);
    
    });
	//Handle Files handles all input files from the user//
	//This will display a selected image and then post 
	//to the database
        function handleFiles(files)
        {
            if (files.length > 0)
            {
                var img = document.createElement("img");
               	img.setAttribute('id', "currPhoto");
                img.src = window.URL.createObjectURL(files[0]);
		
		if (img.height > img.width)
			img.height = 200;
                else
			img.width = 200;
	
		var content = document.getElementById("polaroidSend");
                content.innerHTML = "";
                content.appendChild(img);
                content.style.opacity='1.0';
                //Submit item to server//
			var formData = new FormData(document.getElementById("imageForm"));
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'upload.php', true);
			xhr.send(formData);
        	}
	}
</script> 

</head> 

<body>
<!-- Start of pinch page: #pinch -->

<div data-role="page">
	<div data-role="header" id="output" style="height:auto;"><!-- added output here -->
        	<h1>Pinch</h1>
		<!-- Hidden form for that uploads image to server as soon as it has been selected -->	
		<form id="imageForm" method="post" enctype="multipart/form-data" style="hidden">
			<input type="file" name="file" id="imageSelect" class="ui-btn-right" style="display:none" onchange="handleFiles(this.files)"/>
			<input type='text' name='Receiver' style ="display:none;" value = "Cagla"/>
			<!--This is where you have to set the receiver!!!!!!!!!!!!!!!-->
		</form>	
		<a data-icon="Camera-icon.gif" id="fileSelect" class="ui-btn-right">Photos</a>
		<a id="getImage" class="ui-btn-left">Query Database</a>
		<a class="ui-btn-left" style="left:150px;" href="logout.php">Log Out <?php echo $_SESSION['Username'] ?> </a>
	</div><!-- /header -->
	<div id="pinch" style="top:40px; bottom:30px; width:100%; position:absolute;">
	</div>
	<div id="zoom" class="zoomProps">
		<div id="polaroidSend" class="polaroid">
			<!--<img id="img" src="images/screen.jpg" alt="" width="200" height="200" />-->
			<span> My pic </span>
		</div>
    	</div>
    <div data-role="footer" id="foot" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
        <div data-role="navbar" class="nav-glyphish-example">
            <ul>
                <li><a href="loggedIn.php" id="home" data-icon="custom" >Home</a></li>
                <li><a href="pinch.php" id="beer" data-icon="custom" class="ui-btn-active">Pinch</a></li>
                <li><a href="help.php" id="help" data-icon="custom">Help</a></li>
            </ul>
        </div>
    </div>
</div><!-- / pinch page -->
</body>
</html>
