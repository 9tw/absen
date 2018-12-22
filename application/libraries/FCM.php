<?php
	 

	class FCM
	{
		
		
		public function sendMessage($data,$target){
		//FCM api URL
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AAAA-XEL0KY:APA91bGBiwcSRz7EdTAgtCOhXzAU--joR5b1SFjiTc8NWlbhZsZV9F_qSh7Oimh24FutAztnUHIDt4U67SvmUkd60PLEmPcd2UUI8Suv52sDBB2c0XxbXS9Kdtq0C6YCwOzuV-2q0eV7';
					
		$fields = array();
		$fields['notification'] = $data;
		if(is_array($target)){
			$fields['registration_ids'] = $target;
		}else{
			$fields['to'] = $target;
		}
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
		  'Authorization:key=AAAA-XEL0KY:APA91bGBiwcSRz7EdTAgtCOhXzAU--joR5b1SFjiTc8NWlbhZsZV9F_qSh7Oimh24FutAztnUHIDt4U67SvmUkd60PLEmPcd2UUI8Suv52sDBB2c0XxbXS9Kdtq0C6YCwOzuV-2q0eV7'
		
		);
					
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('FCM Send Erro	r: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
		}
	}