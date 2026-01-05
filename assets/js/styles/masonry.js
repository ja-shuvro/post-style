/**
 * Post Style - Masonry JavaScript
 * Ensures proper layout on image load
 *
 * @package PostStyle
 */

(function($) {
	'use strict';

	function initMasonry() {
		$('.post-style-masonry').each(function() {
			var $masonry = $(this);
			var $items = $masonry.find('.post-style-masonry-item');

			$items.find('img').on('load', function() {
				$masonry.css('height', 'auto');
			});
		});
	}

	$(document).ready(function() {
		initMasonry();
	});

	$(window).on('load', function() {
		initMasonry();
	});
})(jQuery);

