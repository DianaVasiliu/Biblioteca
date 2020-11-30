var menu_div = document.getElementsByClassName("mobile_menu")[0];
var hamburger = document.getElementById("hamburger");

hamburger.onclick = function () {
    if (menu_div.style.display === "block") {
        menu_div.style.display = "none";
    } else {
        menu_div.style.display = "block";
    }
}
