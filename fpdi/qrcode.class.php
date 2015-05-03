<?php

class QRPDF extends FPDI_Protection {

	function Footer() {

		global $ebook_png_path, $pdfHeaderText;

		if (get_option('qr_code')) {

			$this->Image($ebook_png_path,$this->w - 0.77,$this->h - 0.77,0.77,0.77);

		}
	if (get_option('buyer_info')) {
			$this->SetFont('Arial');
			$this->SetTextColor(255, 0, 0);
			$this->SetXY(0.2, 0.2);
			$this->SetFontSize(10);
			$this->Write(0, $pdfHeaderText);
		}
	}

}

class QRClass{

	

		/* Plain text */

		

		public function text($text, $size_h = 350, $size_w = 350) {

			

			return 'http://chart.apis.google.com/chart?cht=qr&chs='.$size_w.'x'.$size_h.'&chl='.urlencode($text);

			

		}

		

		/* E-mail addresses */

		

		function email($email, $size_h = 350, $size_w = 350) {

			

			return 'http://chart.apis.google.com/chart?cht=qr&chs='.$size_w.'x'.$size_h.'&chl=mailto%3A'.urlencode($email);

			

		}

		

		/* Phone numbers */

		

		function phone_numbers($number, $size_h = 350, $size_w = 350) {

			

			return 'http://chart.apis.google.com/chart?cht=qr&chs='.$size_w.'x'.$size_h.'&chl=tel%3A'.urlencode($number);

			

		}

		

		/* URL */

		

		function url($url, $size_h = 350, $size_w = 350) {

			

			return 'http://chart.apis.google.com/chart?cht=qr&chs='.$size_w.'x'.$size_h.'&chl='.urlencode($url);

			

		}

		

		/* SMS */

		

		function sms($receiver, $message, $size_h = 350, $size_w = 350) {

			

			return 'http://chart.apis.google.com/chart?cht=qr&chs='.$size_w.'x'.$size_h.'&chl=smsto%3A'.urlencode($receiver).'%3A'.urlencode($message);

			

		}

		

		/* Wifi network */

		

		function wifi($ssid, $password, $type, $size_h = 350, $size_w = 350) {

			

			return 'http://chart.apis.google.com/chart?cht=qr&chs='.$size_w.'x'.$size_h.'&chl=WIFI%3AS%3A'.$ssid.'%3BT%3A'.$type.'%3BP%3A'.$password.'%3B%3B';

			

		}

		

		/* Save image */

		

		function save($image, $destination) {

		

			if(file_exists($destination)) {

			

				return FALSE;

		

			} else {

			

				$img = imagecreatefrompng($image);

				imagepng($img, $destination);

				//file_put_contents($destination,file_get_contents($image));

				return TRUE;

			

			}

		

		}

		

	

	}

	

?>