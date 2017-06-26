function submitFile(formUrl,formDatalink,responseText,respondNodeId,staticBoardElement){
        var formData = new FormData(formDatalink);
        var getted = $.ajax({
                url: formUrl,
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data, textSatus, jqXHR){
						if(responseText === true && respondNodeId){
							document.getElementById(respondNodeId).innerHTML = getted.responseText;
							player = Number(jQuery('#chessBoardWrap').find('#player').val());
							var turn = jQuery('#chessBoardWrap').find("#turn").val();
							jQuery('#current-player').text(getColor(player,false));
							jQuery('#current-turn').text(turn);
							if(issetActiveElement("#access")){
								if(Number(jQuery("#access").val()) == 0){
									movePiece(staticBoardElement);
								}
							}
						}	
                },
                error: function(jqXHR, textStatus, errorThrown){
					
                }
        });
}

function getColor(color,number=true){
	if(number){
		if(color != 'white' && color != 'black'){
			color = 2;
		}
		if(color == 'white'){
			color = 0;
		}
		if(color == 'black'){
			color = 1;
		}

	}else{
		color = Number(color);
		if(color != 0 && color != 1){
			color = "";
		}
		if(color == 0){
			color = 'white';
		}
		if(color == 1){
			color = 'black';
		}
	}
	return color;
}

function movePiece(staticBoardElement){
	var cache;
	var cacheDataPiece;
	var cacheDataColor;
	
	cache = endPostitionElementLink.children();
	startPostitionElementLink.children().fadeOut(500,function(){
		cacheDataPiece = startPostitionElementLink.data('piece');
		cacheDataColor = startPostitionElementLink.data('color');
		endPostitionElementLink.attr('data-color',cacheDataColor);
		endPostitionElementLink.data('color',cacheDataColor);
		endPostitionElementLink.data('piece',cacheDataPiece);
		
		startPostitionElementLink.data('piece','');
		startPostitionElementLink.data('color','');
		endPostitionElementLink.html(startPostitionElementLink.children());
		endPostitionElementLink.children().fadeIn(500);
		if(enemy == 1){
			cache = '<div class=" chess-pieces"><p></p></div>';
		}
		startPostitionElementLink.html(cache);
		staticBoardElement.find('.field').removeClass('active');
		jQuery("#access").val(1);	
	});

}

function issetActiveElement(findElement){
	var activeElement = jQuery('#chessBoardWrap').find(findElement)[0];
	if(typeof activeElement == "undefined"){
		return false;
	}else{
		return true;
	}
}

function setStartPosition(curentPieceClick,player,staticBoardElement){
	var startPosition = curentPieceClick.data('field');
	var userGIField = jQuery('#selected-field');
	var color = getColor(curentPieceClick.data('color'));
	var piece = curentPieceClick.data('piece');
	var firstAction = curentPieceClick.data('action');	
	
	if(color === player){
		staticBoardElement.find('.field').removeClass('active');
		curentPieceClick.addClass('active');
		staticBoardElement.find('#startPosition').val(startPosition);
		staticBoardElement.find('#peiceType').val(piece);
		staticBoardElement.find('#firstAction').val(firstAction);
		userGIField.text(startPosition);
	}
}
jQuery(document).ready(function() {
	var staticBoardElement = jQuery('#chessBoardWrap');
	
	jQuery('#startButton').click(function(){
		submitFile("php/init.php",jQuery('#chessboardData')[0],true,"chessBoardWrap",staticBoardElement);
	});
	staticBoardElement.on('click', '#endTheGame', function(){
		submitFile("php/end_the_game.php",jQuery('#chessboardData')[0],true,"chessBoardWrap",staticBoardElement);
	});
	
	jQuery('#chessBoardWrap').on({
		mouseenter: function () {
			var curentPieceHover = jQuery(this); 
			var color = getColor(curentPieceHover.data('color'));
			allowToSetEndPosition = false;
			allowToSetStartPosition = false;
			if(!issetActiveElement(".active")){
				if(color !== player){
					curentPieceHover.addClass('lock');
					allowToSetStartPosition = false;
				}else{
					allowToSetStartPosition = true;
				}
			}else{
				if(color == player){
					allowToSetStartPosition = true;
					allowToSetEndPosition = false;	
				}else{
					allowToSetStartPosition = false;
					allowToSetEndPosition = true;
				}
				
				
			}
		},
		
		mouseleave: function () {
			if(jQuery(this).hasClass('lock')){
				jQuery(this).removeClass('lock');	
			}		
		}
	},'.field');
	
	staticBoardElement.on('click', '.field', function(){
		var currentLink = jQuery(this);
		var color = getColor(currentLink.data('color'));

		if(allowToSetStartPosition === true){
			startPostitionElementLink = jQuery(this);
			setStartPosition(currentLink,player,staticBoardElement);	
		}
		if(allowToSetEndPosition === true){
			if(color !== player && color != 2){
				enemy = 1;
			}else{
				enemy = 0;
			}
			staticBoardElement.find("#enemy").val(enemy);
			endPostitionElementLink = jQuery(this);
			staticBoardElement.find('#endPosition').val(currentLink.data('field'));
			submitFile("php/validate_turn.php",jQuery('#chessboardData')[0],true,"chessboardData",staticBoardElement);
		}	
	});
});
