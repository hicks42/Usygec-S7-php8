document.addEventListener("DOMContentLoaded", function () {
  var flashMessage = document.querySelector(".flash-container");
  if (flashMessage) {
    setTimeout(function () {
      flashMessage.style.display = "none";
    }, 1000);
  }
});
