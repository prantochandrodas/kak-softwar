$(document).ready(function ($) {

	$('.client_carousel').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		navText: ['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
		items: 1
	});

	$(".close_icon ").click(function () {
		$(".sideNav").toggleClass("open");
	});

	$(".vdo-link").YouTubePopUp();

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

	//Check if an element was in a screen
	function isScrolledIntoView(elem) {
		var docViewTop = $(window).scrollTop();
		var docViewBottom = docViewTop + $(window).height();
		var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();
		return ((elemBottom <= docViewBottom));
	}

	//Count up code
	function countUp() {
		$('.counter').each(function () {
			var $this = $(this), // <- Don't touch this variable. It's pure magic.
				countTo = $this.attr('data-count');
			ended = $this.attr('ended');

			if (ended != "true" && isScrolledIntoView($this)) {
				$({
					countNum: $this.text()
				}).animate({
					countNum: countTo
				}, {
					duration: 2500, //duration of counting
					easing: 'swing',
					step: function () {
						$this.text(Math.floor(this.countNum));
					},
					complete: function () {
						$this.text(this.countNum);
					}
				});
				$this.attr('ended', 'true');
			}
		});
	}
	//Start animation on page-load
	if (isScrolledIntoView(".counter")) {
		countUp();
	}
	//Start animation on screen
	$(document).scroll(function () {
		if (isScrolledIntoView(".counter")) {
			countUp();
		}
	});

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
	
    // 	MidYear
    $(".closeDiv").click(function() {
    	$(".mid-deals").addClass("hide");
    	$(".mid-deals2").addClass("show");
    });
	
	// Midyear Countdown
// 	const daysEl = document.getElementById("days");
// 	const hoursEl = document.getElementById("hours");
// 	const minsEl = document.getElementById("mins");
// 	const secondsEl = document.getElementById("seconds");
// 	const newYears = "01 July 2022";

// 	function countdown() {
// 		const newYearsDate = new Date(newYears);
// 		const currentDate = new Date();
// 		const totalSeconds = (newYearsDate - currentDate) / 1000;
// 		const days = Math.floor(totalSeconds / 3600 / 24);
// 		const hours = Math.floor(totalSeconds / 3600) % 24;
// 		const mins = Math.floor(totalSeconds / 60) % 60;
// 		const seconds = Math.floor(totalSeconds) % 60;
// 		daysEl.innerHTML = days;
// 		hoursEl.innerHTML = formatTime(hours);
// 		minsEl.innerHTML = formatTime(mins);
// 		secondsEl.innerHTML = formatTime(seconds);
// 	}

// 	function formatTime(time) {
// 		return time < 10 ? `0${time}` : time;
// 	}
// 	// initial call
// 	countdown();
// 	setInterval(countdown, 1000);
});