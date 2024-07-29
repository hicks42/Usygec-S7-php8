// JavaScript code for toggling sorting order and updating icons
$(".sort-control").on("click", function (e) {
  e.preventDefault();

  // Get the sorting parameters from the clicked element
  const sortBy = $(this).data("sort-by");
  let sortOrder = $(this).data("sort-order"); // Get the current sort order
  sortOrder = sortOrder === "asc" ? "desc" : "asc"; // Toggle the sort order

  // Update the data-sort-order attribute of the clicked element
  $(this).data("sort-order", sortOrder);

  // Update the sort icon based on the new sort order
  const sortIcon = $(this).find(".sort-icon i");

  if (sortOrder === "asc") {
    sortIcon.removeClass("fa-sort-down").addClass("fa-sort-up");
  } else {
    sortIcon.removeClass("fa-sort-up").addClass("fa-sort-down");
  }

  // Make an AJAX request to fetch sorted data
  $.ajax({
    url: "/companies/ajax/sort", // Your AJAX route URL
    method: "GET",
    data: {
      sort_by: sortBy,
      sort_order: sortOrder,
    },
    success: function (response) {
      // Clear the current content and populate with sorted data
      $("#sorted-companies").empty();
      response.forEach(function (company) {
        $("#sorted-companies").append(`
        <div class="row list-row flex justify-between">
          <div class="col-1">${company.category}</div>
          <div class="col-2"><a href="/companies/${company.id}/show">
          <i class="fa-solid fa-right-to-bracket me-2"></i>${company.name}</a></div>
          <div class="col-2">${company.phone}</div>
          <div class="col-2">${company.contactFirstName} ${company.contactLastName}</div>
          <div class="col-2">${company.mobile}</div>
          <div class="col-2"><a href="mailto:${company.email}">${company.email}</a></div>
        </div>
        `);
      });
    },
  });
});
