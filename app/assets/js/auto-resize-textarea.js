// Auto-resize textarea based on content
document.addEventListener("DOMContentLoaded", function () {
  // Fonction pour ajuster la hauteur d'un textarea
  function autoResizeTextarea(textarea) {
    // Reset height to auto to get the correct scrollHeight
    textarea.style.height = "auto";
    // Set height to scrollHeight to fit content
    textarea.style.height = textarea.scrollHeight + "px";
  }

  // Fonction pour initialiser l'auto-resize sur tous les textareas
  window.initAutoResizeTextareas = function () {
    const textareas = document.querySelectorAll("textarea");

    textareas.forEach((textarea) => {
      // Ajuster la hauteur au chargement
      autoResizeTextarea(textarea);

      // Ajuster la hauteur à chaque saisie
      textarea.addEventListener("input", function () {
        autoResizeTextarea(this);
      });

      // Ajuster la hauteur lors du focus (au cas où le contenu a été modifié programmatiquement)
      textarea.addEventListener("focus", function () {
        autoResizeTextarea(this);
      });
    });
  };

  // Initialiser au chargement de la page
  window.initAutoResizeTextareas();
});
