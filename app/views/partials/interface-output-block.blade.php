<div class="well">
	<button type="button" class="hide close remove-output-space">
		<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	</button>
	<h4>App Output Fields</h4>
	<div class="form-group required">
		<label class="control-label">Name</label>
		<input type="text" readonly class="form-control" name="outputName[]" required value="@if( isset( $appOutputs) ){{$appOutputs->name}}@endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Value</label>
		<input type="text" readonly class="form-control" name="outputValue[]" value="@if( isset( $appOutputs) ){{$appOutputs->value}}@endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Type</label>
		<select class="form-control" name="outputType[]" readonly>
		@foreach( $dataTypes as $index => $dataType)
			<option value="{{ $index }}" @if( isset( $appOutputs) )  @if( $index == $appOutputs->type ) selected @endif @endif>{{ $dataType }}</option>
		@endforeach
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">Validity Type</label><br/>
		<select name="outputValidityType[]">
			<option>select</option>
			@foreach( $validityType as $index => $type)
			<option value="{{ $index }}" @if( isset( $appOutputs) ) @if( $appOutputs->validityType == $index) selected @endif @endif>{{ $type }}</option>
			@endforeach
		</select>	
		<!-- 
		Removed Radio button as it doesnt work well with multiple inputs
		<label class="control-label">Validity Type</label><br/>
		@foreach( $validityType as $index => $type)
		<label class="radio-inline"><input type="radio" name="outputValidityType[]" value="{{ $index }}" @if( isset( $appOutputs) ) @if( $appOutputs->validityType == $index) checked @endif @endif>{{ $type }}</label>
		@endforeach
		-->
	</div>
	<div class="form-group">
		<select name="outputCommandLineType[]">
			<option>select</option>
			@foreach( $commandLineType as $index => $clt)
			<option value="{{ $index }}"  @if( isset( $appOutputs) ) @if( $appOutputs->addedToCommandLine == $index) selected @endif @endif>{{ $clt }}</option>
			@endforeach
		</select>
		<!-- 
		Removed Radio button as it doesnt work well with multiple inputs
		<label class="control-label">Command Line Type</label><br/>
		@foreach( $commandLineType as $index => $clt)
		<label class="radio-inline"><input readonly type="radio" name="outputCommandLineType[]" value="{{ $index }}"  @if( isset( $appOutputs) ) @if( $appOutputs->addedToCommandLine == $index) checked @endif @endif>{{ $clt }}</label>
		@endforeach
		-->
	</div>
	<div class="form-group">
		<label class="control-label">Data Movement</label><br/>
		<select name="dataMovement[]">
			<option>select</option>
			<option value="1" @if( isset( $appOutputs) ) @if( $appOutputs->dataMovement == 1) selected @endif @endif>True</option>
			<option value="0" @if( isset( $appOutputs) ) @if( $appOutputs->dataMovement == 0) selected @endif @endif>False</option>
		</select>
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
		<label class="control-label">Data Name Location</label>	
		<input type="text" readonly class="form-control" name="dataNameLocation[]" value="@if( isset( $appOutputs) ){{$appOutputs->dataNameLocation}}@endif"/>
	</div>
</div>