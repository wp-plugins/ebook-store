jQuery(function() {
	jQuery('.goPro input,.goPro2').click(function(e) {
		jQuery('.goPro input').prop('checked',false);
		if (confirm('Sorry, this feature is available in the Pro version only, would you like to upgrade now?')) {
			window.location = 'http://www.shopfiles.com/index.php/products/wordpress-ebook-store';
		}
			
	});
	jQuery('.goPro, .goPro2').css({background: '#FFB0B0', opacity: 1});
	jQuery('input[type=radio].goPro2').remove();
	
	// jQuery('.goPro').last().remove();
	// jQuery('.goPro').last().remove();
	
});