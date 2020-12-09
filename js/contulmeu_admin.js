var table_select_insert = document.getElementById("table_select_insert");
var table_select_update = document.getElementById("table_select_update");
var table_select_delete = document.getElementById("table_select_delete");

var form = document.getElementsByClassName("admin_form");
var submit = document.getElementsByClassName("admin_submit");

table_select_insert.onchange = function () {
  var action = "insert";

  if (table_select_insert.selectedIndex == 1) {
      delete_from_book(action, 0);
      delete_from_user_codes(action, 0);

      // insert into autor
      author_form(action);
  }
  else if (table_select_insert.selectedIndex == 2) {
    delete_from_author(action, 0);
    delete_from_user_codes(action, 0);

    // insert into carte
    book_form(action);
  }
  else if (table_select_insert.selectedIndex == 3) {
    delete_from_author(action, 0);
    delete_from_book(action, 0);

    // insert into coduri_utilizatori
    user_code_form(action);
  }
  else {
    delete_from_author(action, 0);
    delete_from_book(action, 0);
    delete_from_user_codes(action, 0);
  }

}

table_select_update.onchange = function () {
  var action = "update";

  if (table_select_update.selectedIndex == 1) {
    // update carte
    book_form(action);
  }
  else {
    delete_from_book(action, 1);
  }
}

table_select_delete.onchange = function () {
  var action = "delete";

  if (table_select_delete.selectedIndex == 1) {
    delete_from_book(action, 2);

    // delete from autor
    author_form(action);
  }
  else if (table_select_delete.selectedIndex == 2) {
    delete_from_author(action, 2);

    // delete from carte
    book_form(action);
  }
  else {
    delete_from_author(action, 2);
    delete_from_book(action, 2)
  }
}

function delete_from_author (action, i) {
  var input_nume_del1 = document.getElementById("nume_autor_" + action);
  var input_nume_del2 = document.getElementById("prenume_autor_" + action);
  var h3_nume_del = document.getElementById("h3_nume_" + action);
  var h51_nume_del = document.getElementById("titlu_nume_" + action);
  var h52_nume_del = document.getElementById("titlu_prenume_" + action);

  if (input_nume_del1 && input_nume_del2 && h3_nume_del && h51_nume_del && h52_nume_del) {
      form[i].removeChild(input_nume_del1);
      form[i].removeChild(input_nume_del2);
      form[i].removeChild(h3_nume_del);
      form[i].removeChild(h51_nume_del);
      form[i].removeChild(h52_nume_del);
  }

}

function delete_from_book (action, i) {
    var h3_titlu_carte_del = document.getElementById("h3_titlu_carte_" + action);
    var titlu_carte_del = document.getElementById("titlu_carte_" + action);
    if (action === 'insert') {
      var h3_autori_del = document.getElementById("h3_autori_" + action);
      var autori_del = document.getElementById("autori_" + action);
    }
    else if (action === 'update') {
      var h3_titlu_nou_del = document.getElementById("h3_titlu_nou_" + action);
      var titlu_nou_del = document.getElementById("titlu_nou_" + action);
    }
    var h3_tip_del = document.getElementById("h3_tip_" + action);
    var div_radio_tip_carte_del = document.getElementById("div_radio_tip_carte_" + action);
    var h3_categorie_del = document.getElementById("h3_categorie_" + action);
    var id_categorie_del = document.getElementById("id_categorie_" + action);
    var h3_an_del = document.getElementById("h3_an_" + action);
    var an_del = document.getElementById("an_" + action);
    var h3_editura_del = document.getElementById("h3_editura_" + action);
    var editura_del = document.getElementById("editura_" + action);
    if (action !== 'delete') {
      var h3_stoc_del = document.getElementById("h3_stoc_" + action);
      var stoc_del = document.getElementById("stoc_" + action);
      var h3_descriere_del = document.getElementById("h3_descriere_" + action);
      var descriere_del = document.getElementById("descriere_" + action);
      var h3_url_del = document.getElementById("h3_url_" + action);
      var h5_poza_del = document.getElementById("h5_poza_" + action);
      var h5_url_del = document.getElementById("h5_url_" + action);
      var url_fisier_del = document.getElementById("url_fisier_" + action);
    }

    if (h3_titlu_carte_del && titlu_carte_del && h3_categorie_del && id_categorie_del && h3_an_del && an_del && h3_editura_del && editura_del) {
      form[i].removeChild(h3_titlu_carte_del);
      form[i].removeChild(titlu_carte_del);
      if (action === 'insert') {
        form[i].removeChild(h3_autori_del);
        form[i].removeChild(autori_del);
      }
      else if (action === 'update') {
        form[i].removeChild(h3_titlu_nou_del);
        form[i].removeChild(titlu_nou_del);
      }
      form[i].removeChild(h3_tip_del);
      form[i].removeChild(div_radio_tip_carte_del);
      form[i].removeChild(h3_categorie_del);
      form[i].removeChild(id_categorie_del);
      form[i].removeChild(h3_an_del);
      form[i].removeChild(an_del);
      form[i].removeChild(h3_editura_del);
      form[i].removeChild(editura_del);
      if (action !== 'delete') {
        form[i].removeChild(h3_stoc_del);
        form[i].removeChild(stoc_del);
        form[i].removeChild(h3_descriere_del);
        form[i].removeChild(descriere_del);
        form[i].removeChild(h3_url_del);
        form[i].removeChild(h5_poza_del);
        form[i].removeChild(h5_url_del);
        form[i].removeChild(url_fisier_del);
      }
    }
}

