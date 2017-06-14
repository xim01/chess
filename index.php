<?php
include_once('php/rules.php');
include_once('php/settings.php');
/*
$startPosition = array();
$endPosition = array();
$startPosition['hor'] = 'e';
$startPosition['vert'] = '4';
$endPosition['hor'] = 'f';
$endPosition['vert'] = '8';
$turn = 1;
$enemy = true;
$rules = new Rules;
var_dump($rules->knight($startPosition,$endPosition)); */
?>
<?php// include 'header.php';?>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/js.js"></script>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<link type="text/css" href="css/resets.css" rel="stylesheet">
	<link type="text/css" href="css/css.css" rel="stylesheet">	
</head>
<body>
<header class="container">
	<nav class="row">
		<p id="game-info" class="col-xs-12">Chess</p>
		<p class="col-xs-3">Current turn: <span id="current-turn">1</span></p>
		<p class="col-xs-3">Current player: <span id="current-player">0</span></p>
		<p class="col-xs-3">Selected field: <span id="selected-field">none</span></p>
		<p class="col-xs-3">Last turn was: <span id="last-field">none</span></p>
	</nav>
</header>
<section class="container">
	<div id="chessBoardWrap" class="row">
		<button id="startButton">start</button>
	</div>
</section>
<footer class="container">
	<div id="test" class="row">
	</div>
</footer>
</body>
</html>