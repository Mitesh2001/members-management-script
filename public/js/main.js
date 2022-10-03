$(".nav-button").click(function () {
	if ($(this).hasClass("active")) {
		$(".nav-list").animate({
			"left": "-1200px"
		}, "slow");
		$(this).removeClass("active");
	} else {
		$(".nav-list").animate({
			"left": "0px"
		}, "slow");
		$(this).addClass("active");
	}
});

$('.panel-collapse').on('show.bs.collapse', function () {
	$(this).parent('.panel').find('.fa-chevron-up').show();
	$(this).parent('.panel').find('.fa-chevron-down').hide();
})
$('.panel-collapse').on('hide.bs.collapse', function () {
	$(this).parent('.panel').find('.fa-chevron-up').hide();
	$(this).parent('.panel').find('.fa-chevron-down').show();
});

$(document).click(function (event) {
	if (!($(event.target).closest(".form-input").length)) {
		$(".form-input").removeClass("active");
	}
});

$(function () {
	$(".form-input").click(function () {
		$(this).addClass('active').siblings().removeClass('active');
	});
});
