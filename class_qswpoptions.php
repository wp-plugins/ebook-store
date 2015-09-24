<?php
class QSWPOptions
{
    var $paypal_currency = 'USD';
    var $paypal_return_button_text = 'Click here to go to download page';
    var $paypal_verify_transactions = 0;
    var $link_expiration = '1 month';
    var $email_delivery = 1;
    var $downloads_limit = 5;
    var $ebook_store_require_shipping = 0;
    var $thankyou_page = '<h1>Thank you for your order %%first_name%% %%last_name%%!</h1>You have successfully completed the order process! Please use the link(s) below to download your copy:<strong>Use the link below the start the download:</strong><a href="%%downloadlink%%" target="_blank">%%item_name%%</a> (%%filesize%%)<h3>Details for your order:</h3>Order #: %%order_id%%Transaction: %%txn_id%%Amount: %%mc_currency%% %%mc_gross%%<strong>Your password is: %%payer_email%%</strong>Thank you!';
    var $email_delivery_text = 'Thank you for your order %%first_name%% %%last_name%%!You have successfully completed the order process! Please use the link(s) below to download your copy:%%downloadlink%%Details for your order:Order #: %%order_id%%Transaction: %%txn_id%%Amount: %%mc_currency%% %%mc_gross%%Your password is: %%password%%Thank you!';
    var $buyer_info_text = 'Licensed to: %%first_name%% %%last_name%% (%%residence_country%%), %%payer_email%% YourCompany - all rights reserved.';
    var $buyer_info = 1;
    var $formContent = '<form class="form-horizontal"><fieldset><!-- Form Name --> <legend>Your Details</legend><!-- Text input--><div class="form-group"><label class="col-md-4 control-label" for="name">Name</label><div class="col-md-4"><input id="name" class="form-control input-md" name="name" required="" type="text" placeholder="e.g. John Smith" /></div></div><!-- Text input--><div class="form-group"><label class="col-md-4 control-label" for="email">Email</label><div class="col-md-4"><input id="email" class="form-control input-md" name="email" required="" type="text" placeholder="your@email.com" /></div></div><!-- Button --><div class="form-group"><label class="col-md-4 control-label" for="submit">Submit form and download</label><div class="col-md-4"><button id="submit" class="btn btn-primary" name="submit">Submit</button></div></div></fieldset></form>';
    var $email_delivery_subject = 'Email Delivery - Order complete!';
    var $ebook_store_owner_password = '';
    var $mailchimp_api_key = '';
    var $ebook_store_license_key = '';
}