<?php
require_once('tmpl/ajax_header.php');	
if ($_SERVER['REQUEST_METHOD'] === "GET")
	$data = $db->getLastGame();
$answer = (!empty($data)) ? $data : $db->error;
echo json_encode($answer);
?>