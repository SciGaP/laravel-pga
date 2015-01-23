@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<div class="row">
			<a href="{{URL::to('/')}}/gp/create">
				<button class="btn btn-default create-gateway-profile">Create a new Gateway Resource Profile</button>
			</a>
		</div>
		@if( count( $gatewayProfiles) )
			@if( Session::has("message"))
				<div class="row">
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						{{ Session::get("message") }}
					</div>
				</div>
				{{ Session::forget("message") }}
			@endif
			<div class="row">

				<div class="col-md-6">
					<h3>Existing Gateway Resource Profiles :</h3>
				</div>
				<div class="col-md-6" style="margin-top:3.5%">
					<input type="text" class="col-md-12 filterinput" placeholder="Search by Gateway Name" />
				</div>
			</div>
			<div class="panel-group" id="accordion1">
			@foreach( $gatewayProfiles as $indexGP => $gp )
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed gateway-name" data-toggle="collapse" data-parent="#accordion" href="#collapse-gateway-{{$indexGP}}">
							{{ $gp->gatewayName }}
							</a>
							<div class="pull-right col-md-2 gateway-options fade">
								<span class="glyphicon glyphicon-pencil edit-gateway" style="cursor:pointer;" data-toggle="modal" data-target="#edit-gateway-block" data-interface-id=""></span>
								<span class="glyphicon glyphicon-trash delete-gateway" style="cursor:pointer;" data-toggle="modal" data-target="#delete-gateway-block" data-interface-id=""></span>
							</div>
						</h4>
					</div>
					<div id="collapse-gateway-{{$indexGP}}" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="app-interface-block">
								<h2>{{ $gp->gatewayDescription}}</h2>
								<hr/>
								<div class="row">
									<div class="col-md-offset-1 col-md-10">
										<button class="btn btn-default add-cr" data-gpid="{{$gp->gatewayID}}"><span class="glyphicon glyphicon-plus"></span> Add a Compute Resource</button>
									</div>
								</div>
								@if( count( $gp->computeResourcePreferences) )
									<div class="col-md-12">
										<h3>Existing Compute Resources :</h3>
									</div>
									<div class="accordion-inner">
										<div class="panel-group" id="accordion-{{$indexGP}}">
										@foreach( (array)$gp->computeResourcePreferences as $indexCRP => $crp )
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a class="accordion-toggle collapsed gateway-name" data-toggle="collapse" data-parent="#accordion" href="#collapse-crp-{{$indexGP}}-{{$indexCRP}}">
														{{ $crp->crDetails->hostName }}
														</a>
													</h4>
												</div>
												<div id="collapse-crp-{{$indexGP}}-{{$indexCRP}}" class="panel-collapse collapse">
													<div class="panel-body">
														<div class="app-compute-resource-preferences-block">
															<form action="{{URL::to('/')}}/gp/update-crp" method="POST">
																<input type="hidden" name="gatewayId" id="gatewayId" value="{{$gp->gatewayID}}">
																<input type="hidden" name="computeResourceId" id="gatewayId" value="{{$crp->computeResourceId}}">
																<div class="form-horizontal">
																	@include('partials/gateway-preferences', array('computeResource' => $crp->crDetails, 'crData' => $crData, 'preferences'=>$crp, 'show'=>true))
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										@endforeach
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		@endif
	</div>
</div>

<div class="add-compute-resource-block hide">
	<div class="well">
		<form action="{{URL::to('/')}}/gp/add-crp" method="POST">
			<input type="hidden" name="gatewayId" id="gatewayId" value="">
			<div class="input-group">
				<select name="computeResourceId" class="cr-select form-control">
					<option value="">Select a compute Resource and set its preferences</option>
					@foreach( (array)$computeResources as $index => $cr)
					<option value="{{ $cr->computeResourceId}}">{{ $cr->hostName }}</option>
					@endforeach
				</select>
				<span class="input-group-addon remove-cr" style="cursor:pointer;">x</span>
			</div>
			<div class="pref-space form-horizontal"></div>
		</form> 
	</div>
</div>

@foreach( (array)$computeResources as $index => $cr)
	@include('partials/gateway-preferences', array('computeResource' => $cr, 'crData' => $crData))
@endforeach


@stop

@section('scripts')
	@parent

	<script type="text/javascript">

		//show options on hovering on a gateway
		$(".panel-title").hover( 
			function(){
				$(this).find(".gateway-options").addClass("in");
			},
			function(){
				$(this).find(".gateway-options").removeClass("in");
			}
		);

		//search Gateway Profiles 
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

	    //remove Compute Resource
	    $("body").on("click", ".remove-cr", function(){
			$(this).parent().remove();
		});


		$(".add-cr").click( function(){

			$(".add-compute-resource-block").find("#gatewayId").val( $(this).data("gpid"));
			$(this).after( $(".add-compute-resource-block").html() );
		});

		$("body").on("change", ".cr-select", function(){
			crId = $(this).val();
			//This is done as Jquery creates problems when using period(.) in id or class.
			crId = crId.replace(/\./g,"_");
			$(this).parent().parent().find(".pref-space").html( $("#cr-" + crId).html());
		});

	</script>

@stop