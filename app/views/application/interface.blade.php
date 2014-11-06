@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">

		<h3 class="text-center">Create a new Application Interface</h3>

		<form action="{{URL::to('/')}}/app/interface-create" method="POST">
			<div class="form-group required">
				<label class="control-label">Application Name</label>
				<input type="text" class="form-control" name="applicationName" required/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Description</label>
				<input type="text" class="form-control" name="applicationDescription"/>
			</div>
			<div class="form-group">
				<label class="control-label">Application Module</label>
				<select name="appModuleId" class="form-control">
				@foreach( $modules as $index => $module)
					<option value="{{ $module->appModuleId }}">{{ $module->appModuleName }}</option>	
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<input type="button" class="btn btn-default add-input" value="Add Application Input"/>
				<div class="app-inputs"></div>
			</div>
			<div class="form-group">
				<input type="button" class="btn btn-default add-output" value="Add Application Output"/>
				<div class="app-outputs"></div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Save"/>
				<input type="reset" class="btn btn-success" value ="Reset"/>
			</div>
		</form>

	</div>

	<div class="app-input-block hide">
		<div class="well">
			<button type="button" class="close remove-input-space"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4>App Input Fields</h4>
			<div class="form-group required">
				<label class="control-label">Name</label>
				<input type="text" class="form-control" name="inputName[]" required/>
			</div>
			<div class="form-group">
				<label class="control-label">Value</label>
				<input type="text" class="form-control" name="inputValue[]"/>
			</div>
			<div class="form-group">
				<label class="control-label">Type</label>
				<select class="form-control" name="inputType[]">
				@foreach( $dataTypes as $index => $dataType)
					<option value="{{ $index }}">{{ $dataType }}</option>
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">Application Argument</label>
				<input type="text" class="form-control" name="applicationArgument[]"/>
			</div>
			<div class="form-group">
				<label class="control-label">Standard Input</label>
				<select class="form-control" name="standardInput[]">
					<option value="0">False</option>
					<option value="1">True</option>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">User Friendly Description</label>
				<textarea class="form-control" name="userFriendlyDescription[]"></textarea>
			</div>
			<div class="form-group">
				<label class="control-label">Meta Data</label>
				<textarea class="form-control" name="metaData[]"></textarea>
			</div>
		</div>
	</div>

	<div class="app-output-block hide">
		<div class="well">
			<button type="button" class="close remove-output-space"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4>App Output Fields</h4>
			<div class="form-group required">
				<label class="control-label">Name</label>
				<input type="text" class="form-control" name="outputName[]" required/>
			</div>
			<div class="form-group required">
				<label class="control-label">Value</label>
				<input type="text" class="form-control" name="outputValue[]"/>
			</div>
			<div class="form-group">
				<label class="control-label">Type</label>
				<select class="form-control" name="outputType[]">
				@foreach( $dataTypes as $index => $dataType)
					<option value="{{ $index }}">{{ $dataType }}</option>
				@endforeach
				</select>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
	@parent
    {{ HTML::script('js/interface.js') }}
@stop