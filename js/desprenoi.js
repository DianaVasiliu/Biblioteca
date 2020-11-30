var refreshButton = document.querySelector(".refresh-captcha");

refreshButton.onclick = function() {
  document.querySelector(".captcha-image").src = 'requirements/captcha.php?' + Date.now();
}