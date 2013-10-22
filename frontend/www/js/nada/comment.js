function commentRegisterEventSubmit(){
		$( "#comment-form" ).submit(function( event ) {
		  alert( "Handler for .submit() called." );
		  event.preventDefault();
	});
}