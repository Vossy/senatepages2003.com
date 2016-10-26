function ToggleCurrentlyOnline()
{

	onlineDiv = document.getElementById("CurrentlyOnlineInner");
	outerDiv = document.getElementById("CurrentlyOnline");

	if(onlineDiv.style.display != "block")
	{
		onlineDiv.style.display = "block";
		outerDiv.style.width = "210px";
	}
	else
	{
		onlineDiv.style.display = "none";
		outerDiv.style.width = "20px";
	}

}