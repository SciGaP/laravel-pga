$(document).ready( function(){

	$(".add-input").click( function(){
		$(".app-inputs").append( $(".app-input-block").html() );
	});

	$(".add-output").click( function(){
		$(".app-outputs").append( $(".app-output-block").html() );
	});

});