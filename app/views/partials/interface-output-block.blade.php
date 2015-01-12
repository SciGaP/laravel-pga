<div class="well">
	<span class="glyphicon glyphicon-trash pull-right remove-output-space"></span>
	<h4>App Output Fields</h4>
	<div class="form-group required">
		<label class="control-label col-md-3">Name</label>
		<div class="col-md-9">
			<input type="text" readonly class="form-control" name="outputName[]" required value="@if( isset( $appOutputs) ){{$appOutputs->name}}@endif"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Value</label>
		<div class="col-md-9">
			<input type="text" readonly class="form-control" name="outputValue[]" value="@if( isset( $appOutputs) ){{$appOutputs->value}}@endif"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Type</label>
		<div class="col-md-9">
			<select class="form-control" name="outputType[]" readonly>
			@foreach( $dataTypes as $index => $dataType)
				<option value="{{ $index }}" @if( isset( $appOutputs) )  @if( $index == $appOutputs->type ) selected @endif @endif>{{ $dataType }}</option>
			@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Data Movement</label><br/>
		<div class="col-md-9">
			<select name="dataMovement[]" class="form-control">
				<option>select</option>
				<option value="1" @if( isset( $appOutputs) ) @if( $appOutputs->dataMovement == 1) selected @endif @endif>True</option>
				<option value="0" @if( isset( $appOutputs) ) @if( $appOutputs->dataMovement == 0) selected @endif @endif>False</option>
			</select>
		</div>
		<!--
		<label class="radio-inline">
			<input type="radio" name="dataMovement[]"  @if( isset( $appOutputs) ) @if( $appOutputs->dataMovement == 1) checked @endif @endif>True
		</label>
		<label class="radio-inline">
			<input type="radio" name="dataMovement[]"  @if( isset( $appOutputs) ) @if( $appOutputs->dataMovement == 0) checked @endif @endif>False
		</label>
		-->
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Is the Input required?</label>
		<div class="col-md-9">
			<select class="form-control" name="isRequired[]" readonly>
				<option value="0" @if( isset( $appOutputs) )  @if( 0 == $appOutputs->isRequired) selected @endif @endif>False</option>
				<option value="1" @if( isset( $appOutputs) ) @if( 1 == $appOutputs->isRequired) selected @endif @endif>True</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Is it required to be added to the command Line?</label>
		<div class="col-md-9">
			<select class="form-control" name="requiredToAddedToCommandLine[]" readonly>
				<option value="0" @if( isset( $appOutputs) )  @if( 0 == $appOutputs->requiredToAddedToCommandLine) selected @endif @endif>False</option>
				<option value="1" @if( isset( $appOutputs) ) @if( 1 == $appOutputs->requiredToAddedToCommandLine) selected @endif @endif>True</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Data Name Location</label>	
		<div class="col-md-9">
			<input type="text" readonly class="form-control" name="dataNameLocation[]" value="@if( isset( $appOutputs) ){{$appOutputs->dataNameLocation}}@endif"/>
		</div>
	</div>
</div>