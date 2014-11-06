@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">

		<h3 class="text-center">Create a new Application Deployment</h3>

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