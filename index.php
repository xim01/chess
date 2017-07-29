<?php require_once('tmpl/header.php');?>
<header class="container">
	<nav class="row" id="chessScoreBoards">
	<ul id="headerMenu">
		<li><a class="route" href="#game-log">show game info</a></li>
		<li><a class="route" href="#">hide game info</a></li>
	</ul>
	</nav>
</header>
<main class="container">
	<div id="chessStat">
		<script id="chessStatTemplate" type="text/template">
			<p>turn:<%=turn%></p>
			<p>player:<%=player%></p>
		</script>
	</div>
	<div id="startBtnWrap"></div>
	<div id="chessBoardWrap" class="row">
		<!--Data-->
		<script id="boardData" type="text/template">
			<div  id='chessBoard'>
				<div id="row-8" class="board-row">
					<div id="row-a8" data-info="<%= a8 %>" data-field="a8" class="field"></div>
					<div id="row-b8" data-info="<%= b8 %>" data-field="b8" class="field"></div>
					<div id="row-c8" data-info="<%= c8 %>" data-field="c8" class="field"></div>
					<div id="row-d8" data-info="<%= d8 %>" data-field="d8" class="field"></div>
					<div id="row-e8" data-info="<%= e8 %>" data-field="e8" class="field"></div>
					<div id="row-f8" data-info="<%= f8 %>" data-field="f8" class="field"></div>
					<div id="row-g8" data-info="<%= g8 %>" data-field="g8" class="field"></div>
					<div id="row-h8" data-info="<%= h8 %>" data-field="h8" class="field"></div>
				</div>
				<div id="row-7" class="board-row">
					<div id="row-a7" data-info="<%= a7 %>" data-field="a7" class="field"></div>
					<div id="row-b7" data-info="<%= b7 %>" data-field="b7" class="field"></div>
					<div id="row-c7" data-info="<%= c7 %>" data-field="c7" class="field"></div>
					<div id="row-d7" data-info="<%= d7 %>" data-field="d7" class="field"></div>
					<div id="row-e7" data-info="<%= e7 %>" data-field="e7" class="field"></div>
					<div id="row-f7" data-info="<%= f7 %>" data-field="f7" class="field"></div>
					<div id="row-g7" data-info="<%= g7 %>" data-field="g7" class="field"></div>
					<div id="row-h7" data-info="<%= h7 %>" data-field="h7" class="field"></div>
				</div>
				<div id="row-6" class="board-row">
					<div id="row-a6" data-info="<%= a6 %>" data-field="a6" class="field"></div>
					<div id="row-b6" data-info="<%= b6 %>" data-field="b6" class="field"></div>
					<div id="row-c6" data-info="<%= c6 %>" data-field="c6" class="field"></div>
					<div id="row-d6" data-info="<%= d6 %>" data-field="d6" class="field"></div>
					<div id="row-e6" data-info="<%= e6 %>" data-field="e6" class="field"></div>
					<div id="row-f6" data-info="<%= f6 %>" data-field="f6" class="field"></div>
					<div id="row-g6" data-info="<%= g6 %>" data-field="g6" class="field"></div>
					<div id="row-h6" data-info="<%= h6 %>" data-field="h6" class="field"></div>
				</div>
				<div id="row-5" class="board-row">
					<div id="row-a5" data-info="<%= a5 %>" data-field="a5" class="field"></div>
					<div id="row-b5" data-info="<%= b5 %>" data-field="b5" class="field"></div>
					<div id="row-c5" data-info="<%= c5 %>" data-field="c5" class="field"></div>
					<div id="row-d5" data-info="<%= d5 %>" data-field="d5" class="field"></div>
					<div id="row-e5" data-info="<%= e5 %>" data-field="e5" class="field"></div>
					<div id="row-f5" data-info="<%= f5 %>" data-field="f5" class="field"></div>
					<div id="row-g5" data-info="<%= g5 %>" data-field="g5" class="field"></div>
					<div id="row-h5" data-info="<%= h5 %>" data-field="h5" class="field"></div>
				</div>
				<div id="row-4" class="board-row">
					<div id="row-a4" data-info="<%= a4 %>" data-field="a4" class="field"></div>
					<div id="row-b4" data-info="<%= b4 %>" data-field="b4" class="field"></div>
					<div id="row-c4" data-info="<%= c4 %>" data-field="c4" class="field"></div>
					<div id="row-d4" data-info="<%= d4 %>" data-field="d4" class="field"></div>
					<div id="row-e4" data-info="<%= e4 %>" data-field="e4" class="field"></div>
					<div id="row-f4" data-info="<%= f4 %>" data-field="f4" class="field"></div>
					<div id="row-g4" data-info="<%= g4 %>" data-field="g4" class="field"></div>
					<div id="row-h4" data-info="<%= h4 %>" data-field="h4" class="field"></div>
				</div>
				<div id="row-3" class="board-row">
					<div id="row-a3" data-info="<%= a3 %>" data-field="a3" class="field"></div>
					<div id="row-b3" data-info="<%= b3 %>" data-field="b3" class="field"></div>
					<div id="row-c3" data-info="<%= c3 %>" data-field="c3" class="field"></div>
					<div id="row-d3" data-info="<%= d3 %>" data-field="d3" class="field"></div>
					<div id="row-e3" data-info="<%= e3 %>" data-field="e3" class="field"></div>
					<div id="row-f3" data-info="<%= f3 %>" data-field="f3" class="field"></div>
					<div id="row-g3" data-info="<%= g3 %>" data-field="g3" class="field"></div>
					<div id="row-h3" data-info="<%= h3 %>" data-field="h3" class="field"></div>
				</div>
				<div id="row-2" class="board-row">
					<div id="row-a2" data-info="<%= a2 %>" data-field="a2" class="field"></div>
					<div id="row-b2" data-info="<%= b2 %>" data-field="b2" class="field"></div>
					<div id="row-c2" data-info="<%= c2 %>" data-field="c2" class="field"></div>
					<div id="row-d2" data-info="<%= d2 %>" data-field="d2" class="field"></div>
					<div id="row-e2" data-info="<%= e2 %>" data-field="e2" class="field"></div>
					<div id="row-f2" data-info="<%= f2 %>" data-field="f2" class="field"></div>
					<div id="row-g2" data-info="<%= g2 %>" data-field="g2" class="field"></div>
					<div id="row-h2" data-info="<%= h2 %>" data-field="h2" class="field"></div>
				</div>
				<div id="row-1" class="board-row">
					<div id="row-a1" data-info="<%= a1 %>" data-field="a1" class="field"></div>
					<div id="row-b1" data-info="<%= b1 %>" data-field="b1" class="field"></div>
					<div id="row-c1" data-info="<%= c1 %>" data-field="c1" class="field"></div>
					<div id="row-d1" data-info="<%= d1 %>" data-field="d1" class="field"></div>
					<div id="row-e1" data-info="<%= e1 %>" data-field="e1" class="field"></div>
					<div id="row-f1" data-info="<%= f1 %>" data-field="f1" class="field"></div>
					<div id="row-g1" data-info="<%= g1 %>" data-field="g1" class="field"></div>
					<div id="row-h1" data-info="<%= h1 %>" data-field="h1" class="field"></div>
				</div>
			</div>
			<div class='row'><p class='col-xs-12'><button id='endTheGame'>End the game</button></p></div>
		</script>
	</div>
</main>
<?php require_once('tmpl/footer.php');?>