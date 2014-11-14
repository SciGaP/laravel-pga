<div class="well">
	<button type="button" class="hide close remove-output-space">
		<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	</button>
	<h4>App Output Fields</h4>
	<div class="form-group required">
		<label class="control-label">Name</label>
		<input type="text" readonly class="form-control" name="outputName[]" required value="@if( isset( $appOutputs) ) {{ $appOutputs->name }} @endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Value</label>
		<input type="text" readonly class="form-control" name="outputValue[]" value="@if( isset( $appOutputs) ) {{ $appOutputs->value }} @endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Type</label>
		<select class="form-control" name="outputType[]" readonly>
		@foreach( $dataTypes as $index => $dataType)
			<option value="{{ $index }}" @if( isset( $appOutputs) )  @if( $index == $appOutputs->type ) selected @endif @endif>{{ $dataType }}</option>
		@endforeach
		</select>
	</div>
</div>