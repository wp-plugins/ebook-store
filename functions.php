<?php 
function ebook_activate() {
	// register taxonomies/post types here
	flush_rewrite_rules();
}

function ebook_deactivate() {
	flush_rewrite_rules();
}


function ebook_create_post_type() {
	$labels = array(
			'name' => _x('eBook Seller', 'post type general name'),
			'singular_name' => _x('eBook', 'post type singular name'),
			'add_new' => _x('Add New eBook', 'ebook'),
			'add_new_item' => __('Add New eBook Item'),
			'edit_item' => __('Edit Item'),
			'all_items'          => 'eBooks',
			'new_item' => __('New Ebook Item'),
			'view_item' => __('View Ebook Item'),
			'search_items' => __('Search Ebook'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
	);

	$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array('slug','ebook'),
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => 5,
			'taxonomies' => array('category'),
			'supports' => array('title','editor','thumbnail')
	);

	register_post_type( 'ebook' , $args );

	///////
	$labels = array(
			'name'               => 'Authors',
			'singular_name'      => 'Author',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Author',
			'edit_item'          => 'Edit Author',
			'new_item'           => 'New Author',
			'all_items'          => 'Authors',
			'view_item'          => 'View Author',
			'search_items'       => 'Search Author',
			'not_found'          => 'No authors found',
			'not_found_in_trash' => 'No authors found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Authors'
	);

	$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=ebook',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'author' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => array( 'title', 'thumbnail','comments' )
	);

	register_post_type( 'ebook_author', $args );
	/////
	$labels = array(
			'name'               => 'Publishers',
			'singular_name'      => 'Publisher',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Publisher',
			'edit_item'          => 'Edit Publisher',
			'new_item'           => 'New Publisher',
			'all_items'          => 'Publishers',
			'view_item'          => 'View Publisher',
			'search_items'       => 'Search Publisher',
			'not_found'          => 'No Publishers found',
			'not_found_in_trash' => 'No Publishers found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Publishers'
	);

	$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=ebook',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'publisher' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => array( 'title', 'thumbnail','comments' )
	);

	register_post_type( 'ebook_publisher', $args );
	///////
	$labels = array(
			'name'               => 'Orders',
			'singular_name'      => 'Order',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Order',
			'edit_item'          => 'Edit Order',
			'new_item'           => 'New Order',
			'all_items'          => 'Orders',
			'view_item'          => 'View Order Details',
			'search_items'       => 'Search Order',
			'not_found'          => 'No orders found',
			'not_found_in_trash' => 'No orders found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Authors'
	);

	$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=ebook',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'order' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => array('title','excerpt')
	);

	register_post_type( 'ebook_order', $args );

}

function ebook_add_custom_meta_boxes() {

	// Define the custom attachment for posts
	add_meta_box(
	'ebook_wp_custom_attachment',
	'eBook Details',
	'ebook_wp_custom_attachment',
	'ebook',
	'side'
			);
			// Define the custom attachment for posts
			add_meta_box(
			'ebook_code_box',
			'eBook Embed Code Box',
			'ebook_code_box',
			'ebook',
			'side'
					);
					add_meta_box(
					'ebook_order_box',
					'Order details',
					'ebook_order_box',
					'ebook_order',
					'side'
							);
}

function ebook_order_box() {
	$fields = array('mc_gross', 'protection_eligibility', 'payer_id', 'tax', 'payment_date', 'payment_status', 'charset', 'first_name', 'mc_fee', 'notify_version', 'custom', 'payer_status', 'business', 'quantity', 'verify_sign', 'payer_email', 'txn_id', 'payment_type', 'last_name', 'receiver_email', 'payment_fee', 'receiver_id', 'txn_type', 'item_name', 'mc_currency', 'item_number', 'residence_country', 'test_ipn', 'handling_amount', 'transaction_subject', 'payment_gross', 'shipping', 'ipn_track_id');
	wp_nonce_field(plugin_basename(__FILE__), 'ebook_order_nonce');
	$order = get_post_meta(get_the_ID(), 'ebook_order', true);
	foreach ($fields as $f) {
		echo "<p><label>$f</label><br /><input type=text name=\"order[$f]\" value=\"" . get_post_meta(get_the_ID(),$f,true) . "\" size=64 /></p>";
	}
}


function save_custom_meta_data_order($id) {

	/* --- security verification --- */
	if(!wp_verify_nonce(@$_POST['ebook_order_nonce'], plugin_basename(__FILE__))) {
		return $id;
	} // end if

	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $id;
	} // end if

	if('page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $id)) {
			return $id;
		} // end if
	} else {
		if(!current_user_can('edit_page', $id)) {
			return $id;
		} // end if
	} // end if
	/* - end security verification - */
	foreach ($_POST['order'] as $k => $v) {
		update_post_meta($id, $k, $v);
	}
}

