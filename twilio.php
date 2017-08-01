<?php 
	/* twilio-sms.php */
	
	define("TWILIO_SID", "AC09b12c78b52600db116f800e42458838");
	define("TWILIO_TOKEN", "991fee9bd76c9d91235fd032d015fc34");
	define("TWILIO_URL", "https://api.twilio.com/2010-04-01/Accounts/".TWILIO_SID."/Messages.json");
	define("TWILIO_FROM_NO", "+15512273759");
	
	$data = [
			'From'=>TWILIO_FROM_NO,
			'To'=>'+1'.$_REQUEST['ios_phone'],
			'Body'=>'Thanks for your interest in Caper! Download the app here: http://apple.co/29354lb'
		];
	
	$sms = send_request($data);
	
	echo !$sms['error_code'] ? "Message sent!" : "Error while trying to send a message";
	
	
	function send_request($curl_data) {
		if (is_array($curl_data))
			$curl_data = http_build_query($curl_data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ; 
		curl_setopt($ch, CURLOPT_USERPWD, TWILIO_SID . ":". TWILIO_TOKEN); 
		curl_setopt($ch, CURLOPT_URL, TWILIO_URL);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: application/x-www-form-urlencoded", "Content-Length: " . strlen($curl_data)]);
		return json_decode(curl_exec($ch), true);
	}