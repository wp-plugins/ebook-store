<?php class QSWPOptions {	var $paypal_currency = 'USD';	var $paypal_return_button_text = 'Click here to go to download page';	var $paypal_verify_transactions = 0;	var $link_expiration = '1 month';	var $email_delivery = 1;	var $downloads_limit = 3;		var $thankyou_page = '<h1>Thank you for your order %%first_name%% %%last_name%%!</h1>You have successfully completed the order process! Please use the link(s) below to download your copy:<strong>Use the link below the start the download:</strong><a href="%%downloadlink%%" target="_blank">%%item_name%%</a> (%%filesize%%)<h3>Details for your order:</h3>Order #: %%ebook%%Transaction: %%txn_id%%Amount: %%mc_currency%% %%mc_gross%%<strong>Your password is: %%payer_email%%</strong>Thank you!';	var $email_delivery_text = 'Thank you for your order %%first_name%% %%last_name%%!You have successfully completed the order process! Please use the link(s) below to download your copy:%%downloadlink%%Details for your order:Order #: %%order_id%%Transaction: %%txn_id%%Amount: %%mc_currency%% %%mc_gross%%Your password is: %%password%%Thank you!';}