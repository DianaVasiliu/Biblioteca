var auth = document.getElementById("auth");

auth.onclick = function () {
	var locatie = document.getElementsByTagName("head")[0];
	var link = document.createElement("link");
	locatie.appendChild(link);
	link.rel = "stylesheet";
	link.href = "loginform.css";
	document.getElementsByClassName("container")[0].style.display = "block";
	document.getElementsByTagName("header")[0].style.display = "none";
	document.getElementById("corp").style.display = "none";
}



