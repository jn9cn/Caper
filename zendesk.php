<?php 
	/* twilio-sms.php */
	
	define("ZENDESK_API_KEY", "xxDaoN534uS37VPoXUaoyQK4Cve6fCZevGCQFjrt");
	define("ZENDESK_USER", "jannine@caper.ly/token");
	
	define("ZENDESK_API_URL", "https://caper.zendesk.com/api/v2");
	define("ZENDESK_REQUEST_URL", ZENDESK_API_URL . "/requests.json");
	define("ZENDESK_UPLOAD_URL", ZENDESK_API_URL . "/uploads.json");
	define("ZENDESK_USER_URL", ZENDESK_API_URL . "/users/create_or_update.json");
	define("LOCAL_UPLOAD_URL", "https://{$_SERVER['SERVER_NAME']}/uploads");
	define("LOCAL_UPLOAD_PATH", "uploads");
	
	$data = [
			'request'=>[
				'subject'=>$_REQUEST['contact_subject'],
				'comment'=>['body'=>$_REQUEST['contact_message']]
			]
		];
	
	echo create_ticket($data);




	/* HELPER FUNCTIONS  */
	
	
	/* UPLOAD FILE AS ATTACHMENT TO A TICKET */
	
	function file_upload() {
		if ($_FILES['contact_file']['size']<=0)
			return false;
		
		$file = $_FILES['contact_file']['tmp_name'];
		$name = $_FILES['contact_file']['name'];
		
		$filedata = file_get_contents($file);
		
		$url = ZENDESK_UPLOAD_URL . "?filename=" . md5(microtime(false)) ."-". $name;
		
		$result = curl_request($url, $filedata, true, $_REQUEST['contact_email']."/token");
		
		return json_decode($result, true);
		
	}
	
	/* CREATE OR UPDATE A USER */
	
	function create_user($email, $name="") {
		if ($name=="") {
			$name = explode('@', $email);
			$name = $name[0];
		}
			
		$result = curl_request(ZENDESK_USER_URL, ['user'=>['name'=>$name, 'email'=>$email, 'verified'=>true]]);

		//echo $result."\r\n";
		
		return $result;
	}
	
	/* CREATE TICKET */
	
	function create_ticket($curl_data) {
		
		create_user($_REQUEST['contact_email'], $_REQUEST['contact_name']);
		
		$upload = file_upload();
		if ($upload)
			$curl_data['request']['comment']['uploads'][] = $upload['upload']['token'];
		
		return curl_request(ZENDESK_REQUEST_URL, $curl_data, false, $_REQUEST['contact_email']."/token");
		
	}
	
	
	/* cURL HTTP REQUEST */
	
	function curl_request($url, $data, $upload=false, $user = ZENDESK_USER) {
		
		$ch = curl_init();
		
		if (!$upload)
			$data = json_encode($data); 
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ); 
		curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . ZENDESK_API_KEY); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: ".($upload ? "application/binary" : "application/json")]);
		
		$response = curl_exec($ch);
		return !curl_error($ch) ? $response : curl_error($ch);
	}