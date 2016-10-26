var editing = false;

try
{
	var ajax = new XMLHttpRequest();
}
catch (error)
{
 	try
	{
		var ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}
 	catch (error)
	{
		
	}
}

function beginCaptionEdit(id)
{


	if(editing == true)
		return;

	editing = true;

	container = document.getElementById("pictureCaptionContainer");
	height = container.offsetHeight + 25;
	text = document.getElementById("pictureCaptionText");

	text = text.innerHTML.replace(/\n/g, " ");

	formHTML = '<textarea id="newPictureCaptionText" style="width: 100%; height: ' + height + 'px; font-family: sans-serif;">' + text + '</textarea><br /><button onclick="endCaptionEdit(' + id + ')">Save</button>';
	container.innerHTML = formHTML;
}

function eventListner()
{
	if(ajax.readyState == 4 && ajax.status == 200)
		alert("Caption Saved");
	//else
	//	alert("ajax.readyState == " + ajax.readyState);

	return true;
}

function endCaptionEdit(id)
{
	editing = false;

	container = document.getElementById("pictureCaptionContainer");
	text = document.getElementById("newPictureCaptionText");

	captionHTML = '<p><strong>Caption:</strong> <span id="pictureCaptionText">' + text.value + '</span></p>';
	container.innerHTML = captionHTML;

	// actual AJAX saving goes here....

	ajax.open("POST", "/pictures/edit_submit.php?id=" + id, true);
	ajax.onreadystatechange = eventListner;
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("caption=" + escape(text.value));
	// alert("/pictures/edit_submit.php?id=" + id);

}

function deletePic(id)
{
	if(confirm("Are you sure you want to delete this picture? This cannot be undone."))
	{
		// delete the picture
		window.location = "http://www.senatepages2003.com/pictures/delete_confirm.php?id=" + id;
	};
}