$(document).ready( function(){

	// add new input fields block.
	$(".app-interface-form-content").on( "click", ".add-input", function(){
		var appInputDiv = $('<div></div>');
		appInputDiv.html( $(".app-input-block").html() );
		appInputDiv.find("input[type=text]").val("");
		appInputDiv.find("textarea").html("");
		appInputDiv.find("input").removeAttr("readonly");
    	appInputDiv.find("textarea").removeAttr("readonly");
    	appInputDiv.find("select").removeAttr("readonly");
    	appInputDiv.find(".hide").removeClass("hide");
		$(".app-inputs").append(  appInputDiv );
	});

	// add new output fields block.
	$(".app-interface-form-content").on( "click", ".add-output", function(){
		var appOutputDiv = $('<div></div>');
		appOutputDiv.html( $(".app-output-block").html() );
		appOutputDiv.find("input[type=text]").val("");
		appOutputDiv.find("textarea").html("");
		appOutputDiv.find("input").removeAttr("readonly");
    	appOutputDiv.find("textarea").removeAttr("readonly");
    	appOutputDiv.find("select").removeAttr("readonly");
    	appOutputDiv.find(".hide").removeClass("hide");
		$(".app-outputs").append( appOutputDiv );
	});

	// remove an input fields block
	$(".app-interface-form-content").on("click", ".remove-input-space", function(){
		$(this).parent().remove();
	});

	$(".app-interface-form-content").on("click", ".remove-input-space", function(){
		$(this).parent().remove();
	});

	// remove an output fields block
	$(".app-interface-form-content").on("click", ".remove-output-space", function(){
		$(this).parent().remove();
	});

	$(".app-interface-form-content").on("click", ".add-app-module", function(){
		$(this).parent().children(".app-modules").append( $(".app-module-block").html() );
	});

	$(".app-interface-form-content").on("click", ".app-modules", function(){
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
    	appInterfaceContent.find("input").removeAttr("readonly");
    	appInterfaceContent.find("textarea").removeAttr("readonly");
    	appInterfaceContent.find("select").removeAttr("readonly");
    	appInterfaceContent.find(".hide").removeClass("hide");

    	$(".app-interface-form-content").html( appInterfaceContent.html() );
    });
});