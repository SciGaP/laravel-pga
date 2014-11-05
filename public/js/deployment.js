$( document).ready( function(){

	$(".add-load-cmd").click( function(){
		$(".show-load-cmds").append( $(".load-cmd-ui").html() );
	});
})