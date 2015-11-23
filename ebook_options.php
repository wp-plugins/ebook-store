<?php
// create custom plugin settings menu

add_action('admin_menu', 'ebook_create_menu');


function ebook_create_menu() {

	//create new top-level menu
	add_options_page('eBook Store', 'eBook Store', 'manage_options', 'ebook_options.php', 'ebook_settings_page');

}

if ( is_admin() ){ // admin actions
	add_action( 'admin_init', 'register_ebook_store_settings' );
} else {
	// non-admin enqueues, actions, and filters
}

function register_ebook_store_settings() {

	//register our settings
	register_setting( 'ebook-settings-group', 'paypal_account' );
	register_setting( 'ebook-settings-group', 'paypal_return_button_text' );
	register_setting( 'ebook-settings-group', 'link_expiration' );
	register_setting( 'ebook-settings-group', 'email_delivery' );
	register_setting( 'ebook-settings-group', 'attach_files' );
	register_setting( 'ebook-settings-group', 'thankyou_page' );
	register_setting( 'ebook-settings-group', 'email_delivery_text' );
	register_setting( 'ebook-settings-group', 'email_delivery_subject' );
	register_setting( 'ebook-settings-group', 'paypal_sandbox' );
	register_setting( 'ebook-settings-group', 'paypal_verify_transactions' );
	register_setting( 'ebook-settings-group', 'encrypt_pdf' );
	register_setting( 'ebook-settings-group', 'qr_code' );
	register_setting( 'ebook-settings-group', 'pdf_orientation' );
	register_setting( 'ebook-settings-group', 'vat_percent' );
	//register_setting( 'ebook-settings-group', 'pdf_orientation' );
	register_setting( 'ebook-settings-group', 'paypal_currency' );
	register_setting( 'ebook-settings-group', 'paypal_language' );
	register_setting( 'ebook-settings-group', 'downloads_limit' );
    register_setting( 'ebook-settings-group', 'ebook_store_checkout_page' );
    register_setting( 'ebook-settings-group', 'ebook_store_cancel_page' );
    register_setting( 'ebook-settings-group', 'ebook_store_require_shipping' );
    register_setting( 'ebook-settings-group', 'buyer_info' );
    register_setting( 'ebook-settings-group', 'buyer_info_text' );
    register_setting( 'ebook-settings-group', 'formContent' );
    register_setting( 'ebook-settings-group', 'formEnabled' );
    register_setting( 'ebook-settings-group', 'ebook_store_license_key' );
    register_setting( 'ebook-settings-group', 'ebook_store_owner_password' );
    register_setting( 'ebook-settings-group', 'disable_annot-forms' );
    register_setting( 'ebook-settings-group', 'disable_pdf_copy' );
    register_setting( 'ebook-settings-group', 'disable_pdf_modify' );
    register_setting( 'ebook-settings-group', 'disable_pdf_printing' );
    register_setting( 'ebook-settings-group', 'mailchimp_api_key' );
    register_setting( 'ebook-settings-group', 'mailchimp_lists' );
    register_setting( 'ebook-settings-group', 'kindleDelivery' );
}



