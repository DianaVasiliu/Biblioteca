
var answer_link = document.getElementsByClassName("accordion-link");
var answer = document.getElementsByClassName("answer");
var oks = new Array(answer.length);
for (let i = 0; i < oks.length; i++) {
    oks[i] = 0;
}

var plus = document.querySelectorAll(".icon.plus");
var minus = document.querySelectorAll(".icon.minus");

for (let i = 0; i < answer_link.length; i++) {
    answer_link[i].onclick = function () {
        if (oks[i] == 0) {
            answer[i].style.maxHeight = "100vh";
            plus[i].style.display = "none";
            minus[i].style.display = "block";
            oks[i] = 1;
        }
        else {
            answer[i].style.maxHeight = "0";
            plus[i].style.display = "block";
            minus[i].style.display = "none";
            oks[i] = 0;
        }

    }
}
