document.addEventListener("DOMContentLoaded", function () {
  var flashContainers = document.querySelectorAll(".flash-container");

  flashContainers.forEach(function(flashContainer) {
    if (flashContainer) {
      var alertDiv = flashContainer.querySelector(".alert");

      // Vérifier le type de message
      var isSuccess = alertDiv && alertDiv.classList.contains("alert-success");
      var isInfo = alertDiv && alertDiv.classList.contains("alert-info");

      // Les messages de succès et info disparaissent automatiquement après 5 secondes
      if (isSuccess || isInfo) {
        setTimeout(function () {
          flashContainer.style.opacity = "0";
          flashContainer.style.transition = "opacity 0.5s ease";
          setTimeout(function() {
            flashContainer.style.display = "none";
          }, 500);
        }, 5000);
      }

      // Les messages d'erreur et warning restent affichés jusqu'au clic sur le bouton X
      // (pas de timer pour error et warning)
    }
  });
});
