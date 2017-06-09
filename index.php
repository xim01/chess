<?php
include_once('php/rules.php');
?>
<?php// include 'header.php';?>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="js/pied3.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/js.js"></script>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<link type="text/css" href="css/resets.css" rel="stylesheet">
	<link type="text/css" href="css/css.css" rel="stylesheet">	
</head>
<body>
<header>
</header>
<section id="chessBoard">
	<?php
		$startPosition = array();
		$endPosition = array();
		$startPosition['hor'] = 'e';
		$startPosition['vert'] = '4';
		$endPosition['hor'] = 'f';
		$endPosition['vert'] = '6';
		$turn = 1;
		$enemy = true;
		$rules = new Rules;
		$rules->knight($startPosition,$endPosition); 
	?>
</section>
<footer>
</footer>
</body>
</html>