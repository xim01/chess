<?php
include_once('php/rules.php');
include_once('php/settings.php');
include_once('php/mysql.php');
$gameDB = new GameDB;
if($gameDB->selectLastGame())
	$button = "Continue game";
else
	$button = "Start game";
include 'header.php';?>
<header class="container">
	<nav class="row">
		<p class="col-xs-3">Current turn: <span id="current-turn">none</span></p>
		<p class="col-xs-3">Current player: <span id="current-player">none</span></p>
		<p class="col-xs-3">Selected field: <span id="selected-field">none</span></p>
	</nav>
</header>
<section class="container">
	<div id="chessBoardWrap" class="row">
		<p class="col-xs-12 "><button id="startButton"><?=$button?></button></p>
	</div>
</section>
<?phpinclude 'footer.php';?>