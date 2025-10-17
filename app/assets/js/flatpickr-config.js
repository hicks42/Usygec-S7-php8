document.addEventListener("DOMContentLoaded", function () {
  const French = flatpickr.l10ns.fr;

  // Fonction pour initialiser Flatpickr sur tous les éléments avec la classe "flatpickr"
  window.allflatpicker = function () {
    console.log("Initializing flatpickr elements");

    // Initialiser Flatpickr sur les activités existante
    document.querySelectorAll(".flatpickr").forEach((input) => {
      flatpickr(input, {
        altInput: true,
        altFormat: "j F, Y",
        dateFormat: "d-m-Y",
        locale: French,
        firstDayOfWeek: 1,
      });
    });

    // Initialiser Flatpickr sur les éléments avec la classe "rdvflatpicker"
    flatpickr(".rdvflatpicker", {
      altInput: true,
      enableTime: true,
      time_24hr: true,
      altFormat: "j F, Y H:i",
      dateFormat: "d-m-Y H:i",
      maxDate: "today",
      locale: French,
      firstDayOfWeek: 1,
    });
  };

  // Fonction pour initialiser Flatpickr sur une nouvelle activité
  window.initializeFlatpickr = function (elements) {
    // Si c'est une NodeList ou un tableau, itérer sur chaque élément
    if (elements.length !== undefined) {
      elements.forEach((element) => {
        flatpickr(element, {
          altInput: true,
          altFormat: "j F, Y",
          dateFormat: "d-m-Y",
          locale: French,
          firstDayOfWeek: 1,
        });
      });
    } else {
      // Si c'est un seul élément
      flatpickr(elements, {
        altInput: true,
        altFormat: "j F, Y",
        dateFormat: "d-m-Y",
        locale: French,
        firstDayOfWeek: 1,
      });
    }
  };

  // Appel initial pour s'assurer que les éléments existants sont initialisés
  window.allflatpicker();
});
