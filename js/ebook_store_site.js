function ebook_store_popup(callback, obj) {
	jQuery(function() {
		var fd = jQuery('#ebook_formData').first();
	    fd.easyModal({
		//top: 100,
		//autoOpen: true,
		overlayOpacity: 0.3,
		overlayColor: "#333",
		overlayClose: true,
		closeOnEscape: true
	});
	    jQuery.get('index.php?task=formContent',function(data) {
	    	fd.html(data);
	    	fd.fadeIn().trigger('openModal');
	    	jQuery('button[name="submit"]:not(.function_set)').click(function(e) {
	    		e.preventDefault();
	    		var data = jQuery('form',fd).first().serialize();
	    		data = data + '&md5_nonce=' + jQuery(obj).attr('data-md5_nonce');
	    		fd.fadeOut();
	    		jQuery.post('index.php?task=ebook_store_form_input',data,function(ret) {
					fd.trigger('closeModal');
					callback();
					jQuery('.lean-overlay').remove();
	    		});
	   		}).addClass('function_set');
	    });
	});
	jQuery('.lean-overlay').click(function (e){
		jQuery('.lean-overlay').remove();
	});
}
jQuery(document).ready(function () {
	jQuery('.ebook_buy_link').click(function(e) {
		e.preventDefault();
	});
});