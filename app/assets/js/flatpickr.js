import "../js/flatpickr/flatpickr.min.css";

import "../js/flatpickr/flatpickr.min.js";

document.addEventListener("DOMContentLoaded", function () {
  const French = flatpickr.l10ns.fr;

  document.querySelectorAll(".flatpickr").forEach((input) => {
    flatpickr(input, {
      altInput: true,
      altFormat: "j F, Y",
      dateFormat: "d-m-Y",
      locale: French,
      firstDayOfWeek: 1,
    });
  });
});
