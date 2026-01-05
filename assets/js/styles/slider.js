/**
 * Post Style - Slider JavaScript
 * Enhanced with smooth transitions and keyboard navigation
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
			var isTransitioning = false;
			var autoplayInterval = null;
			var autoplayDelay = 6000;

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
					.attr('aria-label', 'Go to slide ' + (i + 1))
					.attr('type', 'button');
				if (i === 0) {
					$dot.addClass('active');
				}
				$dots.append($dot);
			}

			var $dotButtons = $dots.find('.post-style-slider-dot');

			function showSlide(index, direction) {
				if (isTransitioning) return;
				if (index === currentSlide) return;
				
				isTransitioning = true;

				var $current = $slides.eq(currentSlide);
				var $nextSlide = $slides.eq(index);

				$current.removeClass('active');
				if (direction === 'next') {
					$current.addClass('prev');
				} else {
					$current.removeClass('prev');
				}
				
				$dotButtons.removeClass('active');

				setTimeout(function() {
					$nextSlide.removeClass('prev');
					$nextSlide.addClass('active');
					$dotButtons.eq(index).addClass('active');
					
					setTimeout(function() {
						$current.removeClass('prev');
						currentSlide = index;
						isTransitioning = false;
					}, 100);
				}, 50);
			}

			function nextSlide() {
				if (isTransitioning) return;
				var next = (currentSlide + 1) % totalSlides;
				showSlide(next, 'next');
				resetAutoplay();
			}

			function prevSlide() {
				if (isTransitioning) return;
				var prev = (currentSlide - 1 + totalSlides) % totalSlides;
				showSlide(prev, 'prev');
				resetAutoplay();
			}

			function startAutoplay() {
				autoplayInterval = setInterval(nextSlide, autoplayDelay);
			}

			function stopAutoplay() {
				if (autoplayInterval) {
					clearInterval(autoplayInterval);
					autoplayInterval = null;
				}
			}

			function resetAutoplay() {
				stopAutoplay();
				startAutoplay();
			}

			$next.on('click', function(e) {
				e.preventDefault();
				nextSlide();
			});

			$prev.on('click', function(e) {
				e.preventDefault();
				prevSlide();
			});

			$dotButtons.on('click', function(e) {
				e.preventDefault();
				var slideIndex = parseInt($(this).data('slide'), 10);
				if (slideIndex !== currentSlide) {
					showSlide(slideIndex);
					resetAutoplay();
				}
			});

			$wrapper.on('mouseenter', stopAutoplay).on('mouseleave', startAutoplay);

			$wrapper.on('keydown', function(e) {
				if (e.keyCode === 37) {
					e.preventDefault();
					prevSlide();
				} else if (e.keyCode === 39) {
					e.preventDefault();
					nextSlide();
				}
			});

			$wrapper.attr('tabindex', '0');

			var touchStartX = 0;
			var touchEndX = 0;

			$wrapper.on('touchstart', function(e) {
				touchStartX = e.originalEvent.touches[0].clientX;
			});

			$wrapper.on('touchend', function(e) {
				touchEndX = e.originalEvent.changedTouches[0].clientX;
				handleSwipe();
			});

			function handleSwipe() {
				var swipeThreshold = 50;
				var diff = touchStartX - touchEndX;

				if (Math.abs(diff) > swipeThreshold) {
					if (diff > 0) {
						nextSlide();
					} else {
						prevSlide();
					}
				}
			}

			startAutoplay();
		});
	});
})(jQuery);

