var app = app || {};

(function(){
	'use strict';

	var oldBackboneSync = Backbone.sync;
	Backbone.sync = function( method, model, options ) {
		if ( method === 'delete' ) {
			if ( options.data ) {
				options.data = JSON.stringify(options.data);
			}
			options.contentType = 'application/json';
		}
		return oldBackboneSync.apply(this, [method, model, options]);
	}

	app.ChessLastGameModel = Backbone.Model.extend({
		url: 'ajax/last_game.php'
	});
	
	app.ChessStat = Backbone.Model.extend({
		url: 'ajax/game_info.php'
	});
	
	app.ChessLog = Backbone.Model.extend({
		url: 'ajax/game_log.php',
		defaults:{turn:0,player:0}
	});	
	
	app.ChessPiecesList = Backbone.Model.extend({
		url: 'ajax/piece_list.php'
	});	
	
	app.ChessValidateTurn = Backbone.Model.extend({
		url: 'ajax/validate_turn.php'
	});
	
	app.ChessBoardView = Backbone.View.extend({
		el:"#chessBoardWrap",
		template:_.template($("#boardData").html()),
		events:{
			'click .field':'actionPiece',
			'click #endTheGame':'endGame',
			'mouseover  .field':'showTooltip',
			'mouseout  .field':'removeTooltip',
		},
		initialize:function(){
			app.chessBoardView_this = this;
		},
		showTooltip:function(e){
			this.setElementInfo(e);
			if(!this.$(".selected")[0]){
				if(app.chessLog.get("player") != app.setElementInfoModel.pieceColor)
					$(e.target).addClass("disabled");
			}
		},
		removeTooltip:function(e){
			this.setElementInfo(e);
			if(app.chessLog.get("player") != app.setElementInfoModel.pieceColor)
				$(e.target).removeClass("disabled");
		},
		endGame:function(){
			app.chessLog.destroy({data: { id: app.chessLog.get('id') }, processData: true}).done(function(){
				app.chessStat.destroy({data: { id: app.chessStat.get('id') }, processData: true}).done(function(){
					app.chessBoardView_this.$el.html("");
					app.chessBoardView.undelegateEvents();
					app.chessApp.undelegateEvents();
					app.chessApp = new app.ChessApp();				
				});
			});
		},
		setElementInfo:function(e){
			var dataInfo = String($(e.target).data("info"));
			var pieceColor = dataInfo[1];
			var dataField = $(e.target).data("field");
			var pieceType = dataInfo[0];
			var pieceColor = dataInfo[1];
			var pieceAction = dataInfo[2];
			app.setElementInfoModel = {dataInfo:dataInfo,pieceColor:pieceColor,dataField:dataField,pieceType:pieceType,pieceColor:pieceColor,pieceAction:pieceAction};
		},
		actionPiece:function(e){
			var enemy;
			this.setElementInfo(e);
			this.$(".field").removeClass("selected");
			if(app.chessLog.get("player") == app.setElementInfoModel.pieceColor){
				$(e.target).addClass("selected");
				app.start = app.setElementInfoModel.dataField;
				app.startValue = app.setElementInfoModel.dataInfo;
				app.pieceType = app.pieceList.get([app.setElementInfoModel.pieceType]);
				app.pieceAction = app.setElementInfoModel.pieceAction;
				if(app.pieceAction == 1)
					app.startValue = ""+app.setElementInfoModel.pieceType+""+app.setElementInfoModel.pieceColor+"0";
			}
			if(app.start != undefined && app.setElementInfoModel.pieceColor != app.chessLog.get("player")){
				if(app.setElementInfoModel.pieceColor == undefined)
					enemy = 0;
				else
					enemy = 1;
				app.end = app.setElementInfoModel.dataField;
				app.endValue = app.setElementInfoModel.dataInfo;
				var actionPieceModel = {
					startPosition:app.start,
					endPosition:app.end,
					peiceType:app.pieceType,
					enemy:enemy,
					turn:app.chessLog.get("turn"),
					player:app.chessLog.get("player"),
					game_log_id:app.chessLog.get("id"),
					game_info_id:app.chessLog.get("game_info_id"),
					firstAction:app.pieceAction
				}
				var chessValidateTurn = new app.ChessValidateTurn(actionPieceModel);
				chessValidateTurn.save().done(function(){
					if(Number(chessValidateTurn.get("validated"))){
						if(enemy){
							delete app.endValue;
							if(app.pieceList.get([app.setElementInfoModel.pieceType]) == "king"){
								alert(app.chessBoardView_this.showPlayerColor(app.chessLog.get("player"))+" player win the game!");
								app.chessBoardView_this.endGame();
							}	
						}
						app.chessStat.set(app.start,app.endValue);
						app.chessStat.set(app.end,app.startValue);
						app.chessStat.set('updateGameInfo',true);
						app.chessStat.save();
						app.chessLog.set('turn',app.chessBoardView_this.setNextTurn(app.chessLog.get('turn'),app.chessLog.get('player')));
						app.chessLog.set('player',app.chessBoardView_this.setPlayerColor(app.chessLog.get('player')));
						app.chessLog.save();
						app.chessBoardView_this.render();
					}
					delete app.setElementInfoModel;
					delete app.start;
				});
			}
		},
		showPlayerColor:function(player){
			return (Number(player) == 0) ? "white" : "black";
		},
		setPlayerColor:function(player){
			return (Number(player)) ? 0 : 1;
		},
		setNextTurn:function(turn,player){
			turn = Number(turn);
			return (Number(player) == 1) ? turn+1 : turn;
		},
		render:function(){
			this.$el.html(this.template(app.chessStat.toJSON()));
		}
	});
	
	app.ChessApp = Backbone.View.extend({
		el:"#startBtnWrap",
		events:{
			'click #startButton':'startNewGame',
			'click #resumeButton':'resumeGame',
		},
		initialize:function(){
			app.chessApp_this = this;
			app.pieceList = new app.ChessPiecesList();
			app.chessStat = new app.ChessStat();
			app.chessLog = new app.ChessLog();
			app.lastGameModel = new app.ChessLastGameModel();
			app.chessLogView = new app.ChessLogView();
			app.chessBoardView = new app.ChessBoardView();
			app.pieceList.fetch();
			this.render();
		},
		startNewGame:function(){ 
			app.chessStat.save({createGameInfo:true}).done(function(){
				app.chessLog.save({createChessLog:app.chessStat.get('id')}).done(function(){
					app.chessApp_this.loadBoardViews();
				});	
			});
		},
		resumeGame:function(){
			app.chessStat.save({getGameInfoById:app.lastGameModel.get("game_info_id")}).done(function(){	
				app.chessLog.save({getChessLogById:app.lastGameModel.get("id")}).done(function(){
					app.chessApp_this.loadBoardViews();
				});
			});
		},
		loadBoardViews:function(){
			app.chessBoardView.render();
			app.chessApp_this.$el.html("");
			app.chessLogView.render().el;
		},
		render:function(){
			var chessAppStartBtnText;
			var chessAppStartBtnId;
			var chessAppStartBtnTemplate = _.template("<p id='startButtonWrap' class='col-xs-12'><button id='<%=chessAppStartBtnId%>'><%=chessAppStartBtnText%></button></p>");

			app.lastGameModel.fetch().done(function(){
				chessAppStartBtnId = (app.lastGameModel.get("error")) ? "startButton" : "resumeButton";
				chessAppStartBtnText = (app.lastGameModel.get("error")) ? "Start New" : "Countinue";
				app.chessApp_this.$el.html(chessAppStartBtnTemplate({chessAppStartBtnId:chessAppStartBtnId,chessAppStartBtnText:chessAppStartBtnText}));
				return app.chessApp_this;
			});
		}
	});

	app.ChessLogView = Backbone.View.extend({
		el:"#chessStat",
		initialize:function(){
			this.listenTo(app.chessLog, 'change', this.render);
			this.listenTo(app.chessLog, 'destroy', this.destroy);
		},
		template: _.template($("#chessStatTemplate").html()),
		render:function(){
			this.$el.html(this.template(app.chessLog.toJSON()));
			return this;
		},
		destroy:function(){
			this.$el.html(this.template({turn:0,player:0}));
			return this;
		}

	});
	
	app.ChessRouter = Backbone.Router.extend({
		routes: {
			"":"hideChessStat",
			"game-log":"showChessStat",
		},
		showChessStat:function(){
			$("#chessStat").css("display","block");
		},
		hideChessStat:function(){
			$("#chessStat").css("display","none");
		}
	});
	/*******************************************************************/
	new app.ChessRouter();
	app.chessApp = new app.ChessApp();
	Backbone.history.start();
})();