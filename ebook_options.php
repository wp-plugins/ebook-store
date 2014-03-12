<?php
// create custom plugin settings menu
add_action('admin_menu', 'ebook_create_menu');

function ebook_create_menu() {

	//create new top-level menu
	add_options_page('eBook Store', 'eBook Store', 'manage_options', 'ebook_options.php', 'ebook_settings_page');

}

if ( is_admin() ){ // admin actions
	add_action( 'admin_menu', 'add_mymenu' );
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
	register_setting( 'ebook-settings-group', 'allow_pdf_printing' );
	register_setting( 'ebook-settings-group', 'qr_code' );
	register_setting( 'ebook-settings-group', 'pdf_orientation' );
	register_setting( 'ebook-settings-group', 'vat_percent' );
	//register_setting( 'ebook-settings-group', 'pdf_orientation' );
	register_setting( 'ebook-settings-group', 'paypal_currency' );
	register_setting( 'ebook-settings-group', 'paypal_language' );
	register_setting( 'ebook-settings-group', 'downloads_limit' );
	//email_delivery_subject
	
}



function ebook_settings_page() {
	$op = new QSWPOptions();
$ppcurencies = array('USD' => 'US Dollar',
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
<div class="wrap">
<h2>eBook Store - Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'ebook-settings-group' ); ?>
    <?php do_settings_sections( 'ebook-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">PayPal account</th>
        <td><input type="text" name="paypal_account" value="<?php echo get_option('paypal_account'); ?>" placeholder="Your@PayPal" /></td>
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
        
        <tr valign="top" class="goPro">
        <th scope="row">Encrypt PDF Files</span></th>
        <td><input type="checkbox" name="encrypt_pdf"  value="1" <?php echo (get_option('encrypt_pdf') != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>
        
             
        <tr valign="top" class="goPro">
        <th scope="row">Allow PDF Printing</span></th>
        <td><input type="checkbox" name="allow_pdf_printing"  value="1"  <?php echo (get_option('allow_pdf_printing') != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>
        
             
        <tr valign="top" class="goPro">
        <th scope="row">QR Code
        <span class="description">(<a href="http://shopfiles.com/samples/protected_cv.pdf" target="_blank">see sample</a>, PDF only)</span></th>
        <td><input type="checkbox" name="qr_code"  value="1" <?php echo (get_option('qr_code') != 0 ? 'checked="checked"' : ''); ?> /></td>
        </tr>

        <tr valign="top" class="goPro">
        <th scope="row">PDF Orientation</span></th>
        <td><select name="pdf_orientation"><option value="portrait"<?php echo (get_option('pdf_orientation') == 'portrait' ? ' selected="selected"' : ''); ?>>Portrait</option><option value="landscape"<?php echo (get_option('pdf_orientation') == 'landscape' ? ' selected="selected"' : ''); ?>>Landscape</option></select></td>
        </tr>
        <tr valign="top" class="goPro">

        <tr valign="top" class="goPro">
        <th scope="row">Upgrade to Pro</span></th>
        <td>These features are available in the Pro version, which you can find <a href="http://www.shopfiles.com/index.php/products/wordpress-ebook-store" target="_blank" colspan="2">here</a></td>
        </tr>
        <tr valign="top" class="goPro">

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
        
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>