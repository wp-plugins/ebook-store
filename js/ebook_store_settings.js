jQuery(function() {
	if (typeof ebook_store_license_key != 'undefined') {
		if (ebook_store_license_key != '') {
			jQuery.getJSON('https://www.shopfiles.com/api/wordpress_license.php?product=ebook_store&key=' + ebook_store_license_key,function(data) {
				if (data.found == 1) {
					//console.log(data);
					jQuery('.goPro').last().remove();
					jQuery('.goPro').last().remove();
					//accept=".pdf,.zip"
					jQuery('#ebook_wp_custom_attachment_ebook_pdf').attr('accept','.pdf,.zip,.mobi,.epub,.txt,.m4b,.mp3');
				} else {
					alert(data.error);
					ebook_store_no_license();
				}
			});
		} else {
			ebook_store_no_license();
		}
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
	jQuery('.goPro2 input[type=file]').attr('disabled','disabled');
}
function ebook_store_embed_code(ebook_id) {
	//tinyMCE.activeEditor.setContent(tinyMCE.activeEditor.getContent() + '[ebook_store ebook_id="' + ebook_id + '"]', {format : 'raw'});
	// alert('Success! eBook embed code is added to the bottom of the article, you can move it if needed.');
	if (tinyMCE.activeEditor != null) {
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[ebook_store ebook_id="' + ebook_id + '"]');
		jQuery('#content').val(jQuery('#content').val() + '[ebook_store ebook_id="' + ebook_id + '"]');
	} else {
		jQuery('#content').val(jQuery('#content').val() + '[ebook_store ebook_id="' + ebook_id + '"]');
	}
	var body = jQuery("html, body");
	body.animate({scrollTop:0}, '500', 'swing', function() { 
	   
	});

}
