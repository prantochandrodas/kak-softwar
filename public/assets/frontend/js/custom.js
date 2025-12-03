$(document).ready(function ($) {

	$(".close_icon ").click(function () {
		$(".sideNav").toggleClass("open");
	});

	$(".menu_call").click(function () {
		$(".sideNav").toggleClass("open");
	});

	$(".mega-dropdown-toggle").click(function () {
		$(".mega-dropdown-toggle").toggleClass("open");
	});

	jQuery(function ($) {

		$('#mega-dropdown-menu').click(function (e) {
			var getClass = $(".mega-dropdown-toggle").hasClass("open");

			if (getClass == true) {
				$(".mega-dropdown-menu").addClass("open");
				e.stopPropagation();
			} else {
				//$(".mega-dropdown-toggle").addClass("open");
				$(".mega-dropdown-toggle").removeClass("open");
				$(".mega-dropdown-menu").removeClass("open");
				e.stopPropagation();
			}

			e.stopPropagation(); // Prevent bubbling
		});
		$(document).click(function () {
			$(".mega-dropdown-toggle").removeClass("open");
			$(".mega-dropdown-menu").removeClass("open");
		});
		$(document).click(function () {
			$(".mega-dropdown-toggle").addClass("close");
			$(".mega-dropdown-menu").addClass("close");
		});
	});

	new WOW().init();

	$(window).scroll(function () {
		
		var scroll = $(window).scrollTop();
		if (scroll) {
			$(".header_area").addClass("bg-white end-0 navbar_fixed position-fixed start-0 top-0");
		} else {
			$(".header_area").removeClass("bg-white end-0 navbar_fixed position-fixed start-0 top-0");
		}
		
		if ($(window).scrollTop() > 300) {
			$('.gotoTop').addClass('show');
		} else {
			$('.gotoTop').removeClass('show');
		}
	});

	$('.gotoTop').on('click', function (e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, '300');
	});
	
});
