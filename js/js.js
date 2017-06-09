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
							
						}	
                },
                error: function(jqXHR, textStatus, errorThrown){
                        //handle here error returned
                }
        });
}

jQuery(document).ready(function() {
	
});
