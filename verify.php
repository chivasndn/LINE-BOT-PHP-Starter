<?php
$access_token = 'jp0yyAlRVNOR3QwJ5cPJXIeFmuT8HBSYzfNvVscrD3VYWmZ28X58ruAFi92vxPLWcZoZ20CAZBFrcwjzMLgOfesgyc2xoiXEdAY0vk0tu4+u6J8ewNyzY38kpUDkwf40cUbl7KbFs9eXUF1nuHPAIwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;