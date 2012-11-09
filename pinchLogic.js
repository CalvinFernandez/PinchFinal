
	window.URL = window.URL || window.webkitURL;
    $(document).on('pageshow', function() {
		
    imageSelect = document.getElementById("imageSelect");
	fileSelect = document.getElementById("fileSelect");
        fileSelect.addEventListener("click", function (e)
        {
            if (imageSelect)
            {
                imageSelect.click();
            }
            e.preventDefault();
        }, false);
    
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
        	img.setAttribute('id', "photo");
            img.src = window.URL.createObjectURL(files[0]);
		
		if (img.height > img.width)
			img.height = 200;
        else
			img.width = 200;
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
					displayPhotoOptions();	
				});
			}
		}	
		}
	}