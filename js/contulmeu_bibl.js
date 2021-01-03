var cerere_imprumut = document.getElementsByClassName("cerere_imprumut");

for (let i = 0; i < cerere_imprumut.length; i++) {
  cerere_imprumut[i].onclick = function() {
      let hidden = document.getElementsByClassName("hidden")[Math.floor(i / 2)];
      let li = document.getElementsByClassName("li_confirm_borrow")[Math.floor(i / 2)];
      let text = li.innerHTML.trim();

      hidden.value = text.substring(text.length - 10);
  }
}

var before = document.getElementById("before");
var motiv = document.getElementById("select_motiv");
var nr_zile = document.getElementById("nr_zile");
nr_zile.disabled = true;

motiv.onchange = function() {
  let value = motiv.selectedIndex;

  if (value == 2 || value == 3) {
    nr_zile.disabled = false;
  }
  else {
    nr_zile.disabled = true;
  }
}