function ebook_code_box() {
	wp_reset_postdata();
	$post_id = get_the_ID();
	if ($_REQUEST['post'] > 0 && $_REQUEST['post'] != $post_id) {
		$post_id = $_REQUEST['post'];
	}
	echo '<input id="ebook_code" onClick="this.select()" readonly type="text" size="30" value=\'[ebook_store ebook_id="' . $post_id . '"]\' />';
}
function ebook_wp_custom_attachment() {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	wp_enqueue_script( 'zeroslipboard', plugins_url( '/js/zeroclipboard-1.3.1/ZeroClipboard.js' , __FILE__ ), array(), '1.0.0', true );

	$img = get_post_meta(get_the_ID(), 'ebook_wp_custom_attachment', true);
	$ebook = get_post_meta(get_the_ID(), 'ebook', true);

	$img_side_photo = get_post_meta(get_the_ID(), 'ebook_wp_custom_attachment_side_photo', true);
	$img_cover = get_post_meta(get_the_ID(), 'ebook_wp_custom_attachment_cover', true);
	$preview = get_post_meta(get_the_ID(), 'ebook_wp_custom_attachment_preview', true);

	wp_nonce_field(plugin_basename(__FILE__), 'ebook_wp_custom_attachment_nonce');
	$new = new WP_Query('post_type=ebook_author');
	while ($new->have_posts()) : $new->the_post();
	unset($selected);
	if (in_array(get_the_ID(), $ebook['ebook_author'])) {
		$selected = ' selected';
	}
	@$ebook_authors .=  '<option value="' . get_the_ID() . '"' . $selected . '>' . get_the_title() . '</option>';
	endwhile;
	$new = new WP_Query('post_type=ebook_publisher');
	while ($new->have_posts()) : $new->the_post();
	unset($selected);
	if (in_array(get_the_ID(), $ebook['ebook_publisher'])) {
		$selected = ' selected';
	}
	@$ebook_publishers .= '<option value="' . get_the_ID() . '"' . $selected . '>' . get_the_title() . '</option>';
	endwhile;
	$html .= '<div style="float:none; clear:both; overflow:auto;"><div class="ebookSeller50Percent">
			<h1 style="line-height:1.5em;">After you have uploaded the book, please copy the code from the "eBook Embed Code Box", and paste it inside the article or page where you want the eBook ordering form to appear.</h1>';
	$html .= '<p class="">Upload your eBook file here' . (@$img['url'] != '' ? '<br class="clear">Currently uploaded: <a href="javascript:alert(\'File is protected and impossible to access by using direct path, this is to avoid downloads without payment.\');">' . @basename($img['url']) . '</a>' : '<br />Ebook file is still not uploaded.');
	$html .= '<br /><input type="file" id="ebook_wp_custom_attachment" name="ebook_wp_custom_attachment" value="" size="25">';
	$html .= '</p>';
	$html .= '<p class="">Preview of the book' . (@$preview['url'] != '' ? '<br class="clear">Currently uploaded: <a href="' . @$preview['url'] . '">' . @basename($preview['url']) . '</a>' : '<br />Preview file is still not uploaded.');
	$html .= '<br /><input type="file" id="ebook_wp_custom_attachment_preview" name="ebook_wp_custom_attachment_preview" value="" size="25">';
	$html .= '</p>';
	$html .= '<p><b>Cover Image</b><span class="description"> (180x260 recommended)</span>' . (@$img_cover['url'] != '' ? '<br class="clear">Currently uploaded: <a href="' . @$img_cover['url'] . '">' . @basename($img_cover['url']) . '</a>' : '<br />Cover image is missing.');
	$html .= '<br /><input name="ebook_wp_custom_attachment_cover" type="file"></p>';
	$html .= '<p><b>Side Image</b><span class="description"> (20x260 recommended)</span>' . (@$img_side_photo['url'] != '' ? '<br class="clear">Currently uploaded: <a href="' . @$img_side_photo['url'] . '">' . @basename($img_side_photo['url']) . '</a>' : '<br />Side image is missing.');
	$html .= '<br /><input name="ebook_wp_custom_attachment_side_photo" type="file"></p>';
	$html .= '
<form action="" method="get">
<p>Author<br /><select name="ebook[ebook_author][]" multiple>
<option value="0">None</option>
' . $ebook_authors . '
</select></p>
</div>
<div class="ebookSeller50Percent">
<p>Publisher<br /><select name="ebook[ebook_publisher][]" multiple>
<option value="0">None</option>
' . $ebook_publishers . '
</select></p>
<p>Date<br /><input id="ebook_date" name="ebook[ebook_date]" type="text" value="' . @$ebook['ebook_date'] . '"></p>
<p>Pages<br /><input name="ebook[ebook_pages]" type="number" value="' . @$ebook['ebook_pages'] . '"></p>
<!--
<p><input name="ebook[ebook_qrcode]" type="checkbox" value="1" . ' . (@$ebook['ebook_qrcode'] != '' ? 'checked' : '') . '>QR Code Watermark <span class="description">(<a href="http://shopfiles.com/samples/protected_cv.pdf" target="_blank">see sample</a>, PDF only)</span></p>
<p><input name="ebook[ebook_set_password]" type="checkbox" value="1" . ' . (@$ebook['ebook_set_password'] != '' ? 'checked' : '') . '>Set password <span class="description">(buyer\'s email, PDF only)</span></p>
<p><input name="ebook[ebook_disable_printing]" type="checkbox" value="1" . ' . (@$ebook['ebook_disable_printing'] != '' ? 'checked' : '') . '>Disable printing <span class="description">(PDF only)</span></p>
<p><input name="ebook[ebook_emailDelivery]" type="checkbox" value="1" . ' . (@$ebook['ebook_emailDelivery'] != '' ? 'checked' : '') . '>Send a copy to buyer\'s email</span></p>
-->
<p>Price<br /><input name="ebook[ebook_price]" placeholder="0.00" type="number" step="any" value="' . @$ebook['ebook_price'] . '"></p>
</form>
</div>
</div>
<script>
jQuery(document).ready(function() {
    jQuery(\'#ebook_date\').datepicker({
        dateFormat : \'dd-mm-yy\'
    });
	jQuery(\'#wp-admin-bar-view\').hide();
});
</script>
    ';

	echo $html;
} // end ebook_wp_custom_attachment
function ebook_set_upload_dir( $upload ) {

	// Override the year / month being based on the post publication date, if year/month organization is enabled
	if ( get_option( 'uploads_use_yearmonth_folders' ) ) {
		// Generate the yearly and monthly dirs
		$time = current_time( 'mysql' );
		$y = substr( $time, 0, 4 );
		$m = substr( $time, 5, 2 );
		$upload['subdir'] = "/$y/$m";
	}

	$upload['subdir'] = '/ebooks' . $upload['subdir'];
	$upload['path']   = $upload['basedir'] . $upload['subdir'];
	$upload['url']    = $upload['baseurl'] . $upload['subdir'];
	$htaccess = "Options -Indexes
deny from all
";
	@file_put_contents($upload['basedir'] . '/ebooks/.htaccess', $htaccess);
	return $upload;
}
function ebook_set_upload_dir_preview( $upload ) {

	// Override the year / month being based on the post publication date, if year/month organization is enabled
	if ( get_option( 'uploads_use_yearmonth_folders' ) ) {
		// Generate the yearly and monthly dirs
		$time = current_time( 'mysql' );
		$y = substr( $time, 0, 4 );
		$m = substr( $time, 5, 2 );
		$upload['subdir'] = "/$y/$m";
	}

	$upload['subdir'] = '/ebooks_misc' . $upload['subdir'];
	$upload['path']   = $upload['basedir'] . $upload['subdir'];
	$upload['url']    = $upload['baseurl'] . $upload['subdir'];
	return $upload;
}
function save_custom_meta_data($id) {
	add_filter( 'upload_dir', 'ebook_set_upload_dir' );
	
	/* --- security verification --- */
	if(!wp_verify_nonce(@$_POST['ebook_wp_custom_attachment_nonce'], plugin_basename(__FILE__))) {
		return $id;
	} // end if

	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $id;
	} // end if

	if('page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $id)) {
			return $id;
		} // end if
	} else {
		if(!current_user_can('edit_page', $id)) {
			return $id;
		} // end if
	} // end if
	/* - end security verification - */
	update_post_meta($id, 'ebook', $_POST['ebook']);

	// Make sure the file array isn't empty
	if(!empty($_FILES['ebook_wp_custom_attachment']['name'])) {
		 
		// Setup the array of supported file types. In this case, it's just PDF.
		$supported_types = array('application/pdf','application/x-mobipocket-ebook','application/epub+zip','application/zip','application/octet-stream');
		
		// Get the file type of the upload
		$arr_file_type = wp_check_filetype(basename($_FILES['ebook_wp_custom_attachment']['name']));
		$uploaded_type = $arr_file_type['type'];

		// Check if the type is supported. If not, throw an error.
		if(1) {

			// Use the WordPress API to upload the file
			$upload = wp_upload_bits($_FILES['ebook_wp_custom_attachment']['name'], null, file_get_contents($_FILES['ebook_wp_custom_attachment']['tmp_name']));

			if(isset($upload['error']) && $upload['error'] != 0) {
				wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
			} else {
				add_post_meta($id, 'ebook_wp_custom_attachment', $upload);
				update_post_meta($id, 'ebook_wp_custom_attachment', $upload);
			} // end if/else

		} else {
			wp_die("The file type that you've uploaded is not a mobile book format.");
		} // end if/else

	} // end if
	add_filter( 'upload_dir', 'ebook_set_upload_dir_preview' );
	
	if(!empty($_FILES['ebook_wp_custom_attachment_preview']['name'])) {

		// Setup the array of supported file types. In this case, it's just PDF.
		$supported_types = array('application/pdf','application/x-mobipocket-ebook','application/epub+zip','application/zip','application/octet-stream');
		
		// Get the file type of the upload
		$arr_file_type = wp_check_filetype(basename($_FILES['ebook_wp_custom_attachment_preview']['name']));
		$uploaded_type = $arr_file_type['type'];

		// Check if the type is supported. If not, throw an error.
		if(1) {

			// Use the WordPress API to upload the file
			$upload = wp_upload_bits($_FILES['ebook_wp_custom_attachment_preview']['name'], null, file_get_contents($_FILES['ebook_wp_custom_attachment_preview']['tmp_name']));

			if(isset($upload['error']) && $upload['error'] != 0) {
				wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
			} else {
				add_post_meta($id, 'ebook_wp_custom_attachment_preview', $upload);
				update_post_meta($id, 'ebook_wp_custom_attachment_preview', $upload);
			} // end if/else

		} else {
			wp_die("The file type that you've uploaded is not a mobile book format.");
		} // end if/else

	} // end if


	//check the side photo
	if(!empty($_FILES['ebook_wp_custom_attachment_side_photo']['name'])) {

		// Setup the array of supported file types. In this case, it's just PDF.
		$supported_types = array('image/jpeg','image/gif','image/png','image/svg+xml');

		// Get the file type of the upload
		$arr_file_type = wp_check_filetype(basename($_FILES['ebook_wp_custom_attachment_side_photo']['name']));
		$uploaded_type = $arr_file_type['type'];

		// Check if the type is supported. If not, throw an error.
		if(1) {

			// Use the WordPress API to upload the file
			$upload = wp_upload_bits($_FILES['ebook_wp_custom_attachment_side_photo']['name'], null, file_get_contents($_FILES['ebook_wp_custom_attachment_side_photo']['tmp_name']));

			if(isset($upload['error']) && $upload['error'] != 0) {
				wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
			} else {
				add_post_meta($id, 'ebook_wp_custom_attachment_side_photo', $upload);
				update_post_meta($id, 'ebook_wp_custom_attachment_side_photo', $upload);
			} // end if/else

		} else {
			wp_die("The file type that you've uploaded is not a mobile book format.");
		} // end if/else

	} // end if
	//cover photo
	if(!empty($_FILES['ebook_wp_custom_attachment_cover']['name'])) {

		// Setup the array of supported file types. In this case, it's just PDF.
		$supported_types = array('image/jpeg','image/gif','image/png','image/svg+xml');
			
		// Get the file type of the upload
		$arr_file_type = wp_check_filetype(basename($_FILES['ebook_wp_custom_attachment_cover']['name']));
		$uploaded_type = $arr_file_type['type'];

		// Check if the type is supported. If not, throw an error.
		if(1) {

			// Use the WordPress API to upload the file
			$upload = wp_upload_bits($_FILES['ebook_wp_custom_attachment_cover']['name'], null, file_get_contents($_FILES['ebook_wp_custom_attachment_cover']['tmp_name']));

			if(isset($upload['error']) && $upload['error'] != 0) {
				wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
			} else {
				add_post_meta($id, 'ebook_wp_custom_attachment_cover', $upload);
				update_post_meta($id, 'ebook_wp_custom_attachment_cover', $upload);
			} // end if/else

		} else {
			wp_die("The file type that you've uploaded is not a mobile book format.");
		} // end if/else

	} // end if



} // end save_custom_meta_data

