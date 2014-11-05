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
			<div class="form-group" required>
				<label class="control-label">Application Deployment Name</label>
				<input type="text" class="form-control" name="applicationName" value="Class not saving it anywhere." readonly/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Module</label>
				<input type="text" class="form-control" name="applicationName" value="Has to be Set up" readonly/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Compute Host</label>
				<input type="text" class="form-control" name="applicationName" value="Has to be Set up" readonly/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Deployment Description</label>
				<input type="text" class="form-control" name="appDeploymentDescription"/>
			</div>
			<div class="form-group" required>
				<label class="control-label">Application Executable Path</label>
				<input type="text" class="form-control" name="applicationName" required/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Parallelism Type</label>
				<select name="parallelism" class="form-control">
				@foreach( $applicationParallelismTypes as $index=>$parallelismType)
					<option value="{{$index}}">{{ $parallelismType }}</option>
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<div class="show-load-cmds"></div>
				<button type="button" class="btn btn-defauly control-label add-load-cmd">Add Module Load Commands</label>
			</div>
			<div class="form-group">
				<div class="add-lib-prepend-paths">
					
				</div>
				<button type="button" class="btn btn-defauly control-label">Add Library Prepend Paths</label>
			</div>
			<div class="form-group">
				<div class="add-lib-append-paths"></div>
				<button type="button" class="btn btn-defauly control-label">Add Library Append Paths</label>
			</div>
			<div class="form-group">
				<div class="add-environment"></div>
				<button type="button" class="btn btn-defauly control-label">Add Environment</label>
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

	<div class="library-prepend-path-ui hide">
		<input name="libraryPrependPathName[]" type="text" class="form-control" placeholder=
</div>

@stop

@section('scripts')
	@parent
    {{ HTML::script('js/deployment.js') }}
@stop