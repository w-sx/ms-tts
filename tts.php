<?php
//By Shunxian Wu
//orchid.x@outlook.com

function send_request($url, $data = null, $header = null, $callback = null) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($c, CURLOPT_URL, $url);
	if ($header) curl_setopt($c, CURLOPT_HTTPHEADER, $header);
	if ($data) {
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $data);
	}
	if ($callback) curl_setopt($c, CURLOPT_WRITEFUNCTION, $callback);
	$r = curl_exec($c);
	curl_close($c);
	return $r;
}

function get_token($region,$key) {
	$url = 'https://' . $region . '.api.cognitive.microsoft.com/sts/v1.0/issueToken';
	$header = ["Ocp-Apim-Subscription-Key: " . $key];
	return send_request($url=$url,[''],$header);
}

function get_audio($region,$token,$data,$callback = null) {
	$url = "https://" . $region . ".tts.speech.microsoft.com/cognitiveservices/v1";
	$header = [
		"Content-type: application/ssml+xml",
		"X-Microsoft-OutputFormat: riff-24khz-16bit-mono-pcm",
		"Authorization: Bearer " . $token,
		//"X-Search-AppId: 07D3234E49CE426DAA29772419F436CA",
		//"X-Search-ClientID: 1ECFAE91408841A480F00935DC390960",
		"User-Agent: TTS-PHP",
		"content-length: " . strlen($data)
	];
	return send_request($url,$data,$header,$callback);
}

?>