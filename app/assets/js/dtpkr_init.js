import "../datetimepicker/datetimepicker.js";

document.addEventListener("DOMContentLoaded", function () {
  $(document).ready(function () {
    $("#picker").dateTimePicker({
      // positionShift: { top: 30, left: psl },
      dateFormat: "DD/MMMM/YYYY",
      title: "Selectinez l'heure et la date.",
      buttonTitle: "Valider",
    });
    // $('#picker-no-time').dateTimePicker({ showTime: false, dateFormat: 'DD/MMMM/YYYY', title: 'Select Date' });
  });
});