function ebook_update_edit_form() {
	echo ' enctype="multipart/form-data"';
} // end ebook_update_edit_form
function ebook_download_link($ebook_order) {
	$link = add_query_arg(array('ebook_key' => $ebook_order['ebook_key'][0], 'action' => 'download'),get_permalink($ebook_order['ebook'][0]));
	$link = remove_query_arg('p',$link);
	$post_id = 11;
	$post = get_post($ebook_order['ebook'][0]);
	$slug = $post->post_name;
	$link = add_query_arg(array('ebook' => $slug),$link);
	return $link;
}
function humanFileSize($size,$unit="") {
	if( (!$unit && $size >= 1<<30) || $unit == "GB")
		return number_format($size/(1<<30),2)."GB";
	if( (!$unit && $size >= 1<<20) || $unit == "MB")
		return number_format($size/(1<<20),2)."MB";
	if( (!$unit && $size >= 1<<10) || $unit == "KB")
		return number_format($size/(1<<10),2)."KB";
	return number_format($size)." bytes";
}
function ebook_store( $atts ){
	$post_id = get_the_ID();
	if (@$_REQUEST['ebook_key'] != false && @$_REQUEST['action'] == 'thank_you') {
		$content = get_option('thankyou_page',true);
		$ebook_order = ebook_get_order('ebook_key', $_REQUEST['ebook_key']);
		if (!$ebook_order) {
			return 'Sorry, order not found, please wait the screen will refresh in 5 seconds!<script>   window.setTimeout(\'location.reload()\', 5000);
</script>';
		}
		$file = get_post_meta($ebook_order['ebook'][0],'ebook_wp_custom_attachment',true);
		//wp_die(print_r($file,true));
		$ebook_order['downloadlink'][0] = ebook_download_link($ebook_order);
		$ebook_order['filesize'][0] = humanFileSize(filesize($file['file']));
		foreach ($ebook_order as $k => $arr) {
			$content = str_replace('%%' . $k . '%%', $arr[0], $content);
		}
		return apply_filters('the_content',$content);
	}
	$items = '';
	$args = array( 'post_type' => 'ebook', 'posts_per_page' => -1, 'p' => $atts['ebook_id'] );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
	/*the_title();
	 echo '<div class="entry-content">';
	the_content();
	echo '</div>';*/
	$ebook = get_post_meta(get_the_ID(), 'ebook', true);
	$ebook_key = md5(NONCE_KEY . get_the_ID() . $ebook['ebook_price'] . mt_rand(1,100000));
	 
	$custom = get_the_ID() . '|' . md5(NONCE_KEY . get_the_ID() . @number_format($ebook['ebook_price'], 2, '.', ','));
	 
	$c = new Currencies();
	$img = get_post_meta(get_the_ID(), 'ebook_wp_custom_attachment', true);
	$preview = get_post_meta(get_the_ID(), 'ebook_wp_custom_attachment_preview', true);
	$cover = get_post_meta(get_the_ID(),'ebook_wp_custom_attachment_cover',true);
	$side = get_post_meta(get_the_ID(),'ebook_wp_custom_attachment_side_photo',true);
	//style="background-url:(' . $side['url'] . ');"
	if (is_array($ebook['ebook_publisher'])) {
		$publishers = array();
		foreach ($ebook['ebook_publisher'] as $p => $pp) {
			$publishers[] = get_the_title($pp);
		}		
	}
	if (is_array($ebook['ebook_author'])) {
		$authors = array();
		foreach ($ebook['ebook_author'] as $p => $pp) {
			$authors[] = get_the_title($pp);
		}
	}
	$publishers = @implode(", ", $publishers);
	$authors = @implode(", ", $authors);
	/* div class front, where is it?*/
	$items .= '
            <figure>
                            <div class="perspective"><div class="book" data-book="book-' . get_the_ID() . '"><div class="cover"><div data-dd="dd" class="front" style="background: url(' . @$cover['url'] . ');"></div><div class="inner inner-left"></div></div><div class="inner inner-right"></div></div></div><div class="buttons">
                            		<a href="#" style="display:none;">Look inside</a><a href="#" class="details_link">Details</a><a target="_blank" href="' . @$preview['url'] . '" class="ebook_buy_link">Preview</a>
<a class="ebook_buy_link" href="#" onClick="document.getElementById(\'xxd\').submit(); return false;">Buy (' . $c->getSymbol(get_option('paypal_currency','USD')) . @number_format($ebook['ebook_price'],2) . ')</a>
<form method="post" id="xxd" name="dmp_order_form" action="https://www' . (get_option('paypal_sandbox') != '' ? '.sandbox' : '') . '.paypal.com/cgi-bin/webscr">
		<input type="hidden" name="rm" value="0">
		<input type="hidden" name="discount_rate" value="0">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="charset" value="utf-8">
		<input type="hidden" name="lc" value="' . get_option('paypal_language') . '">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="button_subtype" value="products">
		<input type="hidden" name="return" value="' . add_query_arg(array('ebook_key' => $ebook_key, 'action' => 'thank_you'),get_permalink($post_id)) . '">
		<input type="hidden" name="cancel_return" value="">
		<input type="hidden" name="notify_url" value="' . add_query_arg(array('task' => 'ipn','ebook_key' => $ebook_key), get_permalink(get_the_ID())) . '">
		<input type="hidden" name="item_name" value="' . get_the_title() . '">
		<input type="hidden" name="item_number" value="1">
		<input type="hidden" name="tax_rate" value="' . get_option('vat_percent') . '">
		<input type="hidden" name="amount" value="' . $ebook['ebook_price'] . '">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="custom" value="' . $custom .'">
		<input type="hidden" name="business" id="af69ae50c1be74757508c8f7fae10abd" value="' . get_option('paypal_account') . '">
		<input type="hidden" name="receiver_email" id="af69ae50c1be74757508c8f7fae10abd0xff" value="' . get_option('paypal_account') . '">
		<input type="hidden" name="currency_code" value="' . get_option('paypal_currency') . '">
		<input type="hidden" name="cbt" value="' . get_option('paypal_return_button_text') . '">
		<input type="hidden" name="no_note" value="1">
		</form>
</div>
                            <figcaption><h2>' . get_the_title() . ' <span>' . $authors . '</span></h2></figcaption>
                            <div class="details">
                                <ul>
                                    <li>' . get_the_content() . '</li>
                                    <li>' . $publishers . '</li>
                                    <li>' . date("F j, Y",strtotime($ebook['ebook_date'])) . '</li>
                                    <li>' . $ebook['ebook_pages'] . ' pages</li>
                                </ul>
                            <span class="close-details"></span></div>
            </figure>
            <style>
.book[data-book="book-' . get_the_ID() . '"] .cover::before {
background: url(' . @$side['url'] . ');
}
            </style>
            ';
	endwhile;

	return '
        <link rel="stylesheet" type="text/css" href="' . plugins_url('css/bookblock.css',__FILE__) . '" />
        <link rel="stylesheet" type="text/css" href="' . plugins_url('css/component.css',__FILE__) . '" />
        <script src="' . plugins_url('js/modernizr.custom.js',__FILE__) . '"></script>
<div id="bookshelf" class="bookshelf">
                    ' . $items . '
                </div>

        <div class="bb-custom-wrapper" id="book-1">
            <div class="bb-bookblock">
                <div class="bb-item">
                    <div class="bb-custom-side page-layout-3">
                        <div>
                            <h3>Portraits</h3>
                            <p>Photography (1999 &ndash; 2013)</p>
                        </div>
                    </div>
                    <div class="bb-custom-side page-layout-3">
                    </div>
                </div>
                <div class="bb-item">
                    <div class="bb-custom-side page-layout-1">
                        <h3>
                            Chapter 9 <span>Nomadic Lifestyle</span>
                        </h3>
                    </div>
                    <div class="bb-custom-side page-layout-1">
                        <p>Candy canes lollipop macaroon marshmallow gummi bears tiramisu. Dessert croissant cupcake candy canes. Bear claw faworki faworki lemon drops. Faworki marzipan sugar plum jelly-o marzipan cookie.</p>
                    </div>
                </div>
                <div class="bb-item">
                    <div class="bb-custom-side page-layout-2">
                        <div>
                            <h3>Aa</h3>
                            <p>Faworki marzipan sugar plum jelly-o marzipan. Soufflé tootsie roll jelly beans. Sweet icing croissant dessert bear claw. Brownie dessert cheesecake danish jelly pudding bear claw soufflé.</p>
                        </div>
                        <div>
                            <h3>Bb</h3>
                            <p>Faworki marzipan sugar plum jelly-o marzipan. Soufflé tootsie roll jelly beans. Sweet icing croissant dessert bear claw. Brownie dessert cheesecake danish jelly pudding bear claw soufflé.</p>
                        </div>
                    </div>
                    <div class="bb-custom-side page-layout-2">
                        <div>
                            <h3>Cc</h3>
                            <p>Faworki marzipan sugar plum jelly-o marzipan. Soufflé tootsie roll jelly beans. Sweet icing croissant dessert bear claw. Brownie dessert cheesecake danish jelly pudding bear claw soufflé.</p>
                        </div>
                        <div>
                            <h3>Dd</h3>
                            <p>Faworki marzipan sugar plum jelly-o marzipan. Soufflé tootsie roll jelly beans. Sweet icing croissant dessert bear claw. Brownie dessert cheesecake danish jelly pudding bear claw soufflé.</p>
                        </div>
                    </div>
                </div>
            </div><!-- /bb-bookblock -->
            <nav>
                <a href="#" class="bb-nav-prev">Previous</a>
                <a href="#" class="bb-nav-next">Next</a>
                <a href="#" class="bb-nav-close">Close</a>
            </nav>
        </div><!-- /bb-custom-wrapper -->

        <script src="' . plugins_url('js/bookblock.min.js',__FILE__) . '"></script>
        <script src="' . plugins_url('js/classie.js',__FILE__) . '"></script>
        <script src="' . plugins_url('js/bookshelf.js',__FILE__) . '"></script>
    ';
}
function custom_enter_title_author( $input ) {
	global $post_type;

	if ( is_admin() && 'ebook_author' == $post_type )
		return __( 'Enter Author Name' );

	return $input;
}

