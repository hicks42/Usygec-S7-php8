document.addEventListener("DOMContentLoaded", function () {
  const French = flatpickr.l10ns.fr;
  // for existing activities
  window.allflatpicker = function () {
    document.querySelectorAll(".flatpickr").forEach((input) => {
      flatpickr(input, {
        altInput: true,
        altFormat: "j F, Y",
        dateFormat: "d-m-Y",
        locale: French,
        firstDayOfWeek: 1,
      });
    });
  };
  // for new activity
  window.initializeFlatpickr = function (element) {
    flatpickr(element, {
      altInput: true,
      altFormat: "j F, Y",
      dateFormat: "d-m-Y",
      locale: French,
      firstDayOfWeek: 1,
    });
  };

  allflatpicker();
});
