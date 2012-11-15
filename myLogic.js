
	/**
	*	Inspired by www.appliness.com. Source code at: riagora.com/mobile/hammer/hammer.zip
	*	Modified by Calvin Fernandez 	@Stanford University for CS147 cfernand@cs.stanford.edu
	*	Modified by Roberto Goizueta 	@Stanford University for CS147 goizueta@stanford.edu
	*	Modified by Cagla Kaymaz	@Stanford University for CS147 ckaymaz@stanford.edu	
	*	Last modified 2012 
	**/	

// JavaScript Document
$(function(){
        var zoomlisten = new ZoomListener('#pinch', '#pinch :first');
    });


function DisplayPhotoOptions()
{
		
}

function MakePicture(xhr)
{
	var response = JSON.parse(xhr.responseText);
	var img = document.createElement('img');
	img.setAttribute('id', 'newPhoto');
	img.setAttribute('src', response.url);
	img.onload = function ()
	{
		if (img.width > img.height)
			img.width = 200;
		else
			img.height = 200;
	
		var zoomDiv = document.createElement('div');
		zoomDiv.setAttribute("class", "zoomProps");
		zoomDiv.setAttribute("id", response.id);
		var styleDiv = document.createElement('div');
		styleDiv.setAttribute('class', 'polaroid upSky');
		
		zoomDiv.appendChild(styleDiv);
		styleDiv.appendChild(img);
		document.getElementById("main").appendChild(zoomDiv);
									
      		var imgID = "#" + response.id;
       	var hammerString = "#" + response.id + " :first";
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
	return img;
}

    /**
    * Inspired by Jesse Guardiani - May 1st, 2012
    */
	var zIndexBackup = 10;
	var itemsOnCanvas = 1;

    function DragView(target) {
      this.target = target[0];
      this.drag = [];
      this.lastDrag = {};

      
      this.WatchDrag = function()
      {
        if(!this.drag.length) {
          return;
        }

        for(var d = 0; d<this.drag.length; d++) {
          var left = $(this.drag[d].el).offset().left;
          var top = $(this.drag[d].el).offset().top;

          var x_offset = -(this.lastDrag.pos.x - this.drag[d].pos.x);
          var y_offset = -(this.lastDrag.pos.y - this.drag[d].pos.y);

          left = left + x_offset;
          top = top + y_offset;

          this.lastDrag = this.drag[d];

          this.drag[d].el.style.left = left +'px';
          this.drag[d].el.style.top = top +'px';
        }
      }

      this.OnDragStart = function(event) {
        var touches = event.originalEvent.touches || [event.originalEvent];
        for(var t=0; t<touches.length; t++) {
          var el = touches[t].target.parentNode;
		  
		  if(el.className.search('polaroid') > -1){
			  	
				 el = touches[t].target.parentNode.parentNode;
		  }
			el.style.zIndex = zIndexBackup + 1;
			zIndexBackup = zIndexBackup +1;
			
          if(el && el == this.target) {
			$(el).children().toggleClass('upSky');
            this.lastDrag = {
              el: el,
              pos: event.touches[t]
            };
            return; 
          }
		  
        }
      }

      this.OnDrag = function(event) {
        this.drag = [];
        var touches = event.originalEvent.touches || [event.originalEvent];
        for(var t=0; t<touches.length; t++) {
          var el = touches[t].target.parentNode;

		if(el.className.search('polaroid') > -1){
				 el = touches[t].target.parentNode.parentNode;
		  }
		  
          if(el && el == this.target) {
            this.drag.push({
              el: el,
              pos: event.touches[t]
            });
          }
        }
      }

      this.OnDragEnd = function(event) {
		  	this.drag = [];
        	var touches = event.originalEvent.touches || [event.originalEvent];
		 	for(var t=0; t<touches.length; t++) {
          			var el = touches[t].target.parentNode;
		  
		  			if(el.className.search('polaroid') > -1){
				 			el = touches[t].target.parentNode.parentNode;
		  			}
					$(el).children().toggleClass('upSky');
			
		  }
      }
    }

    //Helper function to determine pinch direction//
    function transformDirection(event, tch1, tch2)
    {
      var pinch = 0;
      var drop = 1;
      var e = event;
      //Pinch event if either x or y diff is smaller than previous x or y diff//
      if ( Math.abs(e.touches[0].x - e.touches[1].x) < Math.abs( tch1[0] - tch2[0] ) || 
            Math.abs(e.touches[0].y - e.touches[1].y ) < Math.abs( tch1[1] - tch2[1] ) )
      {
        return pinch;
      }
      //Drop event if either x or y difference is smaller than previous difference//
      if ( Math.abs(e.touches[0].x - e.touches[1].x) > Math.abs( tch1[0] - tch2[0] ) || 
            Math.abs(e.touches[0].y - e.touches[1].y ) > Math.abs( tch1[1] - tch2[1] ) )
      {
        return drop;
      }
      //No difference//
      return -1;
    }
    
    function wasPinch(pts1, pts2)
    {
        //Heuristically determine if event was a pinch //
        var len1 = pts1.length;
        var len2 = pts2.length;
        
        var start1  = pts1[0];
        var end1    = pts1[len1 - 1];
        
        var start2  = pts2[0];
        var end2    = pts2[len2 - 1];
       
	//Make sure the motion is actually a quick pinch. Otherwise it was just a slow closing of the fingers 
	if (len1 < 50)
	{
		//If the distance between the two fingers both x and y is less than 80//
		if ( Math.abs(end1[0] - end2[0]) < 80 )
		{
			if ( Math.abs(end1[1] - end2[1]) < 100 )
			{
				//If at least on of the two fingers traveled more than 100 in either the x or y direction//
				if ( ( Math.abs(start1[0] - end1[0]) >= 80 ) || ( Math.abs(start1[1] - end1[1]) >= 80 )
					|| (Math.abs(start2[0] - end2[0]) >= 80 ) || ( Math.abs(start2[1] - end2[1]) >= 80 ) )
				{
					//Check all the points with each other	//
					for ( i = 0; i < len1 - 1; i ++ )
					{
						var area1 = Math.max( 5, Math.abs( pts1[i][0] - pts2[i][0] ) ) * Math.max( 5, Math.abs( pts1[i][1] - pts2[i][1] ) );
						var area2 = Math.max( 5, Math.abs(pts1[i+1][0] - pts2[i+1][0] ) ) * Math.max( 5, Math.abs( pts1[i+1][1] - pts2[i+1][1] ) );
						if ( area1 - area2 + 100 < 0 )
						{
							return 0;
						}
					}		
				}
				else
				{
//					alert("at least one finger didn't travle more than 100 in either direction");
					return 0;
				}	
			}
			else
			{
//				alert("y pinch wasn't closed");
				return 0;
			}
        	}
		else
		{
//			alert("x pinch wasn't closed");
			return 0;
		}
	}
	else
	{
		return 0;
	}
        return 1;   
    }
	function wasDrop(pts1, pts2)
	{
	
		var len = pts1.length;
        	var start1  = pts1[0];
        	var end1    = pts1[len - 1];
        
        	var start2  = pts2[0];
        	var end2    = pts2[len - 1];
        
		//Only check after a certain number of points exist	//
		//After a certain number of points are in the array	//
		//The drop wasn't actually a dropping motion		//
		if (len > 12 && len < 25 )	
		{
			//If the distance between the two fingers both x and y is less than 80//
			if ( Math.abs(start1[0] - start2[0]) < 120 )
			{
				if ( Math.abs(start1[1] - start2[1]) < 120 )
				{
					// If at least one of the x or y is greater than 150 by the time of check//
					if ( Math.abs(end1[0] - end2[0]) > 150 || Math.abs(end1[1] - end2[1]) > 150 )
					{
						for ( i = 0; i < len - 1; i ++ )
						{
							var area1 = Math.max( 5, Math.abs( pts1[i][0] - pts2[i][0] ) ) * Math.max( 5, Math.abs( pts1[i][1] - pts2[i][1] ) );
							var area2 = Math.max( 5, Math.abs(pts1[i+1][0] - pts2[i+1][0] ) ) * Math.max( 5, Math.abs( pts1[i+1][1] - pts2[i+1][1] ) );
							if ( area2 < area1 - 100 )
							{
			//					alert("area not right");
							//	alert( area2 - area1);
								return 0;
							}
						}		
					}
					else
					{
			//			alert("fingers aren't far enough apart to merit a drop");
						return 0;	
					}	
				}
				else
				{
			//		alert("distance between start y fingers is wrong");
					return 0;
				}	
			}
			else
			{
			//	alert("distance between start x fingers is off");
				return 0;
			}
		}
		else 
		{
			return 0;		
		}
		return 1;
	}   
 
    function ZoomView(container, element) {
	container = $(container).hammer({
	    prevent_default: true,
            scale_treshold: 0,
            drag_min_distance: 0
        });
	element = $(element);

        var displayWidth = container.width();
        var displayHeight = container.height();

        //These two constants specify the minimum and maximum zoom
        var MIN_ZOOM = 0;
        var MAX_ZOOM = 3;

        var scaleFactor = 1;
        var previousScaleFactor = 1;

        //These two variables keep track of the X and Y coordinate of the finger when it first
        //touches the screen
        var startX = 0;
        var startY = 0;

        //These two variables keep track of the amount we need to translate the canvas along the X
        //and the Y coordinate
        var translateX = 0;
        var translateY = 0;

        //These two variables keep track of the amount we translated the X and Y coordinates, the last time we
        //panned.
        var previousTranslateX = 0;
        var previousTranslateY = 0;

	//To store all the points that we need to keep track of
	var pts1 = [];
	var pts2 = [];
	
        //Translate Origin variables

        var tch1 = 0, 
            tch2 = 0, 
            tcX = 0, 
            tcY = 0,
            toX = 0,
            toY = 0,
            cssOrigin = "";

        container.bind("transformstart", function(event){
            //We save the initial midpoint of the first two touches to say where our transform origin is.
            e = event

            tch1 = [e.touches[0].x, e.touches[0].y],
            tch2 = [e.touches[1].x, e.touches[1].y]
		
       		pts1 = [];
		pts2 = [];
		    
		pts1.push(tch1);
	        pts2.push(tch2);

            tcX = (tch1[0]+tch2[0])/2,
            tcY = (tch1[1]+tch2[1])/2

            toX = tcX
            toY = tcY

            var left = $(element).offset().left;
            var top = $(element).offset().top;

            cssOrigin = (-(left) + toX)/scaleFactor +"px "+ (-(top) + toY)/scaleFactor +"px";
        })

        container.bind("transform", function(event) {
              e = event;
		scaleFactor = previousScaleFactor * event.scale;
			
              scaleFactor = Math.max(MIN_ZOOM, Math.min(scaleFactor, MAX_ZOOM)); 
	      transform(event);
            tch1 = [e.touches[0].x, e.touches[0].y],
            tch2 = [e.touches[1].x, e.touches[1].y]
        	pts1.push(tch1);  
        	pts2.push(tch2);
	});

        container.bind("transformend", function(event) {
            previousScaleFactor = scaleFactor;
        	var p = wasPinch(pts1, pts2);
		if ( p == 1)
		{	    
			container.html(""); 
			container.remove();
			container = null;
			delete container;
			$("#alert").fadeIn("slow", function h()
			{
				$(this).fadeOut(3000);
			});	
		}
		if (scaleFactor < 1 )
		{
			scaleFactor = 1;
			previousScaleFactor = 1;
			transform(event);
		}
	});


        /**
        * on drag
        */
        var dragview = new DragView($(container));
        container.bind("dragstart", $.proxy(dragview.OnDragStart, dragview));
        container.bind("drag", $.proxy(dragview.OnDrag, dragview));
        container.bind("dragend", $.proxy(dragview.OnDragEnd, dragview));

        setInterval($.proxy(dragview.WatchDrag, dragview), 10);



        function transform(e) {
            //We're going to scale the X and Y coordinates by the same amount
            var cssScale = "scaleX("+ scaleFactor +") scaleY("+ scaleFactor +") rotateZ("+ e.rotation +"deg)";

            element.css({
                webkitTransform: cssScale,
                webkitTransformOrigin: cssOrigin,

                transform: cssScale,
                transformOrigin: cssOrigin,
            });

            
        }

    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    var numGetItems = 0;
    var transforming = true;
    var pts1 = [];
    var pts2 = [];
	var dropped = 0; 
	
    function ZoomListener(container, element) 
    {
        var tch1 = 0, 
            tch2 = 0;

        container = $(container).hammer({
            prevent_default: true,
            scale_treshold: 0,
            drag_min_distance: 0
        });

        element = $(element);

        container.bind("transformstart", function(event){
            var e = event;
            tch1 = [e.touches[0].x, e.touches[0].y],
            tch2 = [e.touches[1].x, e.touches[1].y]
       		pts1 = [];
		    pts2 = [];
		    
		    pts1.push(tch1);
	        pts2.push(tch2);
	 })

        container.bind("transform", function(event) {
            var e = event;
            tch1 = [e.touches[0].x, e.touches[0].y],
            tch2 = [e.touches[1].x, e.touches[1].y]
      		pts1.push(tch1);  
        	pts2.push(tch2);
		var d = wasDrop(pts1, pts2);
		if ( d == 1 && dropped == 0)
		{
			dropped = 1				
			xhr = new XMLHttpRequest();
			xhr.open("GET", "QueryDatabase.php", true);			
			xhr.send();
			xhr.onreadystatechange = function(e)	
			{
			
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					MakePicture(xhr);
					/*var response = JSON.parse(xhr.responseText);
					var img = document.createElement('img');
					img.setAttribute('id', 'newPhoto');
					img.setAttribute('src', response.url);
					if (img.width > img.height)
						img.width = 200;
					else
						img.height = 200;	
					var zoomDiv = document.createElement('div');
					zoomDiv.setAttribute("class", "zoomProps");
					zoomDiv.setAttribute("id", response.id);
					var styleDiv = document.createElement('div');
					styleDiv.setAttribute('class', 'polaroid upSky');
		
					zoomDiv.appendChild(styleDiv);
					styleDiv.appendChild(img);
					document.getElementById("main").appendChild(zoomDiv);
									
                 			var imgID = "#" + response.id;
                            		var hammerString = "#" + response.id + " :first";*/
				}
			}
		}	
	});

        container.bind("transformend", function(event) {
		dropped = 0;	
	});
		
}
