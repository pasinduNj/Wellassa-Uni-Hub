$(".fa-close").on("click", function() {
		var $pan = $(this).parents('.panel');
		$pan.addClass('panel-close');
		setTimeout(function() {
			$pan.parent().remove();
		}, 100);
	});

$(".fa-chevron-down").on("click", function() {
		var $pan = $(this).parents('.panel-heading');
		$pan.siblings('.panel-footer').toggleClass("ott-collapse");
		$pan.siblings('.panel-body').toggleClass("ott-collapse", function() {
			setTimeout(function() {
			initializeCharts();
			}, 400);
		});
	});