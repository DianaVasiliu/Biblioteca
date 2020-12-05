var setari = document.getElementsByClassName("dreapta");

var butoane = document.getElementsByClassName("setare");

setari[0].display = "flex";

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


var imprumut = document.getElementById("btn_imprumut");

if (imprumut) {
    imprumut.onclick = function () {
    
        for (let i = 0; i < setari.length; i++) {
            setari[i].style.display = "none";
        }

        setari[setari.length - 1].style.display = "flex";
    }
}


var carte = document.getElementById("select_carte");
var data = document.getElementById("data_impr");
var formborr = document.getElementById("form_imprumut");

if (formborr) {
    formborr.onsubmit = function() {
        if (!data.value) {
            alert("Nu ai selectat o data!");
        }
        else {
            formborr.submit();
        }
        
        var option = carte.options[carte.selectedIndex].value;
        if (option == 0) {
            alert("Nu ai selectat o carte!");
        }
        else {
            formborr.submit();
        }

    }
}


var refreshButton = document.querySelector(".refresh-captcha");

if (refreshButton) {
    refreshButton.onclick = function() {
        document.querySelector(".captcha-image").src = 'requirements/captcha.php?' + Date.now();
    }
}


var calendar = document.getElementById('data_impr');

if (calendar) {
    calendar.addEventListener('input', function(e){
    var day = new Date(this.value).getUTCDay();

    if([0].includes(day)){
        e.preventDefault();
        this.value = '';
        alert('Duminica nu este valabila!');
    }

    });
}

