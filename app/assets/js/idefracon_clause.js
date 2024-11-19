document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".modal-btn").forEach((button) => {
    const formName = button.getAttribute("data-modal-type");
    const clauseId = button.getAttribute("data-id");

    const hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("name", "clauseId");
    hiddenInput.setAttribute("value", clauseId);

    const form = document.querySelector(`form[name="${formName}"]`);
    form.appendChild(hiddenInput);

    document.querySelectorAll(".submit-modal").forEach((submitButton) => {
      submitButton.addEventListener("click", function (event) {
        event.preventDefault();

        const form = submitButton.closest("form");
        if (form) {
          const actionUrl = `/select-clause/${clauseId}`;
          console.log(`Action définie pour le formulaire : ${actionUrl}`);
          form.submit();
        }
      });
    });
  });
});
