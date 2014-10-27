function getAccodrionCode()
{
	return '<div class="panel-group" id="accordion"> \
  <div class="panel panel-default"> \
    <div class="panel-heading">\
      <h4 class="panel-title">\
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">\
          Collapsible Group Item #1\
        </a>\
      </h4>\
    </div>\
    <div id="collapseOne" class="panel-collapse collapse in">\
      <div class="panel-body">\
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably havent heard of them accusamus labore sustainable VHS.\
      </div>\
    </div>\
  </div>';
}

$(document).ready( function(){
  $(".add-queue").click( function(){
    $(this).before( $(".queue-block").html() );
    /* '\
        Queue - \
          <input class="form-control" maxlength="30" name="qname[]" placeholder="Queue Name"/>\
          <input class="form-control" maxlength="30" name="qdesc[]" placeholder="Queue Description"/>\
          <input class="form-control" maxlength="30" name="qmaxruntime[]" placeholder="Queue Max Run Time"/>\
          <input class="form-control" maxlength="30" name="qmaxnodes[]" placeholder="Queue Max Nodes"/>\
          <input class="form-control" maxlength="30" name="qmaxprocessors[]" placeholder="Queue Max Processors"/>\
          <input class="form-control" maxlength="30" name="qmaxjobsinqueue[]" placeholder="Max JObs In Queue"/>\
          <hr/> \
          ');
    */
  });

  $(".add-alias").click( function(){
    $(this).before( '<input class="form-control" maxlength="30" name="hostaliases[]"/>');
  });

  $(".add-ip").click( function(){
    $(this).before( '<input class="form-control" maxlength="30" name="ips[]"/>');
  })

  /* 
   * code that relates to Job Submission Protocol Interface starts here.
  */

  $(".add-job-submission").click( function(){
    $(".job-submission-info").removeClass("hide").append( "<div class='job-protocol-block col-md-12'>" + $(".select-job-protocol").html() + "</div><hr/>");
  });

  $("body").on("change", ".selected-job-protocol", function(){

    var selectedVal = $(this).children("option:selected").html().toLowerCase();

    $(this).parent().find("div[class*='resourcemanager-']").remove();

    var parentResDiv = "<div class='resourcemanager-" + selectedVal + "'>"
                + "<hr/>" 
                + "Resource Manager: <h4>" + selectedVal + "</h4>"
                + "<hr/>";

    if( selectedVal == "local")
    {
      $(this).after(  parentResDiv + $(".resource-manager-block").html() + "</div>" );
    }
    else if( selectedVal == "ssh")
    {
      $(this).after(  parentResDiv 
                      + $(".ssh-block").html()
                      + $(".resource-manager-block").html() 
                      + "</div>" );
      $(this).parent().find(".addedScpValue").removeClass("hide");

    }
    else if( selectedVal == "globus")
    {
      $(this).parent().append(  parentResDiv 
                      + $(".ssh-block").html()
                      + "<h5>Globus Gate Keeper End Point</h5>" 
                      + "<input class='form-control' name='globusGateKeeperEndPoint'/>"
                      + "</div>" );
    }
    else if( selectedVal == "unicore")
    {
      $(this).parent().append(  parentResDiv 
                      + $(".ssh-block").html()
                      + "<h5>Unicore End Point Url</h5>" 
                      + "<input class='form-control' name='unicoreEndPointURL'/>"
                      + "</div>" );
    }
    else if( selectedVal == "cloud")
    {
      $(this).parent().append(  parentResDiv 
                      + $(".ssh-block").html()
                      + $(".cloud-block").html()
                      );
    }
    else{
      alert("Something went wrong. Please try again");
      $(".jspSubmit").addClass("hide");
    }

    $(".jspSubmit").removeClass("hide");
  });
  
  /* 
   * code that relates to Job Submission Protocol Interface ends here.
  */


  /* 
   * code that relates to Data Movement Interface starts here.
  */

  $(".add-data-movement").click( function(){
    $(".data-movement-info").removeClass("hide").append( "<div class='data-movement-block col-md-12'>" + $(".select-data-movement").html() + "</div><hr/>");
  });


  $("body").on("change", ".selected-data-movement-protocol", function(){

    var selectedVal = $(this).children("option:selected").html().toLowerCase();

    $(this).parent().find("div[class*='dataprotocol-']").remove();
    var parentDataDiv = "<div class='dataprotocol-" + selectedVal + "'>"
                + "<hr/>" 
                + "Data Management Protocol: <h4>" + selectedVal + "</h4>"
                + "<hr/>";
    if( selectedVal == "local")
    {
      // to find out what goes here.
    }
    else if( selectedVal == "scp" )
    {
      $(this).after(  parentDataDiv 
                      + $(".ssh-block").html()
                      + "</div>" );
      $(this).parent().find(".addedScpValue").removeClass("hide");
    }
    else if( selectedVal == "sftp")
    {
      // to find out what goes here.
    }
    else if( selectedVal == "gridftp")
    {
      $(this).after(  parentDataDiv 
                      + $(".ssh-block").html()
                      + $(".dm-gridftp").html()
                      + "</div>" );
    }
    else if( selectedVal == "unicore_storage_service")
    {
      $(this).after(  parentDataDiv 
                      + $(".ssh-block").html()
                      + "<h5>Unicore End Point Url</h5>" 
                      + "<input class='form-control' name='unicoreEndPointURL'/>"
                      + "</div>" );
    }
    else{
      alert("Something went wrong. Please try again");
      $(".dmpSubmit").addClass("hide");
    }
    $(".dmpSubmit").removeClass("hide");

  });

  $("body").on("click", ".add-gridFTPEndPoint", function(){
        $(this).before( '<input class="form-control" maxlength="30" name="gridFTPEndPoints[]"/>');
  });

  var highest = null;

   $(".nav-tabs a").each(function(){  //find the height of your highest link
       var h = $(this).height();
       if(h > highest){
          highest = $(this).height();  
       }    
    });

   $(".nav-tabs a").height(highest);  //set all your links to that height.
   
});