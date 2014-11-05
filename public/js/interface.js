$(document).ready( function(){

	// add new input fields block.
	$(".add-input").click( function(){
		$(".app-inputs").append( $(".app-input-block").html() );
	});

	// add new output fields block.
	$(".add-output").click( function(){
		$(".app-outputs").append( $(".app-output-block").html() );
	});

	// remove an input fields block
	$(".app-inputs").on("click", ".remove-input-space", function(){
		$(this).parent().remove();
	});

	// remove an output fields block
	$(".app-outputs").on("click", ".remove-output-space", function(){
		$(this).parent().remove();
	});
});