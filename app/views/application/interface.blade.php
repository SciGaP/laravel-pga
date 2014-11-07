@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">

		@if( count( $appInterfaces) )
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
				<h3>Existing Application Interfaces :</h3>
			</div>
			<div class="col-md-6" style="margin-top:3.5%">
				<input type="text" class="col-md-12 filterinput" placeholder="Search by Interface Name" />
			</div>
		</div>
		<div class="panel-group" id="accordion">
		@foreach( $appInterfaces as $index => $interface )
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$index}}">
						{{ $interface->applicationName }}
						</a>
						<div class="pull-right col-md-2">
							<span class="glyphicon glyphicon-pencil edit-app-interface" style="cursor:pointer;" data-toggle="modal" data-target="#edit-app-interface-block" data-interface-id="{{ $interface->applicationInterfaceId }}"></span>
							<span class="glyphicon glyphicon-trash delete-app-interface" style="cursor:pointer;" data-toggle="modal" data-target="#delete-app-interface-block" data-interface-id="{{ $interface->applicationInterfaceId }}"></span>
						</div>
					</h4>
				</div>
				<div id="collapse-{{$index}}" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="app-interface-block">
							<input type="hidden" name="app-interface-id" value="{{ $interface->applicationInterfaceId }}"/>
							<div class="appInterfaceInputs">
								<div class="form-group required">
									<label class="control-label">Application Name</label>
									<input type="text" readonly class="form-control" name="applicationName" required value="{{ $interface->applicationName}}"/>
								</div>
								<div class="form-group">
									<label class="control-label">Application Description</label>
									<input type="text" readonly class="form-control" name="applicationDescription" value="{{ $interface->applicationDesription }}" />
								</div>
								<div class="form-group">
									<label class="control-label">Application Modules</label>
									<div class="app-modules">
									@for( $i=0; $i< count( $interface->applicationModules); $i++ )
										<div class="input-group">
											<select name="applicationModules[]" class="form-control" readonly>
											@foreach( $modules as $index => $module)
												<option value="{{ $module->appModuleId }}" @if( $interface->applicationModules[$i] == $module->appModuleId) selected @endif>{{ $module->appModuleName}}</option>
											@endforeach
											</select>
											<span class="input-group-addon hide remove-app-module" style="cursor:pointer;">x</span>
										</div>
									@endfor
									</div>
									<button type="button" readonly class=" hide btn btn-default add-app-module">Add Application Module</button>
								</div>
								<div class="form-group">
									@if( count( $interface->applicationInputs) )
										@foreach( $interface->applicationInputs as $index => $appInputs)
											@include( 'partials/interface-input-block', array('dataTypes' => $dataTypes, 'appInputs' => $appInputs) )
										@endforeach
									@endif
									<input type="button" readonly class=" hide btn btn-default add-input" value="Add Application Input"/>
									<div class="app-inputs"></div>
								</div>
								<div class="form-group">
									@if( count( $interface->applicationOutputs) )
										@foreach( $interface->applicationOutputs as $index => $appOutputs)
											@include( 'partials/interface-output-block', array('dataTypes' => $dataTypes, 'appInputs' => $appInputs) )
										@endforeach
									@endif
									<input type="button" class=" hide btn btn-default add-output" value="Add Application Output"/>
									<div class="app-outputs"></div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		@endforeach
		</div>
	@endif

		<h3 class="text-center">Create a new Application Interface</h3>



	</div>

	<div class="app-module-block hide">
		<div class="input-group">
			<select name="appModules[]" class="form-control">
				@foreach( $modules as $index=> $module)
				<option value="{{ $module->appModuleId}}">{{ $module->appModuleName }}</option>
				@endforeach
			</select>
			<span class="input-group-addon remove-app-module" style="cursor:pointer;">x</span>
		</div>
	</div>

	<div class="app-input-block hide">
		@include('partials/interface-input-block', array( 'dataTypes' => $dataTypes) )
	</div>

	<div class="app-output-block hide">
		@include('partials/interface-output-block', array( 'dataTypes' => $dataTypes) )
	</div>
</div>

<div class="modal fade" id="edit-app-interface-block" tabindex="-1" role="dialog" aria-labelledby="add-modal" aria-hidden="true">
    <div class="modal-dialog">
		<form action="{{URL::to('/')}}/app/interface-create" method="POST">	
        <div class="modal-content">
	    	<div class="modal-header">
	    		<h3 class="text-center">Edit Application Interface</h3>
	    	</div>
	    	<div class="modal-body row">
				<div class="app-interface-form-content col-md-12">
				</div>
			</div>
			<div class="modal-footer">
	        	<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Update"/>
					<input type="button" class="btn btn-default" data-dismiss="modal" value ="Cancel"/>
				</div>
	        </div>	
        </div>
        </form>
    </div>
</div>

@stop

@section('scripts')
	@parent
    {{ HTML::script('js/interface.js') }}
@stop