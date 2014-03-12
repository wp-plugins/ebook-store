<?php
/*
Plugin Name: eBook store
Plugin URI: http://shopfiles.com/
Description: A powerful tool for selling ebooks with wordpress
Author: Deian Motov
Author URI:http://motov.net/
Version: 1.0
License: GPLv2
*/
include_once('functions.php');
include_once('class_qswpoptions.php');
include_once('ebook_options.php');

if ($_REQUEST['task'] == 'ipn') {
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
		error_log($e->getMessage());
		exit(0);
	}
	if ($verified) {
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
		if (md5(NONCE_KEY . $custom[0] . $mc_gross) == $custom[1]) {
			$post_id = wp_insert_post( $my_post, $wp_error );
			foreach ($_REQUEST as $k => $v) {
				update_post_meta($post_id, $k, $v);
				@$order[$k] = $v;
			}
			$ebook_key = preg_replace("/[^a-zA-Z0-9]+/", "", $_REQUEST['ebook_key']);
			$order['order_id'] = $post_id;
			$order['password'] = $_REQUEST['payer_email'];
			$ebook_order['ebook_key'][0] = $ebook_key;
			$ebook_order['ebook'][0] = $custom[0];
			$order['downloadlink'] = ebook_download_link($ebook_order);
			update_post_meta($post_id,'ebook_key',$ebook_key);
			update_post_meta($post_id,'downloads',0);
			update_post_meta($post_id,'ebook',$custom[0]);
			$attachment = ebook_attachment($custom[0]);
			global $attachment;
			mail(get_option( 'admin_email' ), 'eBook store for WordPress - Verified Order Received', $listener->getTextReport() . print_r($attachment,true));
			//wp_mail($_REQUEST['payer_email'],get_option('email_delivery_subject'),'Email delivery text');
			$ebook_email_delivery = array('to' => $_REQUEST['payer_email'], 'subject' => get_option('email_delivery_subject'), 'text' => get_option('email_delivery_text'),'attachment' => $attachment, 'order' => $order);
			if (pathinfo($attachment[0]['file'],PATHINFO_EXTENSION) == 'pdf' && get_option('encrypt_pdf')) {
				add_action( 'plugins_loaded', 'ebook_encrypt_pdf', 99 );
			}
			
			add_action( 'plugins_loaded', 'ebook_email_delivery', 100 );
			//array('to' => $_REQUEST['payer_email'], 'subject' => get_option('email_delivery_subject'), 'text' => 'teeext', 'file' => $attachment[0]['file'])
		} else {
			mail(get_option( 'admin_email' ), 'eBook store for WordPress - Possible fraud attempt ', $listener->getTextReport());
		}

	} else {
		mail(get_option( 'admin_email' ), 'eBook store for WordPress - Possible fraud attempt', $listener->getTextReport());
	}
	
}
add_action( 'init', 'ebook_create_post_type' );
add_action( 'init', 'ebook_process_download', 100 );
add_action("manage_posts_custom_column", "order_custom_columns");
add_action('add_meta_boxes', 'ebook_add_custom_meta_boxes');  
add_action('post_edit_form_tag', 'ebook_update_edit_form'); 
add_action('save_post', 'save_custom_meta_data'); 
add_action('save_post', 'save_custom_meta_data_order');
add_filter( 'enter_title_here', 'custom_enter_title_author' );
add_filter( 'enter_title_here', 'custom_enter_title_publisher' );
add_filter("manage_edit-ebook_order_columns", "order_columns");
add_shortcode( 'ebook_store', 'ebook_store' );
register_activation_hook( __FILE__, 'ebook_activate' );
register_deactivation_hook( __FILE__, 'ebook_deactivate' );
if (defined('PHP_VERSlON') == false) define('PHP_VERSlON',1);
wp_enqueue_style( 'ebookstorestylesheet' );
wp_register_style( 'ebookstorestylesheet', plugins_url('css/ebook_store.css', __FILE__) );

?>