function custom_enter_title_publisher( $input ) {
	global $post_type;

	if ( is_admin() && 'ebook_publisher' == $post_type )
		return __( 'Enter Publisher Name' );

	return $input;
}

class Currencies {

	public $currencies = array(

			'AUD' => array('name' => "Australian Dollar", 'symbol' => "A$", 'ASCII' => "A&#36;"),

			'CAD' => array('name' => "Canadian Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),

			'CZK' => array('name' => "Czech Koruna", 'symbol' => "Kč", 'ASCII' => ""),

			'DKK' => array('name' => "Danish Krone", 'symbol' => "Kr", 'ASCII' => ""),

			'EUR' => array('name' => "Euro", 'symbol' => "€", 'ASCII' => "&#128;"),

			'HKD' => array('name' => "Hong Kong Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),

			'HUF' => array('name' => "Hungarian Forint", 'symbol' => "Ft", 'ASCII' => ""),

			'ILS' => array('name' => "Israeli New Sheqel", 'symbol' => "₪", 'ASCII' => "&#8361;"),

			'JPY' => array('name' => "Japanese Yen", 'symbol' => "¥", 'ASCII' => "&#165;"),

			'MXN' => array('name' => "Mexican Peso", 'symbol' => "$", 'ASCII' => "&#36;"),

			'NOK' => array('name' => "Norwegian Krone", 'symbol' => "Kr", 'ASCII' => ""),

			'NZD' => array('name' => "New Zealand Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),

			'PHP' => array('name' => "Philippine Peso", 'symbol' => "₱", 'ASCII' => ""),

			'PLN' => array('name' => "Polish Zloty", 'symbol' => "zł", 'ASCII' => ""),

			'GBP' => array('name' => "Pound Sterling", 'symbol' => "£", 'ASCII' => "&#163;"),

			'SGD' => array('name' => "Singapore Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),

			'SEK' => array('name' => "Swedish Krona", 'symbol' => "kr", 'ASCII' => ""),

			'CHF' => array('name' => "Swiss Franc", 'symbol' => "CHF", 'ASCII' => ""),

			'TWD' => array('name' => "Taiwan New Dollar", 'symbol' => "NT$", 'ASCII' => "NT&#36;"),

			'THB' => array('name' => "Thai Baht", 'symbol' => "฿", 'ASCII' => "&#3647;"),

			'USD' => array('name' => "U.S. Dollar", 'symbol' => "$", 'ASCII' => "&#36;")

	);

	public function getSymbol($code = 'USD') {

		if (!empty($this->currencies[$code]['ASCII'])) {

			return (string) $this->currencies[$code]['ASCII'];

		}

		return (string) $this->currencies[$code]['symbol'];

	}

}

function order_columns($columns)
{
	$columns = array(
	//		'cb'	 	=> '<input type="checkbox" />',
	//		'thumbnail'	=>	'Thumbnail',
			'title' 	=> 'Buyer',
			'paypal'	=> 'PayPal',
			//		'featured' 	=> 'Featured',
			'product'	=>	'Product',
			'amount'	=>	'Amount',
			'country'	=> 	'Country',
			'date'		=>	'Date',
			'downloads'		=>	'Downloads',
	);
	return $columns;
}
function order_custom_columns($column)
{
	global $post;
	$c = new Currencies();
	switch ($column) {
		case "product":
			echo get_post_meta($post->ID,'item_name',true);
			break;
		case "amount":
			$mc_currency = get_post_meta($post->ID,'mc_currency',true);
			$mc_gross = get_post_meta($post->ID,'mc_gross',true);
			echo $c->getSymbol($mc_currency) . money_format("%.2n", $mc_gross);
			break;
		case "country":
			echo get_post_meta($post->ID,'residence_country',true);
			break;
		case "paypal":
			echo get_post_meta($post->ID,'payer_email',true);
			break;
		case "downloads":
			echo get_post_meta($post->ID,'downloads',true);
			break;
	}
}
function ebook_readfile_chunked( $file, $retbytes = TRUE ) {

	$chunksize = 1 * (1024 * 1024);
	$buffer    = '';
	$cnt       = 0;
	$handle    = fopen( $file, 'r' );

	if( $size = @filesize( $file ) ) header("Content-Length: " . $size );

	if ( $handle === FALSE ) return FALSE;

	while ( ! feof( $handle ) ) :
	$buffer = fread( $handle, $chunksize );
	echo $buffer;
	//ob_flush();
	//flush();

	if ( $retbytes ) $cnt += strlen( $buffer );
	endwhile;

	$status = fclose( $handle );

	if ( $retbytes AND $status ) return $cnt;

	return $status;
}
function ebook_get_file_ctype( $extension ) {
	switch( $extension ):
	case 'ac'       : $ctype = "application/pkix-attr-cert"; break;
	case 'adp'      : $ctype = "audio/adpcm"; break;
	case 'ai'       : $ctype = "application/postscript"; break;
	case 'aif'      : $ctype = "audio/x-aiff"; break;
	case 'aifc'     : $ctype = "audio/x-aiff"; break;
	case 'aiff'     : $ctype = "audio/x-aiff"; break;
	case 'air'      : $ctype = "application/vnd.adobe.air-application-installer-package+zip"; break;
	case 'apk'      : $ctype = "application/vnd.android.package-archive"; break;
	case 'asc'      : $ctype = "application/pgp-signature"; break;
	case 'atom'     : $ctype = "application/atom+xml"; break;
	case 'atomcat'  : $ctype = "application/atomcat+xml"; break;
	case 'atomsvc'  : $ctype = "application/atomsvc+xml"; break;
	case 'au'       : $ctype = "audio/basic"; break;
	case 'aw'       : $ctype = "application/applixware"; break;
	case 'avi'      : $ctype = "video/x-msvideo"; break;
	case 'bcpio'    : $ctype = "application/x-bcpio"; break;
	case 'bin'      : $ctype = "application/octet-stream"; break;
	case 'bmp'      : $ctype = "image/bmp"; break;
	case 'boz'      : $ctype = "application/x-bzip2"; break;
	case 'bpk'      : $ctype = "application/octet-stream"; break;
	case 'bz'       : $ctype = "application/x-bzip"; break;
	case 'bz2'      : $ctype = "application/x-bzip2"; break;
	case 'ccxml'    : $ctype = "application/ccxml+xml"; break;
	case 'cdmia'    : $ctype = "application/cdmi-capability"; break;
	case 'cdmic'    : $ctype = "application/cdmi-container"; break;
	case 'cdmid'    : $ctype = "application/cdmi-domain"; break;
	case 'cdmio'    : $ctype = "application/cdmi-object"; break;
	case 'cdmiq'    : $ctype = "application/cdmi-queue"; break;
	case 'cdf'      : $ctype = "application/x-netcdf"; break;
	case 'cer'      : $ctype = "application/pkix-cert"; break;
	case 'cgm'      : $ctype = "image/cgm"; break;
	case 'class'    : $ctype = "application/octet-stream"; break;
	case 'cpio'     : $ctype = "application/x-cpio"; break;
	case 'cpt'      : $ctype = "application/mac-compactpro"; break;
	case 'crl'      : $ctype = "application/pkix-crl"; break;
	case 'csh'      : $ctype = "application/x-csh"; break;
	case 'css'      : $ctype = "text/css"; break;
	case 'cu'       : $ctype = "application/cu-seeme"; break;
	case 'davmount' : $ctype = "application/davmount+xml"; break;
	case 'dbk'      : $ctype = "application/docbook+xml"; break;
	case 'dcr'      : $ctype = "application/x-director"; break;
	case 'deploy'   : $ctype = "application/octet-stream"; break;
	case 'dif'      : $ctype = "video/x-dv"; break;
	case 'dir'      : $ctype = "application/x-director"; break;
	case 'dist'     : $ctype = "application/octet-stream"; break;
	case 'distz'    : $ctype = "application/octet-stream"; break;
	case 'djv'      : $ctype = "image/vnd.djvu"; break;
	case 'djvu'     : $ctype = "image/vnd.djvu"; break;
	case 'dll'      : $ctype = "application/octet-stream"; break;
	case 'dmg'      : $ctype = "application/octet-stream"; break;
	case 'dms'      : $ctype = "application/octet-stream"; break;
	case 'doc'      : $ctype = "application/msword"; break;
	case 'docx'     : $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
	case 'dotx'     : $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.template"; break;
	case 'dssc'     : $ctype = "application/dssc+der"; break;
	case 'dtd'      : $ctype = "application/xml-dtd"; break;
	case 'dump'     : $ctype = "application/octet-stream"; break;
	case 'dv'       : $ctype = "video/x-dv"; break;
	case 'dvi'      : $ctype = "application/x-dvi"; break;
	case 'dxr'      : $ctype = "application/x-director"; break;
	case 'ecma'     : $ctype = "application/ecmascript"; break;
	case 'elc'      : $ctype = "application/octet-stream"; break;
	case 'emma'     : $ctype = "application/emma+xml"; break;
	case 'eps'      : $ctype = "application/postscript"; break;
	case 'epub'     : $ctype = "application/epub+zip"; break;
	case 'etx'      : $ctype = "text/x-setext"; break;
	case 'exe'      : $ctype = "application/octet-stream"; break;
	case 'exi'      : $ctype = "application/exi"; break;
	case 'ez'       : $ctype = "application/andrew-inset"; break;
	case 'f4v'      : $ctype = "video/x-f4v"; break;
	case 'fli'      : $ctype = "video/x-fli"; break;
	case 'flv'      : $ctype = "video/x-flv"; break;
	case 'gif'      : $ctype = "image/gif"; break;
	case 'gml'      : $ctype = "application/srgs"; break;
	case 'gpx'      : $ctype = "application/gml+xml"; break;
	case 'gram'     : $ctype = "application/gpx+xml"; break;
	case 'grxml'    : $ctype = "application/srgs+xml"; break;
	case 'gtar'     : $ctype = "application/x-gtar"; break;
	case 'gxf'      : $ctype = "application/gxf"; break;
	case 'hdf'      : $ctype = "application/x-hdf"; break;
	case 'hqx'      : $ctype = "application/mac-binhex40"; break;
	case 'htm'      : $ctype = "text/html"; break;
	case 'html'     : $ctype = "text/html"; break;
	case 'ice'      : $ctype = "x-conference/x-cooltalk"; break;
	case 'ico'      : $ctype = "image/x-icon"; break;
	case 'ics'      : $ctype = "text/calendar"; break;
	case 'ief'      : $ctype = "image/ief"; break;
	case 'ifb'      : $ctype = "text/calendar"; break;
	case 'iges'     : $ctype = "model/iges"; break;
	case 'igs'      : $ctype = "model/iges"; break;
	case 'ink'      : $ctype = "application/inkml+xml"; break;
	case 'inkml'    : $ctype = "application/inkml+xml"; break;
	case 'ipfix'    : $ctype = "application/ipfix"; break;
	case 'jar'      : $ctype = "application/java-archive"; break;
	case 'jnlp'     : $ctype = "application/x-java-jnlp-file"; break;
	case 'jp2'      : $ctype = "image/jp2"; break;
	case 'jpe'      : $ctype = "image/jpeg"; break;
	case 'jpeg'     : $ctype = "image/jpeg"; break;
	case 'jpg'      : $ctype = "image/jpeg"; break;
	case 'js'       : $ctype = "application/javascript"; break;
	case 'json'     : $ctype = "application/json"; break;
	case 'jsonml'   : $ctype = "application/jsonml+json"; break;
	case 'kar'      : $ctype = "audio/midi"; break;
	case 'latex'    : $ctype = "application/x-latex"; break;
	case 'lha'      : $ctype = "application/octet-stream"; break;
	case 'lrf'      : $ctype = "application/octet-stream"; break;
	case 'lzh'      : $ctype = "application/octet-stream"; break;
	case 'lostxml'  : $ctype = "application/lost+xml"; break;
	case 'm3u'      : $ctype = "audio/x-mpegurl"; break;
	case 'm4a'      : $ctype = "audio/mp4a-latm"; break;
	case 'm4b'      : $ctype = "audio/mp4a-latm"; break;
	case 'm4p'      : $ctype = "audio/mp4a-latm"; break;
	case 'm4u'      : $ctype = "video/vnd.mpegurl"; break;
	case 'm4v'      : $ctype = "video/x-m4v"; break;
	case 'm21'      : $ctype = "application/mp21"; break;
	case 'ma'       : $ctype = "application/mathematica"; break;
	case 'mac'      : $ctype = "image/x-macpaint"; break;
	case 'mads'     : $ctype = "application/mads+xml"; break;
	case 'man'      : $ctype = "application/x-troff-man"; break;
	case 'mar'      : $ctype = "application/octet-stream"; break;
	case 'mathml'   : $ctype = "application/mathml+xml"; break;
	case 'mbox'     : $ctype = "application/mbox"; break;
	case 'me'       : $ctype = "application/x-troff-me"; break;
	case 'mesh'     : $ctype = "model/mesh"; break;
	case 'metalink' : $ctype = "application/metalink+xml"; break;
	case 'meta4'    : $ctype = "application/metalink4+xml"; break;
	case 'mets'     : $ctype = "application/mets+xml"; break;
	case 'mid'      : $ctype = "audio/midi"; break;
	case 'midi'     : $ctype = "audio/midi"; break;
	case 'mif'      : $ctype = "application/vnd.mif"; break;
	case 'mods'     : $ctype = "application/mods+xml"; break;
	case 'mov'      : $ctype = "video/quicktime"; break;
	case 'movie'    : $ctype = "video/x-sgi-movie"; break;
	case 'm1v'      : $ctype = "video/mpeg"; break;
	case 'm2v'      : $ctype = "video/mpeg"; break;
	case 'mp2'      : $ctype = "audio/mpeg"; break;
	case 'mp2a'     : $ctype = "audio/mpeg"; break;
	case 'mp21'     : $ctype = "application/mp21"; break;
	case 'mp3'      : $ctype = "audio/mpeg"; break;
	case 'mp3a'     : $ctype = "audio/mpeg"; break;
	case 'mp4'      : $ctype = "video/mp4"; break;
	case 'mp4s'     : $ctype = "application/mp4"; break;
	case 'mpe'      : $ctype = "video/mpeg"; break;
	case 'mpeg'     : $ctype = "video/mpeg"; break;
	case 'mpg'      : $ctype = "video/mpeg"; break;
	case 'mpg4'     : $ctype = "video/mpeg"; break;
	case 'mpga'     : $ctype = "audio/mpeg"; break;
	case 'mrc'      : $ctype = "application/marc"; break;
	case 'mrcx'     : $ctype = "application/marcxml+xml"; break;
	case 'ms'       : $ctype = "application/x-troff-ms"; break;
	case 'mscml'    : $ctype = "application/mediaservercontrol+xml"; break;
	case 'msh'      : $ctype = "model/mesh"; break;
	case 'mxf'      : $ctype = "application/mxf"; break;
	case 'mxu'      : $ctype = "video/vnd.mpegurl"; break;
	case 'nc'       : $ctype = "application/x-netcdf"; break;
	case 'oda'      : $ctype = "application/oda"; break;
	case 'oga'      : $ctype = "application/ogg"; break;
	case 'ogg'      : $ctype = "application/ogg"; break;
	case 'ogx'      : $ctype = "application/ogg"; break;
	case 'omdoc'    : $ctype = "application/omdoc+xml"; break;
	case 'onetoc'   : $ctype = "application/onenote"; break;
	case 'onetoc2'  : $ctype = "application/onenote"; break;
	case 'onetmp'   : $ctype = "application/onenote"; break;
	case 'onepkg'   : $ctype = "application/onenote"; break;
	case 'opf'      : $ctype = "application/oebps-package+xml"; break;
	case 'oxps'     : $ctype = "application/oxps"; break;
	case 'p7c'      : $ctype = "application/pkcs7-mime"; break;
	case 'p7m'      : $ctype = "application/pkcs7-mime"; break;
	case 'p7s'      : $ctype = "application/pkcs7-signature"; break;
	case 'p8'       : $ctype = "application/pkcs8"; break;
	case 'p10'      : $ctype = "application/pkcs10"; break;
	case 'pbm'      : $ctype = "image/x-portable-bitmap"; break;
	case 'pct'      : $ctype = "image/pict"; break;
	case 'pdb'      : $ctype = "chemical/x-pdb"; break;
	case 'pdf'      : $ctype = "application/pdf"; break;
	case 'pki'      : $ctype = "application/pkixcmp"; break;
	case 'pkipath'  : $ctype = "application/pkix-pkipath"; break;
	case 'pfr'      : $ctype = "application/font-tdpfr"; break;
	case 'pgm'      : $ctype = "image/x-portable-graymap"; break;
	case 'pgn'      : $ctype = "application/x-chess-pgn"; break;
	case 'pgp'      : $ctype = "application/pgp-encrypted"; break;
	case 'pic'      : $ctype = "image/pict"; break;
	case 'pict'     : $ctype = "image/pict"; break;
	case 'pkg'      : $ctype = "application/octet-stream"; break;
	case 'png'      : $ctype = "image/png"; break;
	case 'pnm'      : $ctype = "image/x-portable-anymap"; break;
	case 'pnt'      : $ctype = "image/x-macpaint"; break;
	case 'pntg'     : $ctype = "image/x-macpaint"; break;
	case 'pot'      : $ctype = "application/vnd.ms-powerpoint"; break;
	case 'potx'     : $ctype = "application/vnd.openxmlformats-officedocument.presentationml.template"; break;
	case 'ppm'      : $ctype = "image/x-portable-pixmap"; break;
	case 'pps'      : $ctype = "application/vnd.ms-powerpoint"; break;
	case 'ppsx'     : $ctype = "application/vnd.openxmlformats-officedocument.presentationml.slideshow"; break;
	case 'ppt'      : $ctype = "application/vnd.ms-powerpoint"; break;
	case 'pptx'     : $ctype = "application/vnd.openxmlformats-officedocument.presentationml.presentation"; break;
	case 'prf'      : $ctype = "application/pics-rules"; break;
	case 'ps'       : $ctype = "application/postscript"; break;
	case 'psd'      : $ctype = "image/photoshop"; break;
	case 'qt'       : $ctype = "video/quicktime"; break;
	case 'qti'      : $ctype = "image/x-quicktime"; break;
	case 'qtif'     : $ctype = "image/x-quicktime"; break;
	case 'ra'       : $ctype = "audio/x-pn-realaudio"; break;
	case 'ram'      : $ctype = "audio/x-pn-realaudio"; break;
	case 'ras'      : $ctype = "image/x-cmu-raster"; break;
	case 'rdf'      : $ctype = "application/rdf+xml"; break;
	case 'rgb'      : $ctype = "image/x-rgb"; break;
	case 'rm'       : $ctype = "application/vnd.rn-realmedia"; break;
	case 'rmi'      : $ctype = "audio/midi"; break;
	case 'roff'     : $ctype = "application/x-troff"; break;
	case 'rss'      : $ctype = "application/rss+xml"; break;
	case 'rtf'      : $ctype = "text/rtf"; break;
	case 'rtx'      : $ctype = "text/richtext"; break;
	case 'sgm'      : $ctype = "text/sgml"; break;
	case 'sgml'     : $ctype = "text/sgml"; break;
	case 'sh'       : $ctype = "application/x-sh"; break;
	case 'shar'     : $ctype = "application/x-shar"; break;
	case 'sig'      : $ctype = "application/pgp-signature"; break;
	case 'silo'     : $ctype = "model/mesh"; break;
	case 'sit'      : $ctype = "application/x-stuffit"; break;
	case 'skd'      : $ctype = "application/x-koan"; break;
	case 'skm'      : $ctype = "application/x-koan"; break;
	case 'skp'      : $ctype = "application/x-koan"; break;
	case 'skt'      : $ctype = "application/x-koan"; break;
	case 'sldx'     : $ctype = "application/vnd.openxmlformats-officedocument.presentationml.slide"; break;
	case 'smi'      : $ctype = "application/smil"; break;
	case 'smil'     : $ctype = "application/smil"; break;
	case 'snd'      : $ctype = "audio/basic"; break;
	case 'so'       : $ctype = "application/octet-stream"; break;
	case 'spl'      : $ctype = "application/x-futuresplash"; break;
	case 'spx'      : $ctype = "audio/ogg"; break;
	case 'src'      : $ctype = "application/x-wais-source"; break;
	case 'stk'      : $ctype = "application/hyperstudio"; break;
	case 'sv4cpio'  : $ctype = "application/x-sv4cpio"; break;
	case 'sv4crc'   : $ctype = "application/x-sv4crc"; break;
	case 'svg'      : $ctype = "image/svg+xml"; break;
	case 'swf'      : $ctype = "application/x-shockwave-flash"; break;
	case 't'        : $ctype = "application/x-troff"; break;
	case 'tar'      : $ctype = "application/x-tar"; break;
	case 'tcl'      : $ctype = "application/x-tcl"; break;
	case 'tex'      : $ctype = "application/x-tex"; break;
	case 'texi'     : $ctype = "application/x-texinfo"; break;
	case 'texinfo'  : $ctype = "application/x-texinfo"; break;
	case 'tif'      : $ctype = "image/tiff"; break;
	case 'tiff'     : $ctype = "image/tiff"; break;
	case 'torrent'  : $ctype = "application/x-bittorrent"; break;
	case 'tr'       : $ctype = "application/x-troff"; break;
	case 'tsv'      : $ctype = "text/tab-separated-values"; break;
	case 'txt'      : $ctype = "text/plain"; break;
	case 'ustar'    : $ctype = "application/x-ustar"; break;
	case 'vcd'      : $ctype = "application/x-cdlink"; break;
	case 'vrml'     : $ctype = "model/vrml"; break;
	case 'vsd'      : $ctype = "application/vnd.visio"; break;
	case 'vss'      : $ctype = "application/vnd.visio"; break;
	case 'vst'      : $ctype = "application/vnd.visio"; break;
	case 'vsw'      : $ctype = "application/vnd.visio"; break;
	case 'vxml'     : $ctype = "application/voicexml+xml"; break;
	case 'wav'      : $ctype = "audio/x-wav"; break;
	case 'wbmp'     : $ctype = "image/vnd.wap.wbmp"; break;
	case 'wbmxl'    : $ctype = "application/vnd.wap.wbxml"; break;
	case 'wm'       : $ctype = "video/x-ms-wm"; break;
	case 'wml'      : $ctype = "text/vnd.wap.wml"; break;
	case 'wmlc'     : $ctype = "application/vnd.wap.wmlc"; break;
	case 'wmls'     : $ctype = "text/vnd.wap.wmlscript"; break;
	case 'wmlsc'    : $ctype = "application/vnd.wap.wmlscriptc"; break;
	case 'wmv'      : $ctype = "video/x-ms-wmv"; break;
	case 'wmx'      : $ctype = "video/x-ms-wmx"; break;
	case 'wrl'      : $ctype = "model/vrml"; break;
	case 'xbm'      : $ctype = "image/x-xbitmap"; break;
	case 'xdssc'    : $ctype = "application/dssc+xml"; break;
	case 'xer'      : $ctype = "application/patch-ops-error+xml"; break;
	case 'xht'      : $ctype = "application/xhtml+xml"; break;
	case 'xhtml'    : $ctype = "application/xhtml+xml"; break;
	case 'xla'      : $ctype = "application/vnd.ms-excel"; break;
	case 'xlam'     : $ctype = "application/vnd.ms-excel.addin.macroEnabled.12"; break;
	case 'xlc'      : $ctype = "application/vnd.ms-excel"; break;
	case 'xlm'      : $ctype = "application/vnd.ms-excel"; break;
	case 'xls'      : $ctype = "application/vnd.ms-excel"; break;
	case 'xlsx'     : $ctype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"; break;
	case 'xlsb'     : $ctype = "application/vnd.ms-excel.sheet.binary.macroEnabled.12"; break;
	case 'xlt'      : $ctype = "application/vnd.ms-excel"; break;
	case 'xltx'     : $ctype = "application/vnd.openxmlformats-officedocument.spreadsheetml.template"; break;
	case 'xlw'      : $ctype = "application/vnd.ms-excel"; break;
	case 'xml'      : $ctype = "application/xml"; break;
	case 'xpm'      : $ctype = "image/x-xpixmap"; break;
	case 'xsl'      : $ctype = "application/xml"; break;
	case 'xslt'     : $ctype = "application/xslt+xml"; break;
	case 'xul'      : $ctype = "application/vnd.mozilla.xul+xml"; break;
	case 'xwd'      : $ctype = "image/x-xwindowdump"; break;
	case 'xyz'      : $ctype = "chemical/x-xyz"; break;
	case 'zip'      : $ctype = "application/zip"; break;
	default         : $ctype = "application/force-download";
	endswitch;

	return apply_filters( 'ebook_file_ctype', $ctype );
}
function ebook_process_download() {
	if ($_REQUEST['ebook_key'] != false && $_REQUEST['action'] == 'download') {
		if( function_exists( 'apache_setenv' ) ) @apache_setenv('no-gzip', 1);
		@ini_set( 'zlib.output_compression', 'Off' );
		nocache_headers();
		$loop = new WP_Query( array ( 'post_type' => 'ebook_order', 'meta_key' => 'ebook_key', 'meta_value' => $_REQUEST['ebook_key'] ) );
		while ( $loop->have_posts() ) : $loop->the_post();
		//return get_post_meta(get_the_ID(),'ebook_key',true);
		$order_id = get_the_ID();
		$ebook = get_post_meta(get_the_ID(),'ebook',true);
		$attachment = get_post_meta($ebook,'ebook_wp_custom_attachment');
		$requested_file = $attachment[0]['file'];
		if (get_post_meta($order_id,'encrypted_pdf',true) != '') {
			$requested_file = get_post_meta($order_id,'encrypted_pdf',true);
		}
		$ctype = ebook_get_file_ctype(pathinfo($requested_file,PATHINFO_EXTENSION));
		$downloads = get_post_meta($order_id,'downloads',true);
		if ($downloads >= get_option('downloads_limit')) {
			wp_die('Oops, you have reached the maximum amount of downloads for this order, you need to order again.');
		}
		$gmt_timestamp = get_post_time('U');
		if (strtotime("+" . get_option('link_expiration'),$gmt_timestamp) < time()) {
			wp_die('Oops, the link you are using has expired, you need to order again.');
		}
		header("Robots: none");
		header("Content-Type: " . $ctype . "");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=\"" . apply_filters( 'ebook_requested_file_name', basename( $requested_file ) ) . "\";");
		header("Content-Transfer-Encoding: binary");
		ebook_readfile_chunked($requested_file);
		ebook_count_download($order_id);
		die();
		endwhile;
	} 
}
function ebook_count_download($order_id) {
	$downloads = get_post_meta($order_id,'downloads',true);
	return update_post_meta($order_id,'downloads',$downloads + 1);
}
function ebook_get_order($key = 'ebook_key',$val) {
	$loop = new WP_Query( array ( 'post_type' => 'ebook_order', 'meta_key' => $key, 'meta_value' => $val ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	$meta = get_post_meta(get_the_ID(),null,true);
	$meta['order_id'][0] = get_the_ID();
	return $meta;
	endwhile;
}

function ebook_email_delivery($post_id) {
	global $ebook_email_delivery;
	foreach ($ebook_email_delivery['order'] as $k => $v) {
		$ebook_email_delivery['text'] = str_replace('%%' . $k . '%%', $v, $ebook_email_delivery['text']);
	}
	$ebook_email_delivery['text'] = apply_filters('the_content',$ebook_email_delivery['text']);
	add_filter( 'wp_mail_content_type', 'ebook_set_content_type' );
	wp_mail($ebook_email_delivery['to'],$ebook_email_delivery['subject'], $ebook_email_delivery['text'],null,$ebook_email_delivery['attachment'][0]['file']);
}
function ebook_set_content_type( $content_type ){
	return 'text/html';
}
function ebook_attachment($post_id) {
	return get_post_meta($post_id,'ebook_wp_custom_attachment');
}
function ebook_encrypt_pdf() {
	global $ebook_email_delivery, $ebook_qr_text, $ebook_png_path, $ebook_pngname, $attachment;
	require_once('fpdi/FPDI_Protection.php');
	require_once('fpdi/qrcode.class.php');
	$ebook_qr_text = "Txn: " . $_REQUEST['txn_id'] . ' Date: ' . $_REQUEST['payment_date'] . ' Buyer:' . $_REQUEST['payer_email'];
	$qrclass = new QRClass;
	$path = $qrclass->text($ebook_qr_text, 100, 100);
	$ebook_pngname = md5($path) . '.png';
	$ebook_png_path = plugin_dir_path( __FILE__ ) . '/cache/' . $ebook_pngname;
	$qrclass->save($path, $ebook_png_path);
	//
	$file = $attachment[0]['file'];
	$password = $_REQUEST['payer_email'];
	mkdir(plugin_dir_path( __FILE__ ) . 'cache/' . md5($path), 0755, true);
	$destfile = plugin_dir_path( __FILE__ ) . 'cache/' . md5($path) . '/' . basename($file);
	$pdf = new QRPDF();
	//TODO: Get source size
	if (get_option('pdf_orientation') == 'portrait') {
		$pdf->FPDF('P', 'in', array('8.27','11.69'));
	} else {
		$pdf->FPDF('P', 'in', array('11.69','8.27'));
	}
	
	$pagecount = $pdf->setSourceFile($file);
	for ($loop = 1; $loop <= $pagecount; $loop++) {
		$tplidx = $pdf->importPage($loop);
		$pdf->addPage();
		$pdf->useTemplate($tplidx);
	}
	if (get_option('allow_pdf_printing')) {
		$pdf->SetProtection(array('print' => 'print'), $password, "");
	} else {
		$pdf->SetProtection(array(), $password);
	}
	$pdf->Output($destfile, 'F');
	update_post_meta($ebook_email_delivery['order']['order_id'],'encrypted_pdf',$destfile);
	//make sure enc file is attached
	$ebook_email_delivery['attachment'][0]['file'] = $destfile;
	$isPdf = true;
} 