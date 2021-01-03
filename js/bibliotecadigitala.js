// searchbar
var search = document.getElementById("search");

search.onkeyup = function () {
    var filter = search.value.toUpperCase();
    var searchListItems = document.querySelectorAll(".listacarti>li");

    for (let i = 0; i < searchListItems.length; i++) {
        var a = searchListItems[i].getElementsByTagName("a")[0];
        var text = a.innerText;

        if (text.toUpperCase().indexOf(filter) > -1) {
            searchListItems[i].style.display = "";
        }
        else {
            searchListItems[i].style.display = "none";
        }
    }
}