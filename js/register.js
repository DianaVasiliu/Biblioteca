var radios = document.getElementsByClassName("radio_btn");
var wrapper = document.getElementById("user_type");

function add_input (elim, utype) {
//   alert(elim);
//   alert(utype);
  var elim1 = document.getElementById(elim.concat("_input"));
  var elim2 = document.getElementById(elim.concat("_text"));

  if (elim1 && elim2) {
    elim1.parentNode.removeChild(elim1);
    elim2.parentNode.removeChild(elim2);
  }

  let exists = document.getElementById(utype.concat("_input"));
  let exists2 = document.getElementById(utype.concat("_text"));

  if (!exists && !exists2) {
    let input = document.createElement("input");
    input.type = "text";
    input.className = "form-control";
    input.id = utype.concat("_input");
    input.required = true;
    input.name = utype;

    let text = document.createElement("label");
    text.innerHTML = "Introdu codul de " + utype + ":";
    text.id = utype.concat("_text");

    wrapper.appendChild(text);
    wrapper.appendChild(input);
  }
}

radios[0].onclick = function() {
  var elim1 = document.getElementById("bibliotecar_input");
  var elim2 = document.getElementById("bibliotecar_text");
  var elim3 = document.getElementById("admin_input");
  var elim4 = document.getElementById("admin_text");

  if (elim1 && elim2) {
    wrapper.removeChild(elim1);
    wrapper.removeChild(elim2);
  }
  if (elim3 && elim4) {
    wrapper.removeChild(elim3);
    wrapper.removeChild(elim4);
  }
}

radios[1].onclick = function () { add_input("admin", "bibliotecar");}
radios[2].onclick = function() { add_input("bibliotecar", "admin"); }