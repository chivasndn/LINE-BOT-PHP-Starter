<?php
$access_token = 'jp0yyAlRVNOR3QwJ5cPJXIeFmuT8HBSYzfNvVscrD3VYWmZ28X58ruAFi92vxPLWcZoZ20CAZBFrcwjzMLgOfesgyc2xoiXEdAY0vk0tu4+u6J8ewNyzY38kpUDkwf40cUbl7KbFs9eXUF1nuHPAIwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			$rate = get_value();
			
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $rate
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
function get_value(){
		
		$return_txt = "";
		
		date_default_timezone_set("Asia/Bangkok");
		
		$crypto_currency_list = array("XRP","EVX");
		
		$count = count($crypto_currency_list);
		
		for($k=0;$k<$count;$k++){
			
			$max = 1;
			$i = 0;
			$pairing_id = 0;
			
			$rate = 0;
			
			$json = file_get_contents('https://bx.in.th/api/');
			$obj = json_decode($json);
			
			foreach($obj as $val){
				// print_r($val);
				
				if($val->secondary_currency==$crypto_currency_list[$k]&&$val->primary_currency=="THB"){
					$pairing_id = $val->pairing_id;
					//echo "\n------------------------------------\n";
					break;
				}
				
			}
			
			while($i<$max){
				$json = file_get_contents('https://bx.in.th/api/trade/?pairing='.$pairing_id);
				$obj = json_decode($json);
				
				if(number_format($obj->trades[0]->rate, 2)!=0){
					$rate = number_format($obj->trades[0]->rate, 2);
					$return_txt = $return_txt . $crypto_currency_list[$k]." : ".$rate."\n";
					//echo date("H:i:s")."\t".$rate."\n";
					//sleep(3);
					$i++;
				}
			}
			
		}
		
		return $return_txt;
	}		