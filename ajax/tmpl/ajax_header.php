<?php
	header('Content-Type: application/json;charset=utf-8');
	require_once('../lib/db.php');
	$db = new GameDB;
	$data = json_decode(file_get_contents('php://input'));
?>