function submitFile(formUrl,formDatalink,responseText,respondNodeId){
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
                        //now get here response returned by PHP in JSON fomat you can parse it using JSON.parse(data)
						if(responseText === true && respondNodeId){
							document.getElementById(respondNodeId).innerHTML = getted.responseText;
							jQuery('#chessBoardWrap').find('#startPosition').val(startPosition);
							jQuery('#current-player').text(getColor(jQuery('#chessBoardWrap').find('#player').val(),false));
						}	
                },
                error: function(jqXHR, textStatus, errorThrown){
                        //handle here error returned
                }
        });
}

function getColor(color,number=true){
	
	if(number){
		if(color == 'white'){
			color = 0;
		}
		if(color == 'black'){
			color = 1;
		}
	}else{
		color = Number(color);
		if(color == 0){
			color = 'white';
		}
		if(color == 1){
			color = 'black';
		}
	}
	return color;
}

/*check dom if active class exist on board*/
function issetActiveElement(){
	var activeElement = jQuery('#chessBoardWrap').find('.active')[0];
	if(typeof activeElement == "undefined"){
		return false;
	}else{
		return true;
	}
}

function setStartPosition(curentPieceClick,player,staticBoardElement){
	var startPosition = curentPieceClick.data('field');//start position of current piece a-h/1/8
	var userGIField = jQuery('#selected-field');//user GUI field it show start position for piece a-h/1-8
	//var selectedPiece = jQuery('#selectedPiece');//user GUI field it show start position for piece a-h/1-8
	var color = getColor(curentPieceClick.data('color'));
	var piece = curentPieceClick.data('piece');//current type of piece pawn-king			
	if(color === player){
		staticBoardElement.find('.field').removeClass('active');
		curentPieceClick.addClass('active');
		userGIField.text(startPosition);
		staticBoardElement.find('#startPosition').val(startPosition);
		staticBoardElement.find('#peiceType').val(piece);
	}
}
jQuery(document).ready(function() {
	/*init.php return created starting game data*/
	jQuery('#startButton').click(function(){
		submitFile("php/init.php",jQuery('#chessGameData')[0],true,"chessBoardWrap");
	});
	
	/*ALLOW PLAYER USE ONLY HIS OWN PIECES (first click)*/
	jQuery('#chessBoardWrap').on({
		//HOVER IN
		mouseenter: function () {
			var curentPieceHover = jQuery(this); 
			var player = Number(jQuery('#chessBoardWrap').find('#player').val());// current player 0/1
			var color = getColor(curentPieceHover.data('color'));//color of current piece - white/black  /  transorm color name white/black to  number of color 0/1
			var staticBoardElement = jQuery('#chessBoardWrap');//highest static element that not effected by dynamyc data

			if(!issetActiveElement()){/*FIRST/Second ACTION*/
				if(color !== player){
					curentPieceHover.addClass('lock');
				}else{
					/*CLICK*/
					staticBoardElement.on('click', '.field', function(){		
						setStartPosition(jQuery(this),player,staticBoardElement);	
					});	
				}
			}else{
				/*SECOND CLICK*/
				staticBoardElement.unbind().on('click', '.field', function(){
					var curentMoveForSelectedPiece = jQuery(this);
					var color = getColor(curentMoveForSelectedPiece.data('color'));//for some reason it cant see parent scope :/
					var endPosition;

					if(color !== player){
						endPosition = curentMoveForSelectedPiece.data('field');
						staticBoardElement.find('#endPosition').val(endPosition);
						submitFile("php/validate_turn.php",jQuery('#chessboardData')[0],true,"test");
					}else{
						setStartPosition(jQuery(this),player,staticBoardElement);
					}
				});
			}
		},
		//HOVER OUT
		mouseleave: function () {
			if(jQuery(this).hasClass('lock')){
				jQuery(this).removeClass('lock');	
			}		
		}
	},'.field');
});
