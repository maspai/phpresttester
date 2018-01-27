<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_POST['url']);
if ($_POST['method'] == 'POST') {
	curl_setopt($ch, CURLOPT_POST, 1);
}

if (isset($_POST['raw'])) {
	curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST['raw']);
}
else {
	$post = [];
	foreach ($_POST['names'] as $i => $name) {
		$post[$name] = $_POST['values'][$i];
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
}

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
if (stripos($result, "<html") !== false) {
	echo $result . nl2br($header);
}
else {
	if (stripos($content_type, 'application/json') !== false) {
		$result = json_encode(json_decode($result), JSON_PRETTY_PRINT);
	}
	$header = str_ireplace(
		['200 OK', '500 Internal Server Error'],
		['<span style="color: green">200 OK</span>', '<span style="color: red">500 Internal Server Error</span>'],
		$header
	);
	?>
	<h4 style="padding: 2px; margin: 0;">
		Headers
		<button type="button" id="toggle-header">Show/hide</button>
	</h4>
	<pre id="headers" style="padding: 2px; margin: 0; margin-left: 5px; display: none;"><?=$header?></pre>
	<h4 style="padding: 2px; margin: 0;">Body</h4>
	<pre style="padding: 2px; margin: 0; margin-left: 5px;"><?=$result?></pre>
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript">
		$('#toggle-header').click(function () {
			$('#headers').toggle();
		});
	</script>
	<?php
}