/**
 * Post Style - Admin JavaScript
 *
 * @package PostStyle
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		var $form = $('#post-style-generator');
		var $shortcodeBox = $('#generated-shortcode');
		var $copyButton = $('#copy-shortcode');
		var $excerptCheckbox = $('#show_excerpt');
		var $excerptLengthRow = $('#excerpt_length_row');

		function generateShortcode() {
			var atts = [];
			var style = $('#style').val();
			var postsPerPage = $('#posts_per_page').val();
			var postType = $('#post_type').val();
			var columns = $('#columns').val();
			var category = $('#category').val();
			var orderby = $('#orderby').val();
			var order = $('#order').val();
			var showImage = $('#show_image').is(':checked');
			var showExcerpt = $excerptCheckbox.is(':checked');
			var showMeta = $('#show_meta').is(':checked');
			var excerptLength = $('#excerpt_length').val();

			if (style && style !== 'list') {
				atts.push('style="' + style + '"');
			}

			if (postsPerPage && postsPerPage !== '6') {
				atts.push('posts_per_page="' + postsPerPage + '"');
			}

			if (postType && postType !== 'post') {
				atts.push('post_type="' + postType + '"');
			}

			if (columns && columns !== '3') {
				atts.push('columns="' + columns + '"');
			}

			if (category) {
				atts.push('category="' + category + '"');
			}

			if (orderby && orderby !== 'date') {
				atts.push('orderby="' + orderby + '"');
			}

			if (order && order !== 'DESC') {
				atts.push('order="' + order + '"');
			}

			if (!showImage) {
				atts.push('show_image="no"');
			}

			if (!showExcerpt) {
				atts.push('show_excerpt="no"');
			} else if (excerptLength && excerptLength !== '20') {
				atts.push('excerpt_length="' + excerptLength + '"');
			}

			if (!showMeta) {
				atts.push('show_meta="no"');
			}

			var shortcode = '[post_style';
			if (atts.length > 0) {
				shortcode += ' ' + atts.join(' ');
			}
			shortcode += ']';

			$shortcodeBox.text(shortcode);
		}

		$form.on('change input', 'select, input', function() {
			generateShortcode();
		});

		$excerptCheckbox.on('change', function() {
			if ($(this).is(':checked')) {
				$excerptLengthRow.slideDown();
			} else {
				$excerptLengthRow.slideUp();
			}
			generateShortcode();
		});

		$copyButton.on('click', function() {
			var shortcode = $shortcodeBox.text();
			var $temp = $('<textarea>');
			$('body').append($temp);
			$temp.val(shortcode).select();
			document.execCommand('copy');
			$temp.remove();

			var originalText = $copyButton.text();
			$copyButton.text('Copied!');
			setTimeout(function() {
				$copyButton.text(originalText);
			}, 2000);
		});

		generateShortcode();
	});
})(jQuery);

