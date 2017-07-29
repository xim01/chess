<?php
require_once('tmpl/ajax_header.php');	
if ($_SERVER['REQUEST_METHOD'] === "POST"){
	if(isset($data->createGameInfo))
		$data = $db->createGameInfo();
	if(isset($data->getGameInfoById))
		$data = $db->getGameInfoById($data->getGameInfoById);
}
if ($_SERVER['REQUEST_METHOD'] === "GET")
	$data = $db->getLastGameInfo();
if ($_SERVER['REQUEST_METHOD'] === "PUT"){
	foreach ($data as &$value) {
		$value = (int)$value;
	}

	$data = $db->updateGameInfo($data->a1,$data->a2,$data->a3,$data->a4,$data->a5,$data->a6,$data->a7,$data->a8,
								$data->b1,$data->b2,$data->b3,$data->b4,$data->b5,$data->b6,$data->b7,$data->b8,
								$data->c1,$data->c2,$data->c3,$data->c4,$data->c5,$data->c6,$data->c7,$data->c8,
								$data->d1,$data->d2,$data->d3,$data->d4,$data->d5,$data->d6,$data->d7,$data->d8,
								$data->e1,$data->e2,$data->e3,$data->e4,$data->e5,$data->e6,$data->e7,$data->e8,
								$data->f1,$data->f2,$data->f3,$data->f4,$data->f5,$data->f6,$data->f7,$data->f8,
								$data->g1,$data->g2,$data->g3,$data->g4,$data->g5,$data->g6,$data->g7,$data->g8,
								$data->h1,$data->h2,$data->h3,$data->h4,$data->h5,$data->h6,$data->h7,$data->h8,$data->id);
}
if ($_SERVER['REQUEST_METHOD'] === "DELETE")
	$data = $db->destroyGameInfo($data->id);
$db->ajax_respond($data);
?>