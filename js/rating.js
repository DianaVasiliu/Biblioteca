var stars = document.getElementsByClassName("fa-star");

for (let i = 0; i < stars.length; i++) {
  stars[i].onclick = function () {

    for (var j = parseInt(Math.floor(i / 5)) * 5; j <= i; j++) {
      if(!stars[j].classList.contains("colored-star"))
         stars[j].classList.add("colored-star");
    }
    
    for (var j = i + 1; j < parseInt((Math.floor(i / 5) + 1)) * 5; j++) {
      if(stars[j].classList.contains("colored-star"))
         stars[j].classList.remove("colored-star");
    }
    
  }
}

var ratingform = document.getElementsByClassName("ratingform");
var ratingvalue = document.getElementsByClassName("rating-value");

// alert(ratingvalue.length == ratingform.length);

for (let i = 0; i < ratingform.length; i++) {
  ratingform[i].onsubmit = function() {
    let nota = 0;
    let index = i * 5;

    while (index < (i+1) * 5 && stars[index].classList.contains("colored-star")) {
      nota++;
      index++;
    }

    ratingvalue[i].value = nota;

    if (nota == 0) {
      alert("Nu ai ales o nota!");
    }
    else {
      ratingform[i].submit();
    }
  }
}