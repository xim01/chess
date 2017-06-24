<?php
include_once('mysql.php');
$gameLogId = (int)$_POST['gameLogId'];
$gameDB = new GameDB;
$gameDB->endTheGame($gameLogId);
?>
<div id="endTheGameWrap">
	<p>Game was Ended</p>
	<p>Do u want to start new game?</p>
	<p class="col-xs-12 ">
		<a href="index.php" id="returnButton" >Yes</a>/<a href="index.php" id="returnButton" >No</a>
	</p>
</div>