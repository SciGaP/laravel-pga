@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">
		
		<div class="col-md-12">
			<button class="btn btn-default create-app-interface">Create a new Application Deployment</button>
		</div>
		@if( count( $appDeployments) )
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
				<h3>Existing Application Deployments :</h3>
			</div>
			<div class="col-md-6" style="margin-top:3.5%">
				<input type="text" class="col-md-12 filterinput" placeholder="Search by Deployment Name" />
			</div>
		</div>
		<div class="panel-group" id="accordion">
		@foreach( $appDeployments as $index => $deployment )
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed interface-name" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$index}}">
						{{ $deployment->applicationName }}
						</a>
						<div class="pull-right col-md-2 deployment-options fade">
							<span class="glyphicon glyphicon-pencil edit-app-interface" style="cursor:pointer;" data-toggle="modal" data-target="#edit-app-deployment-block" data-interface-id="{{ $deployment->applicationDeploymentId }}"></span>
							<span class="glyphicon glyphicon-trash delete-app-interface" style="cursor:pointer;" data-toggle="modal" data-target="#delete-app-deployment-block" data-interface-id="{{ $deployment->applicationDeploymentId }}"></span>
						</div>
					</h4>
				</div>
				<div id="collapse-{{$index}}" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="app-interface-block">
							@include('partials/deployment-block', array( 'deployment' => $deployment, 'computeResources' => $computeResources, 'modules' => $modules) )
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@endif

	</div>

		<form action="{{URL::to('/')}}/app/deployment-create" method="POST">
			<!-- Application Deployments do not have a name. :(

			<div class="form-group" required>
				<label class="control-label">Application Deployment Name</label>
				<input type="text" class="form-control" name="applicationName" value="Class not saving it anywhere." readonly/>
			</div>

			-->

			<div class="form-group required">
				<label class="control-label">Application Module</label>
				<select name="appModuleId" class="form-control" required>
				@foreach( $modules as $index => $module)
					<option value="{{ $module->appModuleId }}">{{ $module->appModuleName }}</option>	
				@endforeach
				</select>
			</div>
			<div class="form-group required">
				<label class="control-label">Application Compute Host</label>
				<select name="computeHostId" class="form-control" required>
				@foreach( $computeResources as $id => $crName)
					<option value="{{ $id }}">{{ $crName }}</option>	
				@endforeach
				</select>
			</div>
			<div class="form-group required">
				<label class="control-label">Application Executable Path</label>
				<input type="text" class="form-control" name="executablePath" required/>
			</div>
			<div class="form-group required">
				<label class="control-label">Application Parallelism Type</label>
				<select name="parallelism" class="form-control">
				@foreach( $applicationParallelismTypes as $index=>$parallelismType)
					<option value="{{$index}}">{{ $parallelismType }}</option>
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">Application Deployment Description</label>
				<textarea class="form-control" name="appDeploymentDescription"></textarea>
			</div>
			<hr/>
			<div class="form-group">
				<div class="show-load-cmds"></div>
				<button type="button" class="btn btn-default control-label add-load-cmd">Add Module Load Commands</label>
			</div>
			<hr/>
			<div class="form-group">
				<div class="show-lib-prepend-paths">
					<h5>Library Prepend Paths</h5>
				</div>
				<button type="button" class="btn btn-default control-label add-lib-prepend-path">Add a Library Prepend Path</label>
			</div>
			<hr/>
			<div class="form-group">
				<div class="show-lib-append-paths">
					<h5>Library Append Paths</h5>
				</div>
				<button type="button" class="btn btn-default control-label add-lib-append-path">Add a Library Append Path</label>
			</div>
			<hr/>
			<div class="form-group">
				<div class="show-environments">
					Environments
				</div>
				<button type="button" class="btn btn-default control-label add-environment">Add Environment</label>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Save"/>
				<input type="reset" class="btn btn-success" value ="Reset"/>
			</div>
		</form>

	</div>

	<div class="load-cmd-ui hide">
		<input name="moduleLoadCmds[]" type="text" class="form-control" placeholder="Module Load Command"/>
	</div>

	<div class="lib-prepend-path-ui hide">
		<div class="col-md-12 well">
			<input name="libraryPrependPathName[]" type="text" class="col-md-4" placeholder="Name"/>
			<input name="libraryPrependPathValue[]" type="text" class="col-md-8" placeholder="Value"/>
		</div>
	</div>

	<div class="lib-append-path-ui hide">
		<div class="col-md-12 well">
			<input name="libraryAppendPathName[]" type="text" class="col-md-4" placeholder="Name"/>
			<input name="libraryAppendPathValue[]" type="text" class="col-md-8" placeholder="Value"/>
		</div>
	</div>

	<div class="environment-ui hide">
		<div class="col-md-12 well">
			<input name="environmentName[]" type="text" class="col-md-4" placeholder="Name"/>
			<input name="environmentValue[]" type="text" class="col-md-8" placeholder="Value"/>
		</div>
	</div>

</div>

@stop

@section('scripts')
	@parent
    {{ HTML::script('js/deployment.js') }}
@stop