function ebook_settings_page() {
    wp_register_style( 'ebookstorestylesheet', plugins_url('css/ebook_store.css', __FILE__) );
    wp_enqueue_style( 'ebookstorestylesheet' ); 

    if (@$_GET['task'] == 'fixThankYouPage') {
       $post = array(
      'ID'             => null,
      'post_content'   => '[ebook_thank_you]',
      'post_name'      => 'thank-you',
      'post_title'     => 'Thank you for ordering!',
      'post_status'    => 'publish',
      'post_type'      => 'page',
      // 'post_author'    => [ <user ID> ] // The user ID number of the author. Default is the current user ID.
      // 'ping_status'    => [ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
      // 'post_parent'    => [ <post ID> ] // Sets the parent of the new post, if any. Default 0.
      // 'menu_order'     => [ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
      // 'to_ping'        => // Space or carriage return-separated list of URLs to ping. Default empty string.
      // 'pinged'         => // Space or carriage return-separated list of URLs that have been pinged. Default empty string.
      // 'post_password'  => [ <string> ] // Password for post, if any. Default empty string.
      // 'guid'           => // Skip this and let Wordpress handle it, usually.
      // 'post_content_filtered' => // Skip this and let Wordpress handle it, usually.
      // 'post_excerpt'   => [ <string> ] // For all your post excerpt needs.
      // 'post_date'      => [ Y-m-d H:i:s ] // The time post was made.
      // 'post_date_gmt'  => [ Y-m-d H:i:s ] // The time post was made, in GMT.
      // 'comment_status' => [ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
      // 'post_category'  => [ array(<category id>, ...) ] // Default empty.
      // 'tags_input'     => [ '<tag>, <tag>, ...' | array ] // Default empty.
      // 'tax_input'      => [ array( <taxonomy> => <array | string>, <taxonomy_other> => <array | string> ) ] // For custom taxonomies. Default empty.
      // 'page_template'  => [ <string> ] // Requires name of template file, eg template.php. Default empty.
    );  
        $post_id = wp_insert_post( $post, $wp_error );
        update_option('ebook_store_checkout_page',$post_id);
        echo '<script>window.location = "options-general.php?page=ebook_options.php";</script>';
    }
    if (get_option('email_delivery') == 1) {
        if (is_plugin_active('easy-wp-smtp/easy-wp-smtp.php') == false) {
            ?>
                <div class="updated">
                        <p>You have enabled email delivery, we recommend using plugin <a href="plugin-install.php?tab=search&s=easy+wp+smtp">Easy WP SMTP</a> in order to make sure your WordPress emails are properly delivered.</p>
                </div>
            <?php
        }
    }
	$op = new QSWPOptions();
$ppcurencies = array('USD' => 'US Dollar',
'EUR' => 'Euro',
'ILS' => 'Israeli New Sheqel',
'GBP' => 'Pounds Sterling',
'AUD' => 'Australian Dollar',
'CAD' => 'Canadian Dollar',
'JPY' => 'Japan Yen',
'NZD' => 'New Zealand Dollar',
'CHF' => 'Swiss Franc',
'HKD' => 'Hong Kong Dollar',
'SGD' => 'Singapore Dollar',
'SEK' => 'Sweden Krona',
'DKK' => 'Danish Krone',
'PLN' => 'New Zloty',
'NOK' => 'Norwegian Krone',
'HUF' => 'Forint',
'MXN' => 'Mexican Pesos',
'CZK' => 'Czech Koruna',
'BRL' => 'Brazilian Real',
'TWD' => 'Taiwan New Dollar',
'TRY' => 'Turkish Lira',
'THB' => 'Thai Baht');
	$lc = array(
'' => '-- Optional --',
'AU' => 'Australia',
'AT' => 'Austria',
'BE' => 'Belgium',
'BR' => 'Brazil',
'CA' => 'Canada',
'CH' => 'Switzerland',
'CN' => 'China',
'DE' => 'Germany',
'ES' => 'Spain',
'GB' => 'United Kingdom',
'FR' => 'France',
'IT' => 'Italy',
'NL' => 'Netherlands',
'PL' => 'Poland',
'PT' => 'Portugal',
'RU' => 'Russia',
'US' => 'United States',
'da_DK' => 'Danish',
'he_IL' => 'Hebrew',
'id_ID' => 'Indonesian',
'jp_JP' => 'Japanese',
'no_NO' => 'Norwegian',
'pt_BR' => 'Brazilian Portuguese',
'ru_RU' => 'Russian',
'sv_SE' => 'Swedish',
'th_TH' => 'Thai',
'tr_TR' => 'Turkish',
'zh_CN' => 'Chinese (China)',
'zh_HK' => 'Chinese (Hong Kong)',
'zh_TW' => 'Chinese (Taiwan)'
		);

wp_enqueue_script( 'ebook_store_settings', plugins_url( '/js/ebook_store_settings.js' , __FILE__ ), array(), '1.0.0', true );

	?>
<script>
<?php
echo "var ebook_store_license_key = '" . get_option('ebook_store_license_key') . "'";
?>
</script>
<div class="wrap">
<h2>eBook Store - Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'ebook-settings-group' ); ?>
    <?php do_settings_sections( 'ebook-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">PayPal account</th>
        <td><input type="text" name="paypal_account" value="<?php echo get_option('paypal_account'); ?>" placeholder="Your@PayPal" /><br /><br /><span class="description ebook_store_warning">Please enable PayPal IPN in your PayPal account. That's under Profile > My selling tools > Instant payment notifications. In the IPN url field enter your website address.</span></td>
        </tr>
        
        <tr>
        <th scope="row">Thank You page
        </th>
        <td valign="top">        
            <?php
$args = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => get_option('ebook_store_checkout_page'),
    'echo'                  => 1,
    'name'                  => 'ebook_store_checkout_page',
    'id'                    => null, // string
    'show_option_none'      => '-- Please select --', // string
    'show_option_no_change' => null, // string
    'option_none_value'     => '0', // string
    'post_type' => 'page'
);
wp_dropdown_pages($args);

            ?>
            <span class="description">
        This page should contain the shortcode <b>[ebook_thank_you]</b>, where you want the "Thank you" page content to appear.
        </span>
        </td>
        </tr>

        <tr>
        <th scope="row">Order Cancelled Page
        </th>
        <td valign="top">        
            <?php
