<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	date_default_timezone_set('Asia/Jakarta');

	echo json_encode(array('sess'	=>	$_SESSION));
?>