$(document).ready(function()
{
	var touchMask = document.getElementById("touch");
	var top_y = document.getElementById("output").height;
	var bottom_y = document.getElementById("foot").top;

	touchMask.style.top = top_y + 'px';
	touchMask.style.height = top_y - bottom_y; 
});
