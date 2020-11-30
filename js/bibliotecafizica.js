var search = document.getElementById("searchbooks");
var cells = document.getElementsByClassName("tabledata");
var searchItems = document.querySelectorAll(".paragraphs");

search.onkeyup = function () {
    var filter = search.value.toUpperCase();

    for (var j = 0; j < cells.length; j++) {
        var ok = 0;
        for (var i = j * 4; i < (j + 1) * 4; i++) {
            var text = searchItems[i].innerText;

            if (text.toUpperCase().indexOf(filter) != -1) {
                cells[j].style.display = "";
                ok = 1;
            }
        }
        if (!ok) {
            cells[j].style.display = "none";
        }
    }
}

var select = document.getElementById('sortselect');
var select_submit = document.getElementById('sort');

if (!localStorage.getItem('selected_filter'))
    localStorage.setItem('selected_filter', 'original');

select_submit.onclick = function () {
    selecttext = select.value;
    window.localStorage.setItem('selected_filter', selecttext);
}

for (let i = 0; i < select.length; i++) {
    select.options[i].selected = select.options[i].value == localStorage.getItem('selected_filter');
}

window.onclose = function () {
    localStorage.removeItem("selected_filter");
}