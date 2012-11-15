var id;


function getImage()
{
	if(navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(getData, showError);
	}
}

function getData(position)
{
	$.ajax({
			url: "QueryDatabase.php",
			type: "get",
			data: 
			{
				latitude: position.coords.latitude,
       	 		longitude: position.coords.longitude
			},
			success: function(response, textStatus, jqXHR)
			{
				MakePicture(jqXHR);
				console.log(response);
			}
		});
		
}

function updateImageData(photoID)
  {
  if (navigator.geolocation)
    {
    	id = photoID;
    	navigator.geolocation.getCurrentPosition(pushData,showError);
    }
  }

function pushData(position)
  {	
  	$.ajax({
       	 url: "addTimestamp.php",
       	 type: "post",
       	 data: {guid: id,
       	 		latitude: position.coords.latitude,
       	 		longitude: position.coords.longitude},
        // callback handler that will be called on success
        success: function(response, textStatus, jqXHR){
            // log a message to the console
            console.log("Hooray, it worked!");
        },
        // callback handler that will be called on error
        error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
        }
        });
  }

function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation. To allow geolocation on the Iphone, go to Settings > General > Reset location and Privacy");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.");
      break;
    }
  }