$args = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => get_option('ebook_store_cancel_page'),
    'echo'                  => 1,
    'name'                  => 'ebook_store_cancel_page',
    'id'                    => null, // string
    'show_option_none'      => '-- Please select --', // string
    'show_option_no_change' => null, // string
    'option_none_value'     => '0', // string
    'post_type' => 'page'
);
wp_dropdown_pages($args);

            ?>
            <span class="description">
        This page will be shown if the customer decides to cancel the order at PayPal.
        </span>
        </td>
        </tr>


        <tr valign="top">
        <th scope="row">PayPal currency</th>
        <td>
        <select name="paypal_currency">
        <?php 
        //echo get_option('paypal_account');
        foreach ($ppcurencies as $currency => $name) {
			$selected = '';
			if ($currency == get_option('paypal_currency',$op->paypal_currency)) {
				$selected = ' selected';
			}
			echo "<option value=\"$currency\"$selected>$name</option>";
		}
        ?>
		</select> 
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PayPal language</th>
        <td>
        <select name="paypal_language">
        <?php 
        //echo get_option('paypal_account');
        foreach ($lc as $lang => $name) {
			$selected = '';
			if ($lang == get_option('paypal_language')) {
				$selected = ' selected';
			}
			echo "<option value=\"$lang\"$selected>$name</option>";
		}
        ?>
		</select> 
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PayPal Return to site button text</th>
        <td><input type="text" name="paypal_return_button_text" value="<?php echo get_option('paypal_return_button_text',$op->paypal_return_button_text); ?>" placeholder="Click here to go to download page" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PayPal sandbox <span class="description">(test mode)</span></span></th>
        <td><input type="checkbox" name="paypal_sandbox" value="1" <?php echo (get_option('paypal_sandbox') != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PayPal Transaction Verification <span class="description">(turn off if experiencing problems)</span></span></th>
        <td><input type="checkbox" name="paypal_verify_transactions" value="1" <?php echo (get_option('paypal_verify_transactions',$op->paypal_verify_transactions) != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>
        
        <tr valign="top" class="">
        <th scope="row">Ask buyer for address at PayPal</span></th>
        <td><select name="ebook_store_require_shipping"><option value="0"<?php echo (get_option('ebook_store_require_shipping') == '0' ? ' selected="selected"' : ''); ?>>Optional</option><option value="1"<?php echo (get_option('ebook_store_require_shipping') == '1' ? ' selected="selected"' : ''); ?>>Do not require address</option><option value="2"<?php echo (get_option('ebook_store_require_shipping') == '2' ? ' selected="selected"' : ''); ?>>Require Address</option></select></td>
        </tr>

        <tr valign="top">
        <th scope="row">License key</th>
        <td><input type="text" name="ebook_store_license_key" style="width:250px;" value="<?php echo get_option('ebook_store_license_key',$op->ebook_store_license_key); ?>" placeholder="(Pro only) your@paypal.email" /><span class="description">If you purchased the full version of the plugin, just fill in your PayPal email used when ordering and you will be able to unlock the pro features and keep them active after updating.</span></td>
        </tr>

        
        <tr valign="top" class="goPro">
        <th colspan="2" scope="row"> </th>
        </tr>

        <tr valign="top" class="goPro">
        <th colspan="2" scope="row"><h2>PDF Protection features (require Encryption to be turned on)</h2></th>
        </tr>

        <tr valign="top" class="goPro">
        <th scope="row">Encrypt PDF Files</span></th>
        <td><input type="checkbox" name="encrypt_pdf"  value="1" <?php echo (get_option('encrypt_pdf') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">This will option will enable encrypted delivery, both via email as attachment (if enabled) and via site download. The password of the encrypted PDF file is always the buyer's PayPal email address.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">PDF Master (Owner) password</th>
        <td><input name="ebook_store_owner_password" type="text" size="130" value="<?php 
        echo get_option('ebook_store_owner_password',$op->ebook_store_owner_password);
        ?>" placeholder="If left empty unique password will be generated for each file upon order confirmation." /></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">PDF User Password</th>
        <td>User password is always the PayPal email address of the buyer used when buying the PDF ebook.</td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">Disable PDF Printing</span></th>
        <td><input type="checkbox" name="disable_pdf_printing"  value="1"  <?php echo (get_option('disable_pdf_printing') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">This feature will disable printing for the PDF files you're selling.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">Disable Copy/Paste from PDF</span></th>
        <td><input type="checkbox" name="disable_pdf_copy"  value="1"  <?php echo (get_option('disable_pdf_copy') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">This feature will disable copying from the PDF files you're selling.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">Disable PDF Modification</span></th>
        <td><input type="checkbox" name="disable_pdf_modify"  value="1"  <?php echo (get_option('disable_pdf_modify') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">This feature will disable modifications for the PDF files you're selling.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">Disable Annotation forms</span></th>
        <td><input type="checkbox" name="disable_annot-forms"  value="1"  <?php echo (get_option('disable_annot-forms') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">This feature will disable printing for the PDF files you're selling.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">QR Code
        <span class="description">(<a href="http://shopfiles.com/samples/protected_cv.pdf" target="_blank">see sample</a>, PDF only)</span></th>
        <td><input type="checkbox" name="qr_code"  value="1" <?php echo (get_option('qr_code') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">Once enabled, every page will have a QR code watermark on bottom right corner. Once scanned with any Android / iOS device it gives information for the buyer in case the file is pirated online / offline.</span></td>
        </tr>

        <tr valign="top" class="goPro">
        <th scope="row">Buyer Info in PDF header
        </th>
        <td><input type="checkbox" name="buyer_info"  value="1" <?php echo (get_option('buyer_info') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">This feature will print/watermark the buyer's information in the header of each page.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">Buyer info text</th>
        <td><input name="buyer_info_text" type="text" size="130" value="<?php 
        echo get_option('buyer_info_text',$op->buyer_info_text);
        ?>" /></td>
        </tr>
        <!-- <tr valign="top" class="goPro">
        <th scope="row">PDF Orientation</span></th>
        <td><select name="pdf_orientation"><option value="portrait"<?php echo (get_option('pdf_orientation') == 'portrait' ? ' selected="selected"' : ''); ?>>Portrait</option><option value="landscape"<?php echo (get_option('pdf_orientation') == 'landscape' ? ' selected="selected"' : ''); ?>>Landscape</option></select></td>
        </tr> -->

        <tr valign="top" class="goPro">
        <th colspan="2" scope="row"> </th>
        </tr>

        <tr valign="top" class="goPro">
        <th scope="row">Fill a form upon order
        </th>
        <td><input type="checkbox" name="formEnabled"  value="1" <?php echo (get_option('formEnabled') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">If this feature is enabled the user will be asked to fill in a form with more details, the form you can edit as you wish with your own html editor and paste the code on this page's section with the form content.</span></td>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">Require @kindle.com email for delivery
        </th>
        <td><input type="checkbox" name="kindleDelivery"  value="1" <?php echo (get_option('kindleDelivery') != 0 ? 'checked="checked"' : ''); ?> /><span class="description">You can use that with combination of "Fill a form feature" to get the kindle email of the user (use field name "kindle_email").</span></td>
        </tr>

        <tr valign="top" class="goPro">
        <th colspan="2" scope="row"> </th>
        </tr>

        <tr valign="top" class="goPro">
        <th colspan="2" scope="row"><h2>MailChimp Integration (Subscribe ebook buyers to mailing/newsletter list)</h2></th>
        </tr>
        <tr valign="top" class="goPro">
        <th scope="row">MailChimp API Key</th>
        <td><input type="text" name="mailchimp_api_key" style="width:500px;" value="<?php echo get_option('mailchimp_api_key',$op->mailchimp_api_key); ?>" placeholder="Get it from https://admin.mailchimp.com/account/api-key-popup/" /></td>
        </tr>

        

        <tr valign="top" class="goPro">
        <th scope="row">Subscribe buyers to MailChimp list</th>
        <td>
            <select name="mailchimp_lists">
        <?php 
        $mailchimp_lists = ebook_store_get_mailchimp_lists();
        //print_r($mailchimp_lists);
		if (is_array($mailchimp_lists)) {
			foreach ($mailchimp_lists as $list) {
				$selected = '';
				if ($list->id == get_option('mailchimp_lists')) {
					$selected = ' selected';
				}
				echo "<option value=\"" . $list->id . "\"$selected>" . $list->name . "</option>";
			}
		}

        ?>
            </select> 
        </td>
        </tr>
        
        
        <tr valign="top" class="goPro">

        <tr valign="top" class="goPro">
        <th scope="row">Upgrade to Pro</span></th>
        <td>These features are available in the Pro version, which you can find <a href="http://www.shopfiles.com/index.php/products/wordpress-ebook-store" target="_blank" colspan="2">here</a></td>
        </tr>

        <tr valign="top" class="goPro">
        <th colspan="2" scope="row"> </th>
        </tr>
        




        <tr valign="top">
        <th scope="row">Link Expiration</th>
        <td><input type="text" name="link_expiration" value="<?php echo get_option('link_expiration',$op->link_expiration); ?>" placeholder="1 month" /></td>
        </tr>

                
        <tr valign="top">
        <th scope="row">Downloads limit <span class="description">(after how many succesful downloads link becomes inactive)</span></span></th>
        <td><input type="text" name="downloads_limit" value="<?php echo get_option('downloads_limit',$op->downloads_limit); ?>" placeholder="3" /></td>
        </tr>
                
        <tr valign="top">
        <th scope="row">Email Delivery</th>
        <td><input type="checkbox" name="email_delivery"  value="1" <?php echo (get_option('email_delivery') != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Attach Files</th>
        <td><input type="checkbox" name="attach_files"  value="1" <?php echo (get_option('attach_files') != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>
        
        
        <tr valign="top">
        <th scope="row">VAT Percent</th>
        <td><input type="text" name="vat_percent" value="<?php echo get_option('vat_percent'); ?>" placeholder="20" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Thank you page</th>
        <td><?php 
        $editor_id = 'thankyou_page';
        wp_editor( get_option('thankyou_page',$op->thankyou_page), $editor_id );
        ?></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email delivery content</th>
        <td>Subject:<br /><input type="text" name="email_delivery_subject" value="<?php echo get_option('email_delivery_subject',$op->email_delivery_subject); ?>" /><?php 
        $editor_id = 'email_delivery_text';
        wp_editor( get_option('email_delivery_text',$op->email_delivery_text), $editor_id );
        ?></td>
        </tr>
        <tr valign="top">
        <th scope="row">Form Content</th>
        <td>
        <?php
        $editor_id = 'formContent';
        wp_editor( get_option('formContent',$op->formContent), $editor_id );
        ?></td>
        </tr>
        
        
        
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?pJJOUNrd3F2XicGCyKN5BGmHdzK4VVuA';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->

<?php } ?>