jQuery(function() {
	if (ebook_store_license_key != '') {
		jQuery.getJSON('https://www.shopfiles.com/api/wordpress_license.php?product=ebook_store&key=' + ebook_store_license_key,function(data) {
			if (data.found == 1) {
				console.log(data);
				jQuery('.goPro').last().remove();
				jQuery('.goPro').last().remove();
				//accept=".pdf,.zip"
				jQuery('#ebook_wp_custom_attachment_ebook').attr('accept','.pdf,.zip,.mobi,.epub,.txt');
			} else {
				alert(data.error);
				ebook_store_no_license();
			}
		});
	} else {
		ebook_store_no_license();
	}
});
function ebook_store_no_license() {
	jQuery('.goPro input,.goPro2').click(function(e) {
	jQuery('.goPro input').prop('checked',false);
	jQuery('.goPro input[type="text"]').attr('readonly',true);
	jQuery('.goPro select').attr('readonly',true);
		if (confirm('Sorry, this feature is available in the Pro version only, would you like to upgrade now?')) {
			window.location = 'http://www.shopfiles.com/index.php/products/wordpress-ebook-store';
		}
	});
	jQuery('.goPro, .goPro2').css({background: '#FFB0B0', opacity: 1});
	jQuery('input[type=radio].goPro2').remove();
}