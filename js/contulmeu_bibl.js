var cerere_imprumut = document.getElementsByClassName("cerere_imprumut");

for (let i = 0; i < cerere_imprumut.length; i++) {
  cerere_imprumut[i].onclick = function() {
      let hidden = document.getElementsByClassName("hidden")[Math.floor(i / 2)];
      let li = document.getElementsByClassName("li_confirm_borrow")[Math.floor(i / 2)];
      let text = li.innerHTML.trim();

      hidden.value = text.substring(text.length - 10);
  }
}