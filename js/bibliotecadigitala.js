
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


var resetInputs = document.getElementsByTagName("input");
for (let i = 0; i < resetInputs.length; i++) {
    if (resetInputs[i].classList != "noreset")
        resetInputs[i].value = '';
}







///////////////////////////

var upload = document.getElementById("uploadfile");    // butonul de add files
var selectCat = document.getElementById("selectcat");   //categoria selectata

var category = "--Alege--";      //numele categoriei alese
var categoryIndex = 0;      //indexul categoriei alese

selectCat.onchange = function () {
    categoryIndex = selectCat.selectedIndex;
    category = selectCat.options[categoryIndex - 1].text;
}

var autor = document.getElementById("autor");
var titlu = document.getElementById("titlu_carte");

upload.onclick = function (e) {
    if (categoryIndex == 0) {
        alert("Nu ai ales o categorie!");
        e.preventDefault();
    }
    else if (titlu.value == "") {
        alert("Nu ai setat o informatie despre carte!");
        e.preventDefault();
    }
    else {
        var ok = 1;
        var catList = document.querySelectorAll(".column>ol");   // vectorul de liste ordonate
        var books = catList[categoryIndex - 1].getElementsByTagName("a");
        for (let i = 0; i < books.length && ok; i++) {
            var name = books[i].download;
            for (let j = 0; j < uploadedFiles.length; j++) {
                if (name == uploadedFiles[j].name) {
                    ok = 0;
                }
            }
        }

        if (ok) {
            // for (let i = 0; i < uploadedFiles.length; i++) {
            //     var newBookList = document.createElement("li");
            //     catList[categoryIndex - 1].appendChild(newBookList);
            //     var newBook = document.createElement("a");
            //     newBook.href = "./pdf_files/" + uploadedFiles[i].name;
            //     newBook.download = uploadedFiles[i].name;
            //     newBookList.appendChild(newBook);
            //     newBook.innerHTML = uploadedFiles[i].name;
            // }
        }
        else {
            alert("Fisier deja existent!");
        }
    }
}
