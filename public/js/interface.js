$(document).ready( function(){

	//show interface options on hovering on it
	$(".panel-title").hover( 
		function(){
			$(this).find(".interface-options").addClass("in");
		},
		function(){
			$(this).find(".interface-options").removeClass("in");
		}
	);
	// add new input fields block.
	$("body").on( "click", ".add-input", function(){
		var appInputDiv = $('<div></div>');
		appInputDiv.html( $(".app-input-block").html() );
		clearInputs( appInputDiv);
		$(".app-inputs").append(  appInputDiv );
	});

	// add new output fields block.
	$("body").on( "click", ".add-output", function(){
		var appOutputDiv = $('<div></div>');
		appOutputDiv.html( $(".app-output-block").html() );
		clearInputs( appOutputDiv);
		$(".app-outputs").append( appOutputDiv );
	});

	// remove an input fields block
	$("body").on("click", ".remove-input-space", function(){
		$(this).parent().remove();
	});

	$("body").on("click", ".remove-input-space", function(){
		$(this).parent().remove();
	});

	// remove an output fields block
	$("body").on("click", ".remove-output-space", function(){
		$(this).parent().remove();
	});

	$("body").on("click", ".add-app-module", function(){
		$(this).parent().children(".app-modules").append( $(".app-module-block").html() );
	});

	$("body").on("click", ".remove-app-module", function(){
		$(this).parent().remove();
	});

	$('.filterinput').keyup(function() {
        var a = $(this).val();
        if (a.length > 0) {
            children = ($("#accordion").children());

            var containing = children.filter(function () {
                var regex = new RegExp('\\b' + a, 'i');
                return regex.test($('a', this).text());
            }).slideDown();
            children.not(containing).slideUp();
        } else {
            children.slideDown();
        }
        return false;
    });

    $(".edit-app-interface").click( function(){
    	var appInterfaceContent = $("<div></div>");
    	appInterfaceContent.html( $(this).parent().parent().parent().parent().find(".app-interface-block").html());
    	clearInputs( appInterfaceContent, true);

    	$(".app-interface-form-content").html( appInterfaceContent.html() );
    });

    $(".create-app-interface").click( function(){
    	clearInputs( $(".create-app-interface-block"));
    	$("#create-app-interface-block").modal("show");

    });

    $(".submit-create-app-interface-form, ").click( function(){
    	console.log( $(this).parent().parent().find(".app-module-select").length);
    	if( $(this).parent().find(".app-module-select").length)
    	{
    		$("#create-app-interface-form").submit();
    	}
    	else
    		alert("An Application Interface requires minimum one Application Module.");
    });

    $(".delete-app-interface").click( function(){
        	var interfaceId = $(this).data("interface-id");
        	$(".delete-interface-name").html( $(this).parent().parent().find(".interface-name").html() );
        	$(".delete-interfaceid").val( interfaceId )
        });
});

function clearInputs( elem, removeJustReadOnly){

	if( !removeJustReadOnly)
	{
		elem.find("input").val("");
		elem.find("textarea").html("");
	}
	elem.find("input").removeAttr("readonly");
	elem.find("textarea").removeAttr("readonly");
	elem.find("select").removeAttr("readonly");
	elem.find(".hide").removeClass("hide");
}