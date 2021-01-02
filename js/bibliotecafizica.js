var select = document.getElementById('sortselect');
var select_submit = document.getElementById('sort');
var links = document.getElementsByTagName("a");
var search_book = document.getElementById("search_book");

search_book.onclick = function () {
    localStorage.removeItem("selected_filter");
}

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

for (let i = 0; i < links.length - 1; i++) {
    links[i].onclick = function () {        
        localStorage.removeItem("selected_filter");
    }
}

