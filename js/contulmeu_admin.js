var insert_form = document.getElementById("insert_form");
var table_select = document.getElementById("table_select");

var submit_insert = document.getElementById("submit_insert");

table_select.onchange = function () {

  if (table_select.selectedIndex == 1) {
      delete_from_2();
      delete_from_3();

      // insert into autor
      let h3 = document.createElement("h3");
      h3.id = "h3_nume";
      h3.innerHTML = "Numele si prenumele autorului:";
      let h51 = document.createElement("h5");
      let h52 = document.createElement("h5");
      h51.innerHTML = "Nume";
      h52.innerHTML = "Prenume";
      h51.id = "titlu_nume";
      h52.id = "titlu_prenume";
      let input1 = document.createElement("input");
      input1.id = 'nume_autor';
      input1.name = 'nume_autor';
      input1.style.marginLeft = 0;
      input1.style.width = "30%";
      let input2 = document.createElement("input");
      input2.id = 'prenume_autor';
      input2.name = 'prenume_autor';
      input2.style.marginLeft = 0;
      input2.style.width = "30%";

      insert_form.insertBefore(h3, submit_insert);
      insert_form.insertBefore(h52, submit_insert);
      insert_form.insertBefore(input2, submit_insert);
      insert_form.insertBefore(h51, submit_insert);
      insert_form.insertBefore(input1, submit_insert);
  }
  else if (table_select.selectedIndex == 2) {
    delete_from_1();
    delete_from_3();

    // insert into carte
    let h3_titlu = document.createElement("h3");
    h3_titlu.id = "h3_titlu_carte";
    h3_titlu.innerHTML = "Titlul cartii:";
    let input1 = document.createElement("input");
    input1.id = 'titlu_carte';
    input1.name = 'titlu_carte';
    input1.style.marginLeft = 0;
    input1.style.width = "30%";
    let h3_categorie = document.createElement("h3");
    h3_categorie.id = "h3_categorie";
    h3_categorie.innerHTML = "Id-ul categoriei:";
    let input2 = document.createElement("input");
    input2.id = 'id_categorie';
    input2.name = 'id_categorie';
    input2.style.marginLeft = 0;
    input2.style.width = "10%";
    let h3_an = document.createElement("h3");
    h3_an.id = "h3_an";
    h3_an.innerHTML = "Anul publicarii:";
    let input3 = document.createElement("input");
    input3.id = 'an';
    input3.name = 'an';
    input3.type = "number";
    input3.min = "1900";
    input3.max = new Date().getFullYear();
    input3.style.marginLeft = 0;
    input3.style.width = "15%";
    let h3_editura = document.createElement("h3");
    h3_editura.id = "h3_editura";
    h3_editura.innerHTML = "Editura:";
    let input4 = document.createElement("input");
    input4.id = 'editura';
    input4.name = 'editura';
    input4.style.marginLeft = 0;
    input4.style.width = "30%";
    let h3_tip = document.createElement("h3");
    h3_tip.id = "h3_tip";
    h3_tip.innerHTML = "Tipul de carte:";
    let radio1 = document.createElement("input");
    radio1.id = "radio_fizica";
    radio1.type = "radio";
    radio1.name = "radio_tip_carte";
    radio1.value = "fizica";
    radio1.style.marginLeft = 0;
    radio1.style.marginRight = ".5pc";
    let radio2 = document.createElement("input");
    radio2.id = "radio_digitala";
    radio2.type = "radio";
    radio2.name = "radio_tip_carte";
    radio2.value = "digitala";
    radio2.style.marginRight = ".5pc";
    let label1 = document.createElement("label");
    label1.innerHTML = "Fizica";
    label1.for = "radio_fizica";
    let label2 = document.createElement("label");
    label2.innerHTML = "Digitala";
    label2.for = "radio_digitala";
    let div_radio = document.createElement("div");
    div_radio.id = "div_radio_tip_carte";
    div_radio.style.display = "flex";
    div_radio.style.justifyContent = "space-between";
    div_radio.style.alignItems = "center";
    div_radio.appendChild(radio1);
    div_radio.appendChild(label1);
    div_radio.appendChild(radio2);
    div_radio.appendChild(label2);
    let h3_stoc = document.createElement("h3");
    h3_stoc.id = "h3_stoc";
    h3_stoc.innerHTML = "Stoc:";
    let input5 = document.createElement("input");
    input5.id = 'stoc';
    input5.name = 'stoc';
    input5.type = "number";
    input5.min = 0;
    input5.max = 100;
    input5.style.marginLeft = 0;
    input5.style.width = "10%";
    let h3_descriere = document.createElement("h3");
    h3_descriere.id = "h3_descriere";
    h3_descriere.innerHTML = "Descriere:";
    let textarea = document.createElement("textarea");
    textarea.id = 'descriere';
    textarea.name = 'descriere';
    textarea.style.marginLeft = 0;
    textarea.style.width = "70%";
    textarea.style.maxWidth = "90%";
    textarea.style.maxHeight = "40vh";
    textarea.style.padding = "1pc";
    textarea.style.height = "10vh";
    textarea.style.overflowY = "auto";
    textarea.style.border = "none";
    let h3_url = document.createElement("h3");
    h3_url.id = "h3_url";
    h3_url.innerHTML = "URL fisier:";
    let h5_poza = document.createElement("h5");
    h5_poza.id = "h5_poza";
    h5_poza.innerHTML = "Daca tipul cartii este 'fizica' - adauga numele imaginii de coperta";
    let h5_url = document.createElement("h5");
    h5_url.id = "h5_url";
    h5_url.innerHTML = "Daca tipul cartii este 'digitala' - adauga link-ul catre cartea digitala";
    h5_url.style.marginTop = 0;
    let input6 = document.createElement("input");
    input6.id = 'url_fisier';
    input6.name = 'url_fisier';
    input6.style.marginLeft = 0;
    input6.style.width = "30%";
    let h3_autori = document.createElement("h3");
    h3_autori.id = "h3_autori";
    h3_autori.innerHTML = "Autori:";
    let input7 = document.createElement("input");
    input7.id = 'autori';
    input7.name = 'autori';
    input7.style.marginLeft = 0;
    input7.style.width = "30%";
    input7.placeholder = "Numele separate prin ','";


    insert_form.insertBefore(h3_titlu, submit_insert);
    insert_form.insertBefore(input1, submit_insert);
    insert_form.insertBefore(h3_autori, submit_insert);
    insert_form.insertBefore(input7, submit_insert);
    insert_form.insertBefore(h3_categorie, submit_insert);
    insert_form.insertBefore(input2, submit_insert);
    insert_form.insertBefore(h3_an, submit_insert);
    insert_form.insertBefore(input3, submit_insert);
    insert_form.insertBefore(h3_editura, submit_insert);
    insert_form.insertBefore(input4, submit_insert);
    insert_form.insertBefore(h3_tip, submit_insert);
    insert_form.insertBefore(div_radio, submit_insert);
    insert_form.insertBefore(h3_stoc, submit_insert);
    insert_form.insertBefore(input5, submit_insert);
    insert_form.insertBefore(h3_descriere, submit_insert);
    insert_form.insertBefore(textarea, submit_insert);
    insert_form.insertBefore(h3_url, submit_insert);
    insert_form.insertBefore(h5_poza, submit_insert);
    insert_form.insertBefore(h5_url, submit_insert);
    insert_form.insertBefore(input6, submit_insert);
    
    
  }
  else if (table_select.selectedIndex == 3) {
    delete_from_1();
    delete_from_2();

    // insert into coduri_utilizatori
    let h3_cod = document.createElement("h3");
    h3_cod.id = "h3_cod";
    h3_cod.innerHTML = "Codul:";
    let input = document.createElement("input");
    input.id = 'cod_utilizator';
    input.name = 'cod_utilizator';
    input.style.marginLeft = 0;
    input.style.width = "30%";
    let h3_tip = document.createElement("h3");
    h3_tip.id = "h3_tip";
    h3_tip.innerHTML = "Tipul de utilizator:";
    let radio1 = document.createElement("input");
    radio1.id = "radio_bibl";
    radio1.type = "radio";
    radio1.name = "radio_tip";
    radio1.value = "2";
    radio1.style.marginLeft = 0;
    radio1.style.marginRight = ".5pc";
    let radio2 = document.createElement("input");
    radio2.id = "radio_admin";
    radio2.type = "radio";
    radio2.name = "radio_tip";
    radio2.value = "3";
    radio2.style.marginRight = ".5pc";
    let label1 = document.createElement("label");
    label1.innerHTML = "Bibliotecar";
    label1.for = "radio_bibl";
    let label2 = document.createElement("label");
    label2.innerHTML = "Administrator";
    label2.for = "3";
    let div_radio = document.createElement("div");
    div_radio.id = "div_radio_tip";
    div_radio.style.display = "flex";
    div_radio.style.justifyContent = "space-between";
    div_radio.style.alignItems = "center";
    div_radio.appendChild(radio1);
    div_radio.appendChild(label1);
    div_radio.appendChild(radio2);
    div_radio.appendChild(label2);

    insert_form.insertBefore(h3_cod, submit_insert);
    insert_form.insertBefore(input, submit_insert);
    insert_form.insertBefore(h3_tip, submit_insert);
    insert_form.insertBefore(div_radio, submit_insert);
  }
  else {
    delete_from_1();
    delete_from_2();
    delete_from_3();
  }

}