function delete_from_user_codes (action, i) {
  var input_cod_del = document.getElementById("cod_utilizator_" + action);
  var h3_cod_del = document.getElementById("h3_cod_" + action);
  var h3_tip_del = document.getElementById("h3_tip_" + action);
  var div_radio_tip_del = document.getElementById("div_radio_tip_" + action);

  if (input_cod_del && h3_cod_del && h3_tip_del && div_radio_tip_del) {
      form[i].removeChild(input_cod_del);
      form[i].removeChild(h3_cod_del);
      form[i].removeChild(h3_tip_del);
      form[i].removeChild(div_radio_tip_del);
  }
}



function initialize_i (action) {
  var i = -1;
  if (action === 'insert') {
    i = 0;
  }
  else if (action === 'update') {
    i = 1;
  }
  else if (action === 'delete') {
    i = 2;
  }

  return i;
}

function book_form(action) {
  var i = initialize_i(action);

  var h3_titlu = document.createElement("h3");
  h3_titlu.id = "h3_titlu_carte_" + action;
  h3_titlu.innerHTML = "Titlul cartii:";
  var input1 = document.createElement("input");
  input1.id = 'titlu_carte_' + action;
  input1.name = 'titlu_carte_' + action;
  input1.style.marginLeft = 0;
  input1.style.width = "30%";

  var h3_categorie = document.createElement("h3");
  h3_categorie.id = "h3_categorie_" + action;
  h3_categorie.innerHTML = "Id-ul categoriei:";
  var input2 = document.createElement("input");
  input2.id = 'id_categorie_' + action;
  input2.name = 'id_categorie_' + action;
  input2.style.marginLeft = 0;
  input2.style.width = "10%";

  var h3_an = document.createElement("h3");
  h3_an.id = "h3_an_" + action;
  h3_an.innerHTML = "Anul publicarii:";
  var input3 = document.createElement("input");
  input3.id = 'an_' + action;
  input3.name = 'an_' + action;
  input3.type = "number";
  input3.min = "1900";
  input3.max = new Date().getFullYear();
  input3.style.marginLeft = 0;
  input3.style.width = "15%";

  var h3_editura = document.createElement("h3");
  h3_editura.id = "h3_editura_" + action;
  h3_editura.innerHTML = "Editura:";
  var input4 = document.createElement("input");
  input4.id = 'editura_' + action;
  input4.name = 'editura_' + action;
  input4.style.marginLeft = 0;
  input4.style.width = "30%";

  var h3_tip = document.createElement("h3");
  h3_tip.id = "h3_tip_" + action;
  h3_tip.innerHTML = "Tipul de carte:";
  var radio1 = document.createElement("input");
  radio1.id = "radio_fizica_" + action;
  radio1.type = "radio";
  radio1.name = "radio_tip_carte_" + action;
  radio1.value = "fizica";
  radio1.style.marginLeft = 0;
  radio1.style.marginRight = ".5pc";
  var label1 = document.createElement("label");
  label1.innerHTML = "Fizica";
  label1.for = "radio_fizica_" + action;
  var radio2 = document.createElement("input");
  radio2.id = "radio_digitala_" + action;
  radio2.type = "radio";
  radio2.name = "radio_tip_carte_" + action;
  radio2.value = "digitala";
  radio2.style.marginRight = ".5pc";
  var label2 = document.createElement("label");
  label2.innerHTML = "Digitala";
  label2.for = "radio_digitala_" + action;

  var div_radio = document.createElement("div");
  div_radio.id = "div_radio_tip_carte_" + action;
  div_radio.style.display = "flex";
  div_radio.style.justifyContent = "space-between";
  div_radio.style.alignItems = "center";
  div_radio.appendChild(radio1);
  div_radio.appendChild(label1);
  div_radio.appendChild(radio2);
  div_radio.appendChild(label2);

  if (action !== 'delete') {
    var h3_stoc = document.createElement("h3");
    h3_stoc.id = "h3_stoc_" + action;
    h3_stoc.innerHTML = "Stoc:";
    var input5 = document.createElement("input");
    input5.id = 'stoc_' + action;
    input5.name = 'stoc_' + action;
    input5.type = "number";
    input5.min = 0;
    input5.max = 100;
    input5.style.marginLeft = 0;
    input5.style.width = "10%";

    var h3_descriere = document.createElement("h3");
    h3_descriere.id = "h3_descriere_" + action;
    h3_descriere.innerHTML = "Descriere:";
    var textarea = document.createElement("textarea");
    textarea.id = 'descriere_' + action;
    textarea.name = 'descriere_' + action;
    textarea.style.marginLeft = 0;
    textarea.style.width = "70%";
    textarea.style.maxWidth = "90%";
    textarea.style.maxHeight = "40vh";
    textarea.style.padding = "1pc";
    textarea.style.height = "10vh";
    textarea.style.overflowY = "auto";
    textarea.style.border = "none";

    var h3_url = document.createElement("h3");
    h3_url.id = "h3_url_" + action;
    h3_url.innerHTML = "URL fisier:";
    var h5_poza = document.createElement("h5");
    h5_poza.id = "h5_poza_" + action;
    h5_poza.innerHTML = "Daca tipul cartii este 'fizica' - adauga numele imaginii de coperta";
    var h5_url = document.createElement("h5");
    h5_url.id = "h5_url_" + action;
    h5_url.innerHTML = "Daca tipul cartii este 'digitala' - adauga link-ul catre cartea digitala";
    h5_url.style.marginTop = 0;
    var input6 = document.createElement("input");
    input6.id = 'url_fisier_' + action;
    input6.name = 'url_fisier_' + action;
    input6.style.marginLeft = 0;
    input6.style.width = "30%";
  }

  if (action === 'insert') {
    var h3_autori = document.createElement("h3");
    h3_autori.id = "h3_autori_" + action;
    h3_autori.innerHTML = "Autori:";
    var input7 = document.createElement("input");
    input7.id = 'autori_' + action;
    input7.name = 'autori_' + action;
    input7.style.marginLeft = 0;
    input7.style.width = "30%";
    input7.placeholder = "Numele separate prin ','";
  }
  else if (action === 'update') {
    var h3_titlu_nou = document.createElement("h3");
    h3_titlu_nou.id = 'h3_titlu_nou_' + action;
    h3_titlu_nou.innerHTML = "Titlul nou:";
    var input8 = document.createElement("input");
    input8.id = 'titlu_nou_' + action;
    input8.name = 'titlu_nou_' + action;
    input8.style.marginLeft = 0;
    input8.style.width = "30%";
  }

  form[i].insertBefore(h3_titlu, submit[i]);
  form[i].insertBefore(input1, submit[i]);
  if (action === 'insert') {
    form[i].insertBefore(h3_autori, submit[i]);
    form[i].insertBefore(input7, submit[i]);
  }
  else if (action === 'update') {
    form[i].insertBefore(h3_titlu_nou, submit[i]);
    form[i].insertBefore(input8, submit[i]);
  }
  form[i].insertBefore(h3_categorie, submit[i]);
  form[i].insertBefore(input2, submit[i]);
  form[i].insertBefore(h3_an, submit[i]);
  form[i].insertBefore(input3, submit[i]);
  form[i].insertBefore(h3_editura, submit[i]);
  form[i].insertBefore(input4, submit[i]);
  form[i].insertBefore(h3_tip, submit[i]);
  form[i].insertBefore(div_radio, submit[i]);
  if (action !== 'delete') {
    form[i].insertBefore(h3_stoc, submit[i]);
    form[i].insertBefore(input5, submit[i]);
    form[i].insertBefore(h3_descriere, submit[i]);
    form[i].insertBefore(textarea, submit[i]);
    form[i].insertBefore(h3_url, submit[i]);
    form[i].insertBefore(h5_poza, submit[i]);
    form[i].insertBefore(h5_url, submit[i]);
    form[i].insertBefore(input6, submit[i]);
  }
}

