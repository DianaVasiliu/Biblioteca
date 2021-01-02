var select_carte = document.getElementsByClassName("select_carte");
var adaugare_titlu = document.getElementById("adaugare_titlu");
var nr = 1;

adaugare_titlu.onclick = function () {
    if (nr == 5) {
      alert("Numar maxim de titluri atins!");
    }
    else {
      nr++;
      
      let before = document.getElementById("before");
      let parent = document.getElementById("form_imprumut");

      let select = document.createElement("select");
      select.id = "select_carte";
      select.className = "select_carte";
      select.name = "carte" + nr;
      let options =  select_carte[0].options;

      for (let i = 0; i < options.length; i++) {
        select.options[select.options.length] = new Option(options[i].text, options[i].value);
      }

      parent.insertBefore(select, before);
    }
}