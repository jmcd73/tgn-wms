// document.ready
$(function() {
    
	ok_to_go = true;

        $('form').submit(function(){
            var radio_val = $('input[name="printer"]:checked').val();
    
            if (! radio_val){
                // cancel submit on no printer selection
                $('#error').html('<div class="alert alert-warning"><span class="glyphicon glyphicon-alert"></span> Please select a printer.</div>');    
                return false;
            } else {
                $('#error').hide();
            };
        });

	// reset button test
	$('input[type="submit"], input[type="reset"]').button();
	
	$('input[type="submit"]').click(function(event){
		var copies = $('input[name="copies"]');
		 	if (copies.val() === "" || parseInt(copies.val()) == 'NaN') {
				copies.focus();
				copies.css ('background-color', 'yellow');
				ok_to_go = false;
			}
		var allInputs = '';
		
		allInputsObj = $('div.well input[type="text"]');	
		allInputsObj.each(function(){
			allInputs = allInputs + $(this).val() 
		});	
		console.log(allInputs);
		if (allInputs === '') {
			ok_to_go = false;
			allInputsObj.css('background-color', 'yellow')
		} else {
			allInputsObj.css('background-color', 'white');
		}
		if (! ok_to_go ) {
			console.log("not ok to go");
			ok_to_go = true;
			event.preventDefault();
			return false;
		}	
		console.log('int submit click');
	
	
	});
	
}); // end doc ready

