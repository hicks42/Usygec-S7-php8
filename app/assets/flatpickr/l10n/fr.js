/* flatpickr v4.6.9, @license MIT */
(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define(factory);
  } else if (typeof exports !== "undefined") {
    factory();
  } else {
    var mod = {
      exports: {},
    };
    factory();
    global.fr = mod.exports;
  }
})(this, function () {
  "use strict";

  var fp =
    typeof window !== "undefined" && window.flatpickr !== undefined
      ? window.flatpickr
      : {
          l10ns: {},
        };
  var French = {
    firstDayOfWeek: 1,
    weekdays: {
      shorthand: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
      longhand: [
        "Dimanche",
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi",
      ],
    },
    months: {
      shorthand: [
        "Janv",
        "Févr",
        "Mars",
        "Avr",
        "Mai",
        "Juin",
        "Juil",
        "Août",
        "Sept",
        "Oct",
        "Nov",
        "Déc",
      ],
      longhand: [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre",
      ],
    },
    ordinal: function ordinal() {
      return "ème";
    },
    rangeSeparator: " au ",
    weekAbbreviation: "Sem",
    scrollTitle: "Défiler pour augmenter la valeur",
    toggleTitle: "Cliquer pour basculer",
    time_24hr: true,
  };
  fp.l10ns.fr = French;
  var fr = fp.l10ns;
  return fr;
});
