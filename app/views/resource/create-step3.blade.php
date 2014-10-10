@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<h3>Add Resource Data</h3>
		<form role="form" method="POST" action="{{ URL::to('/') }}/cr/create">

			<div class="select-job-protocol hide">
				<h4>Select the job submission protocol</h4>
				<select class="form-control selected-job-protocol">
				  <option></option>
				  <option value="local">Local</option>
				  <option value="ssh">SSH</option>
				  <option value="globus">Globus</option>
				  <option value="unicore">Unicore</option>
				  <option value="cloud">Cloud</option>
				</select>
			</div>

			<div class="resource-manager-block hide">
				<div class="select-resource-manager-type">
					<h4>Select resource manager type</h4>
					<select class="form-control selected-resource-manager">
					  <option></option>
					  <option value="local">FORK</option>
					  <option value="ssh">PBS</option>
					  <option value="globus">UGE</option>
					  <option value="unicore">SLURM</option>
					</select>
				</div>
			</div>

			<div class="ssh-block hide">
				<h5>Enter Security Protocol Details</h5>
				<input class="form-control" name="username_password" placeholder="USERNAME_PASSWORD" maxlength="30"/>
				<input class="form-control" name="ssh_keys" placeholder="SSH_KEYS" maxlength="30"/>
				<input class="form-control" name="gsi" placeholder="GSI" maxlength="30"/>
				<input class="form-control" name="kerberos" placeholder="KERBEROS" maxlength="30"/>
				<input class="form-control" name="oauth" placeholder="OAUTH" maxlength="30"/>

			</div>
			<div class="form-group">
				<div class="job-submission-data row hide"></div>
				<button type="button" class="btn btn-sm btn-default add-job-submission">Add a Job Submission Interface</button>
			</div>
			<hr/>
			<div class="form-group">
				<button type="button" class="btn btn-sm btn-default add-job-submission">Add a Data Movement Interface</button>
			</div>
			<hr/>
		</form>
	</div>
</div>

@stop

@section('scripts')
	@parent
    {{ HTML::script('js/script.js') }}

	<script>
		$(document).ready( function(){

			$(".add-job-submission").click( function(){
				$(".job-submission-data").removeClass("hide").append( "<div class='job-protocol-block col-md-12'>" + $(".select-job-protocol").html() + "</div></div><hr/>");
			});

			$("body").on("change", ".selected-job-protocol", function(){
				$("div[class*='resourcemanager-']").remove();

				var parentResDiv = "<div class='resourcemanager-" + $(this).val().toLowerCase() + "'>"
										+ "<hr/>" 
										+ "Resource Manager: <h4>" + $(this).val() + "</h4>" +
										+ "<hr/>";
										+ "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
				if( $(this).val().toLowerCase() == "local")
				{
					$(".job-protocol-block").append(  parentResDiv + $(".resource-manager-block").html() + "</div>" );
				}
				else if( $(this).val().toLowerCase() == "ssh")
				{
					$(".job-protocol-block").append(  parentResDiv 
													+ $(".ssh-block").html()
													+ $(".resource-manager-block").html() 
													+ "<h5>Alternate SSH Host Name</h5>" 
													+ "<input class='form-control' name='alternatesshhostname'/>"
													+ "</div>" );

				}
				else if( $(this).val().toLowerCase() == "globus")
				{
					$(".job-protocol-block").append(  parentResDiv 
													+ $(".ssh-block").html()
													+ "<h5>Globus Gate Keeper End Point</h5>" 
													+ "<input class='form-control' name='globusGateKeeperEndPoint'/>"
													+ "</div>" );
				}
			});
		});
	</script>
@stop