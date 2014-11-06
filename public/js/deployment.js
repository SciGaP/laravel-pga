$( document).ready( function(){

	$(".add-load-cmd").click( function(){
		$(".show-load-cmds").append( $(".load-cmd-ui").html() );
	});

	$(".add-lib-prepend-path").click( function(){
		$(".show-lib-prepend-paths").append( $(".lib-prepend-path-ui").html() );
	});

	$(".add-lib-append-path").click( function(){
		$(".show-lib-append-paths").append( $(".lib-append-path-ui").html() );
	});

	$(".add-environment").click( function(){
		$(".show-environments").append( $(".environment-ui").html() );
	});
})