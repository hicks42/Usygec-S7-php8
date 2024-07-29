window.onload = function () {
  var windowWidth =
    window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;

  if (windowWidth <= 768) {
    document.body.classList.add("narrow-window");
  }
};
