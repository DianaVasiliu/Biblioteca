var setari = document.getElementsByClassName("dreapta");

var butoane = document.getElementsByClassName("setare");

for (let i = 0; i < butoane.length; i++) {
    butoane[i].onclick = function () {
        for (let j = 0; j < setari.length; j++) {
            if (i != j) {
                setari[j].style.display = "none";
            }
            else {
                setari[j].style.display = "flex";
            }
        }
    }
}

var sterge = document.getElementById("stergere");
var parinte = document.getElementById("div_stergere");

sterge.onclick = function (e) {
    e.preventDefault();
    var question = document.createElement("p");
    question.innerHTML = "Esti sigur ca vrei sa dezactivezi contul?";
    parinte.appendChild(question);

    var buton = document.createElement("input");
    buton.type = "submit";
    buton.name = "confirm"
    buton.value = "Da";
    buton.className = "submit";
    parinte.appendChild(buton);

    var buton = document.createElement("input");
    buton.type = "submit";
    buton.name = "renunta";
    buton.value = "Nu";
    buton.className = "submit";
    parinte.appendChild(buton);

}