function user_code_form(action) {
  var i = initialize_i(action);

  var h3_cod = document.createElement("h3");
  h3_cod.id = "h3_cod_" + action;
  h3_cod.innerHTML = "Codul:";
  var input = document.createElement("input");
  input.id = 'cod_utilizator_' + action;
  input.name = 'cod_utilizator_' + action;
  input.style.marginLeft = 0;
  input.style.width = "30%";

  var h3_tip = document.createElement("h3");
  h3_tip.id = "h3_tip_" + action;
  h3_tip.innerHTML = "Tipul de utilizator:";
  var radio1 = document.createElement("input");
  radio1.id = "radio_bibl";
  radio1.type = "radio";
  radio1.name = "radio_tip_" + action;
  radio1.value = "2";
  radio1.style.marginLeft = 0;
  radio1.style.marginRight = ".5pc";
  var label1 = document.createElement("label");
  label1.innerHTML = "Bibliotecar";
  label1.for = "radio_bibl";
  var radio2 = document.createElement("input");
  radio2.id = "radio_admin";
  radio2.type = "radio";
  radio2.name = "radio_tip_" + action;
  radio2.value = "3";
  radio2.style.marginRight = ".5pc";
  var label2 = document.createElement("label");
  label2.innerHTML = "Administrator";
  label2.for = "3";

  var div_radio = document.createElement("div");
  div_radio.id = "div_radio_tip_" + action;
  div_radio.style.display = "flex";
  div_radio.style.justifyContent = "space-between";
  div_radio.style.alignItems = "center";
  div_radio.appendChild(radio1);
  div_radio.appendChild(label1);
  div_radio.appendChild(radio2);
  div_radio.appendChild(label2);

  form[i].insertBefore(h3_cod, submit[i]);
  form[i].insertBefore(input, submit[i]);
  form[i].insertBefore(h3_tip, submit[i]);
  form[i].insertBefore(div_radio, submit[i]);

}

function author_form(action) {
  var i = initialize_i(action);

  var h3 = document.createElement("h3");
  h3.id = "h3_nume_" + action;
  h3.innerHTML = "Numele si prenumele autorului:";
  var h51 = document.createElement("h5");
  var h52 = document.createElement("h5");
  h51.innerHTML = "Nume";
  h52.innerHTML = "Prenume";
  h51.id = "titlu_nume_" + action;
  h52.id = "titlu_prenume_" + action;
  var input1 = document.createElement("input");
  input1.id = 'nume_autor_' + action;
  input1.name = 'nume_autor_' + action;
  input1.style.marginLeft = 0;
  input1.style.width = "30%";
  var input2 = document.createElement("input");
  input2.id = 'prenume_autor_' + action;
  input2.name = 'prenume_autor_' + action;
  input2.style.marginLeft = 0;
  input2.style.width = "30%";

  form[i].insertBefore(h3, submit[i]);
  form[i].insertBefore(h52, submit[i]);
  form[i].insertBefore(input2, submit[i]);
  form[i].insertBefore(h51, submit[i]);
  form[i].insertBefore(input1, submit[i]);
}

