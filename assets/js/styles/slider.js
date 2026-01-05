/**
 * Post Style - Slider JavaScript
 *
 * @package PostStyle
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		$('.post-style-slider').each(function() {
			var $slider = $(this);
			var $slides = $slider.find('.post-style-slide');
			var $wrapper = $slider.closest('.post-style-slider-wrapper');
			var $prev = $wrapper.find('.post-style-slider-prev');
			var $next = $wrapper.find('.post-style-slider-next');
			var $dots = $wrapper.find('.post-style-slider-dots');
			var currentSlide = 0;
			var totalSlides = $slides.length;

			if (totalSlides <= 1) {
				$prev.hide();
				$next.hide();
				$dots.hide();
				return;
			}

			$slides.first().addClass('active');

			for (var i = 0; i < totalSlides; i++) {
				var $dot = $('<button>')
					.addClass('post-style-slider-dot')
					.attr('data-slide', i)
					.attr('aria-label', 'Go to slide ' + (i + 1));
				if (i === 0) {
					$dot.addClass('active');
				}
				$dots.append($dot);
			}

			var $dotButtons = $dots.find('.post-style-slider-dot');

			function showSlide(index) {
				$slides.removeClass('active');
				$dotButtons.removeClass('active');
				$slides.eq(index).addClass('active');
				$dotButtons.eq(index).addClass('active');
				currentSlide = index;
			}

			function nextSlide() {
				var next = (currentSlide + 1) % totalSlides;
				showSlide(next);
			}

			function prevSlide() {
				var prev = (currentSlide - 1 + totalSlides) % totalSlides;
				showSlide(prev);
			}

			$next.on('click', nextSlide);
			$prev.on('click', prevSlide);

			$dotButtons.on('click', function() {
				var slideIndex = parseInt($(this).data('slide'), 10);
				showSlide(slideIndex);
			});

			var autoplayInterval = setInterval(nextSlide, 5000);

			$wrapper.on('mouseenter', function() {
				clearInterval(autoplayInterval);
			}).on('mouseleave', function() {
				autoplayInterval = setInterval(nextSlide, 5000);
			});
		});
	});
})(jQuery);