function delete_from_1 () {
  let input_nume_del1 = document.getElementById("nume_autor");
  let input_nume_del2 = document.getElementById("prenume_autor");
  let h3_nume_del = document.getElementById("h3_nume");
  let h51_nume_del = document.getElementById("titlu_nume");
  let h52_nume_del = document.getElementById("titlu_prenume");
  if (input_nume_del1 && input_nume_del2 && h3_nume_del && h51_nume_del && h52_nume_del) {
      insert_form.removeChild(input_nume_del1);
      insert_form.removeChild(input_nume_del2);
      insert_form.removeChild(h3_nume_del);
      insert_form.removeChild(h51_nume_del);
      insert_form.removeChild(h52_nume_del);
  }

}

function delete_from_2 () {
    let h3_titlu_carte_del = document.getElementById("h3_titlu_carte");
    let titlu_carte_del = document.getElementById("titlu_carte");
    let h3_categorie_del = document.getElementById("h3_categorie");
    let id_categorie_del = document.getElementById("id_categorie");
    let h3_an_del = document.getElementById("h3_an");
    let an_del = document.getElementById("an");
    let h3_editura_del = document.getElementById("h3_editura");
    let editura_del = document.getElementById("editura");
    let h3_tip_del = document.getElementById("h3_tip");
    let div_radio_tip_carte_del = document.getElementById("div_radio_tip_carte");
    let h3_stoc_del = document.getElementById("h3_stoc");
    let stoc_del = document.getElementById("stoc");
    let h3_descriere_del = document.getElementById("h3_descriere");
    let descriere_del = document.getElementById("descriere");
    let h3_url_del = document.getElementById("h3_url");
    let h5_poza_del = document.getElementById("h5_poza");
    let h5_url_del = document.getElementById("h5_url");
    let url_fisier_del = document.getElementById("url_fisier");

    if (h3_titlu_carte_del && titlu_carte_del && h3_categorie_del && id_categorie_del && h3_an_del && an_del && h3_editura_del && editura_del && h3_tip_del && div_radio_tip_carte_del && h3_stoc_del && stoc_del && h3_descriere_del && descriere_del && h3_url_del && h5_poza_del && h5_url_del && url_fisier_del) {
      insert_form.removeChild(h3_titlu_carte_del);
      insert_form.removeChild(titlu_carte_del);
      insert_form.removeChild(h3_categorie_del);
      insert_form.removeChild(id_categorie_del);
      insert_form.removeChild(h3_an_del);
      insert_form.removeChild(an_del);
      insert_form.removeChild(h3_editura_del);
      insert_form.removeChild(editura_del);
      insert_form.removeChild(h3_tip_del);
      insert_form.removeChild(div_radio_tip_carte_del);
      insert_form.removeChild(h3_stoc_del);
      insert_form.removeChild(stoc_del);
      insert_form.removeChild(h3_descriere_del);
      insert_form.removeChild(descriere_del);
      insert_form.removeChild(h3_url_del);
      insert_form.removeChild(h5_poza_del);
      insert_form.removeChild(h5_url_del);
      insert_form.removeChild(url_fisier_del);
    }
}

function delete_from_3 () {
  let input_cod_del = document.getElementById("cod_utilizator");
  let h3_cod_del = document.getElementById("h3_cod");
  let h3_tip_del = document.getElementById("h3_tip");
  let div_radio_tip_del = document.getElementById("div_radio_tip");

  if (input_cod_del && h3_cod_del && h3_tip_del && div_radio_tip_del) {
      insert_form.removeChild(input_cod_del);
      insert_form.removeChild(h3_cod_del);
      insert_form.removeChild(h3_tip_del);
      insert_form.removeChild(div_radio_tip_del);
  }

}
