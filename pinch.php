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



</head> 

<body>
<!-- Start of pinch page: #pinch -->
<div data-role="page" id="main">
<script src="myLogic.js"></script>
<script src="thumbnailer.js"></script>
<script>
	window.URL = window.URL || window.webkitURL;
    	$(document).on('pageshow', function() {	
		imageSelect = document.getElementById("imageSelect");
		fileSelect = document.getElementById("fileSelect");
        	fileSelect.onclick = function (e)
        	{
            		if (imageSelect)
            		{
                		imageSelect.click();
            		}
            		e.preventDefault();
        	}
    
    	});

	function displayPhotoOptions()
	{
	
	}
	//Handle Files handles all input files from the user//
	//This will display a selected image and then post 
	//to the database
    function handleFiles(files)
    {
        if (files.length > 0)
        {
        	var img = document.createElement("img");
            img.src = window.URL.createObjectURL(files[0]);
		img.onload = function()
		{
			if (img.width > img.height)
				img.width = 200;
			else
				img.height = 200;

			var formData = new FormData(document.getElementById("imageForm"));
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'upload.php/no-cache?' + Date.now(), true);
			xhr.setRequestHeader("pragma", "no-cache");
			xhr.send(formData);
        		xhr.onreadystatechange = function()
			{
				if (xhr.readyState == 4 && xhr.status==200)
				{
					var zoomDiv = document.createElement('div');
					zoomDiv.setAttribute("id", xhr.responseText);
					zoomDiv.setAttribute("class", "zoomProps");
			
					var styleDiv = document.createElement('div');
					styleDiv.setAttribute('class', 'polaroid upSky');
				
					zoomDiv.appendChild(styleDiv);
					styleDiv.appendChild(img);
					document.getElementById("main").appendChild(zoomDiv);
					var imgID = "#" + xhr.responseText;
					var hammerString = "#" + xhr.responseText + " :first";
					var z = new ZoomView(imgID, hammerString); 				
					$(imgID).bind('tap', function(e)
					{
						tappedImg = this; //The image that we tapped //
						tappedImg.style.webkitUserSelect = "auto";
						if ( document.getElementById("tapOptions").style.display == "none")
						{
							document.getElementById("foot").style.display = "none";	
							document.getElementById("tapOptions").style.display= "inline";
							$('#save').bind('click', function()
							{
								var i = document.createElement("img");
								i.setAttribute("id", "saveImg");
								i.src = tappedImg.getElementsByTagName("img")[0].src;
								i.onload = function()
								{
									if (i.width > i.height)
										i.width = 200;
									else
										i.height = 200;

									var save_image_content = document.getElementById("save_image_content");
									save_image_content.innerHTML = "";
									save_image_content.appendChild(i);
								}				
							});
							$('#delete').bind('click', function(e)
							{
								tappedImg.parentNode.removeChild(tappedImg);
								document.getElementById("foot").style.display = "inline";
								document.getElementById("tapOptions").style.display = "none";
							
							});
						}
						else 
						{
							document.getElementById("foot").style.display = "inline";
							document.getElementById("tapOptions").style.display = "none";
						}
					});
				}
			}	
		}
		}
	}
	
</script> 
	<div data-role="header" id="output" style="height:auto;"><!-- added output here -->
        	<h1>Pinch</h1>
        	<!-- Hidden form for that uploads image to server as soon as it has been selected -->	
		<form id="imageForm" method="post" enctype="multipart/form-data" style="hidden">
			<input type="file" name="file" id="imageSelect" class="ui-btn-right" style="display:none" onchange="handleFiles(this.files)"/>
		</form>	
		<a data-icon="Camera-icon.gif" id="fileSelect" class="ui-btn-right">Photos</a>
		<a class="ui-btn-left" href="logout.php">Log Out <?php echo $_SESSION['Username'] ?> </a>
	</div><!-- /header -->
	<div id="alert"> <h1> You pinched a photo! </h1></div>
	<div id="pinch" style="top:40px; bottom:30px; width:100%; position:absolute; -webkit-user-select: auto !important;"><!-- /Overlay handling drop detection -->
	</div>
	<div data-role="footer" id="tapOptions" data-id="samebar" class="nav-glyphis-example" data-position="fixed" data-tap-toggle="false" style="display:none">
		<div data-role="navbar" class="nav-glyphish-example">
			<ul>
				<li><a id="save" href="#saver" data-icon="custom">Save</a></li>
				<li><a id="delete" data-icon="custom">Delete</a></li>
			</ul>
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

<div data-role="page" id="saver" data-theme="a" data-url="saver" tabindex="0" class="ui-page ui-body-a" style="min-height: 125px;">
	<div data-role="header" class="ui-header ui-bar-a" role="banner">
		<h1>Tap and hold image to save</h1>
	</div>
	<div id="save_image_content" style="position:absolute;">
	</div>
	<div data-role="footer" id="saveHome" data-id="samebar" class="nav-glyphis-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example">
			<ul>
				<li><a href="pinch.php" id="back" data-icon="custom" data-prefetch>Back to Pinch</a></li>
			</ul>
		</div>
	</div>

</div>

</body>
</html>
