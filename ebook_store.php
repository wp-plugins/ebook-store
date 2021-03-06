<?php
/*
Plugin Name: eBook store
Plugin URI: https://www.shopfiles.com/index.php/products/wordpress-ebook-store
Description: &#10003; eBook Store is a unique and powerful tool for selling ebooks with WordPress, allowing you to display beautiful buy now forms for your ebook(s) and giving you the ability to offer encrypted, watermarked and QR code stamped ebooks to your buyers, a proven way to prevent piracy. With the built-in MailChimp integration you can directly subscribe your clients to a mailing list.
Author: Deian Motov
Author URI:https://www.shopfiles.com/index.php/products/wordpress-ebook-store
Version: 5.12
License: GPLv2
*/

if (defined('WP_DEBUG')) {
	if (WP_DEBUG == true) {
		error_reporting(E_ALL);
	} else {
		error_reporting(0);
	}
} else {
		error_reporting(0);
}

include_once('functions.php');
include_once('class_qswpoptions.php');
include_once('ebook_options.php');

add_action('init', 'ebook_store_formContent');
add_action('init', 'check_ipn');


function check_ipn() {
	if (@$_REQUEST['task'] == 'ipn') {
		$ebook_key = preg_replace("/[^a-zA-Z0-9]+/", "", $_REQUEST['ebook_key']);
		//if order with such ebook key / order key exists, drop order.
		if (ebook_get_order('ebook_key', $ebook_key)) {
			return false;
		}

		global $ebook_email_delivery;
		include_once 'payment_gateways/paypal/ipnlistener.php';
		$listener = new IpnListener();
		if (get_option('paypal_sandbox') > 0) {
			$listener->use_sandbox = true;
		}
		try {
			$listener->requirePostMethod();
			$verified = $listener->processIpn();
		} catch (Exception $e) {
			die($e->getMessage());
			exit(0);
		}

		if ($verified) {
			ebook_store_get_mailchimp_subscribe($_REQUEST['payer_email']);
			$my_post = array(
			  'post_title'    => $_REQUEST['first_name'] . ' ' . $_REQUEST['last_name'],
			  'post_type'	  => 'ebook_order',
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_category' => array(8,39));
			$custom = explode("|",$_REQUEST['custom']);
			$mc_gross = number_format($_REQUEST['mc_gross'], 2, '.', ',');
			$vat = get_option('vat_percent'); 
			if ($vat > 0) {
				$mc_gross = $_REQUEST['mc_gross'] - $_REQUEST['tax'];
			}
			$mc_gross = number_format($mc_gross, 2, '.', ',');
			$ebook = get_post_meta($custom[0], 'ebook', true);
			$md5 = md5(NONCE_KEY . $custom[0] . $mc_gross);
			//error_log("$md5 $custom[1] " . NONCE_KEY . $custom[0] . $mc_gross);
			if ($md5 == $custom[1] || $ebook['donate_or_download'] == 'donate') {
				
				$post_id = @wp_insert_post( $my_post, $wp_error );
				foreach ($_REQUEST as $k => $v) {
					update_post_meta($post_id, $k, $v);
					@$order[$k] = $v;
				}
				
				$order['order_id'] = $post_id;
				$order['password'] = $_REQUEST['payer_email'];
				global $formData;
				$formData = ebook_store_get_form($_REQUEST['md5_nonce']);
				$formData = json_encode($formData);
				$ebook_order['ebook_key'][0] = $ebook_key;
				$ebook_order['ebook'][0] = $custom[0];
				$order['downloadlink'] = ebook_download_link($ebook_order);
				update_post_meta($post_id,'ebook_key',$ebook_key);
				update_post_meta($post_id,'downloads',0);
				update_post_meta($post_id,'mc_gross',$mc_gross);
				update_post_meta($post_id,'formData',wp_slash($formData));
				update_post_meta($post_id,'downloadlink',$order['downloadlink']);
				update_post_meta($post_id,'ebook',$custom[0]);
				
				global $attachment;
				$attachment = ebook_attachment($custom[0],true); //important!!!
				$ebook_email_delivery = array('to' => $_REQUEST['payer_email'], 'subject' => get_option('email_delivery_subject'), 'text' => get_option('email_delivery_text'),'attachment' => $attachment, 'order' => $order);
				//mail(get_option( 'admin_email' ), 'eBook store for WordPress - Verified Order Received', print_r($ebook_email_delivery,true));
				//wp_mail($_REQUEST['payer_email'],get_option('email_delivery_subject'),'Email delivery text');
				$fileExt = pathinfo($attachment[0]['file'],PATHINFO_EXTENSION);
				if ($fileExt == 'pdf' && get_option('encrypt_pdf')) { //$fileExt == 'pdf' && get_option('encrypt_pdf')
					add_action( 'init', 'ebook_encrypt_pdf', 99 );
					// error_log('ecnrypt pdf added to init');
				}
				
				add_action( 'init', 'ebook_email_delivery', 100);
				//error_log('ebook_email_delivery added to plugins_loaded');
				//array('to' => $_REQUEST['payer_email'], 'subject' => get_option('email_delivery_subject'), 'text' => 'teeext', 'file' => $attachment[0]['file'])
			} else {
				mail(get_option( 'admin_email' ), 'eBook store for WordPress - Possible fraud attempt ', $listener->getTextReport());
			}
		header("HTTP/1.1 200 OK");
		//die('OK');
		} else {
			mail(get_option( 'admin_email' ), 'eBook store for WordPress - Possible fraud attempt', $listener->getTextReport() . "\n\n\n" . md5(NONCE_KEY . $custom[0] . $mc_gross) == $custom[1]);
		}
		
	}
}
add_action( 'init', 'ebook_create_post_type' );
add_action( 'init', 'ebook_process_download', 100 );

add_action("manage_posts_custom_column", "order_custom_columns");
add_action('add_meta_boxes', 'ebook_add_custom_meta_boxes');  
add_action('post_edit_form_tag', 'ebook_update_edit_form'); 
add_action('save_post', 'save_custom_meta_data'); 
add_action('save_post', 'save_custom_meta_data_order');
//add_action('init','ebook_store_post_type_view');
add_filter( 'the_content', 'ebook_store_post_type_view' );
add_filter( 'enter_title_here', 'custom_enter_title_author' );
add_filter( 'enter_title_here', 'custom_enter_title_publisher' );
add_filter("manage_edit-ebook_order_columns", "order_columns");
add_shortcode( 'ebook_store', 'ebook_store' );

add_shortcode( 'ebook_thank_you', 'ebook_store' );
register_activation_hook( __FILE__, 'ebook_activate' );
register_deactivation_hook( __FILE__, 'ebook_deactivate' );
if (defined('PHP_VERSlON') == false) define('PHP_VERSlON',1);

add_action('init','ebookstorestylesheet');

if (get_option('ebook_store_checkout_page') == 0) {
	add_action( 'admin_notices', 'ebook_store_admin_notice' );	
}
if (get_option('paypal_account') == '') {
	add_action( 'admin_notices', 'ebook_store_admin_notice_paypal' );	
}

add_filter('post_updated_messages', 'ebook_store_set_messages' );
//add_filter( 'get_sample_permalink_html', 'ebook_store_remove_parmelink' );
//add_filter( 'pre_get_shortlink', 'ebook_store_pre_get_shortlink', 10, 2 );

add_action( 'admin_head-post-new.php', 'ebook_admin_css' );
add_action( 'admin_head-post.php', 'ebook_admin_css' );
add_filter( 'manage_edit-ebook_columns', 'ebook_store_set_columns' ) ;
add_action( 'manage_ebook_posts_custom_column', 'ebook_store_columns_output', 10, 2 );
add_filter('upload_mimes', 'ebook_mime_types', 1, 1);
add_action('admin_menu', 'ebook_store_register_my_custom_submenu_page');


?>
