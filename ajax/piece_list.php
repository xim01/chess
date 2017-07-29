<?php
require_once('tmpl/ajax_header.php');	
if ($_SERVER['REQUEST_METHOD'] === "GET")
	$data = $db->getPiecesList();
$db->ajax_respond($data);
?>