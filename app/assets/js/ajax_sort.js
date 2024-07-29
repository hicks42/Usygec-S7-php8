$(document).ready(function () {
	$('.sorting-link').on('click', function () {
		var sortBy = $(this).data('sort-by');
		var sortOrder = $(this).data('sort-order');
		var ajaxUrl = $('#activities-list').data('ajax-url');

		$.ajax({
			url: ajaxUrl,
			data: { sort_by: sortBy, sort_order: sortOrder },
			success: function (data) {
				$('#activities-list').html(data);
			}
		});
	});
});
