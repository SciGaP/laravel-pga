@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">

		<h3 class="text-center">Create a new Application Module</h3>

		<form action="{{URL::to('/')}}/app/module-create" method="POST">
			<div class="form-group required">
				<label class="control-label">Application Module Name</label>
				<input type="text" class="form-control" name="appModuleName" required/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Module Version</label>
				<input type="text" class="form-control" name="appModuleVersion"/>
			</div>
			<div class="form-group">
				<label class="control-label">Description</label>
				<textarea class="form-control" name="appModuleDescription"></textarea>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Save"/>
				<input type="reset" class="btn btn-success" value ="Reset"/>
			</div>
		</form>

	</div>
</div>

@stop