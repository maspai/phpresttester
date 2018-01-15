<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_POST['url']);
if ($_POST['method'] == 'POST') {
	curl_setopt($ch, CURLOPT_POST, 1);
}
$post = [];
foreach ($_POST['names'] as $i => $name) {
	$post[$name] = $_POST['values'][$i];
}
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
if ($headers = array_filter($_POST['headers'], function ($h) { return $h; })) {
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$result = curl_exec($ch);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($result, 0, $header_size);
$result = substr($result, $header_size);
curl_close($ch);
if (stripos($content_type, 'application/json') !== false) {
	$result = json_encode(json_decode($result), JSON_PRETTY_PRINT);
	header('content-type: application/json');
}
echo $result;