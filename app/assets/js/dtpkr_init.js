import "../datetimepicker/datetimepicker.css";
import "../datetimepicker/datetimepicker.js";

document.addEventListener("DOMContentLoaded", function () {
  const French = flatpickr.l10ns.fr;

  $(document).ready(function () {
    $("#picker").dateTimePicker({
      // positionShift: { top: 30, left: psl },
      title: "Selectinez l'heure et la date.",
      buttonTitle: "Valider",
    });
    // $('#picker-no-time').dateTimePicker({ showTime: false, dateFormat: 'DD/MMMM/YYYY', title: 'Select Date' });
  });
});
