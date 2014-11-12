<div class="well">
	<button type="button" class="hide close remove-input-space"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4>App Input Fields</h4>
	<div class="form-group required">
		<label class="control-label">Name</label>
		<input type="text" readonly class="form-control" name="inputName[]" required value="@if( isset( $appInputs) ){{$appInputs->name}}@endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Value</label>
		<input type="text" readonly class="form-control" name="inputValue[]" value="@if( isset( $appInputs)){{$appInputs->value}}@endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Type</label>
		<select class="form-control" name="inputType[]" readonly>
		@foreach( $dataTypes as $index => $dataType)
			<option value="{{ $index }}" @if( isset( $appInputs) ) @if( $index == $appInputs->type) selected @endif @endif>{{ $dataType }}</option>
		@endforeach
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">Application Argument</label>
		<input type="text" readonly class="form-control" name="applicationArgument[]" value="@if( isset( $appInputs) ){{$appInputs->applicationArgument }}@endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Standard Input</label>
		<select class="form-control" name="standardInput[]" readonly>
			<option value="0" @if( isset( $appInputs) )  @if( 0 == $appInputs->standardInput) selected @endif @endif>False</option>
			<option value="1" @if( isset( $appInputs) ) @if( 1 == $appInputs->standardInput) selected @endif @endif>True</option>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">User Friendly Description</label>
		<textarea readonly class="form-control" name="userFriendlyDescription[]">@if( isset( $appInputs) ){{$appInputs->userFriendlyDescription}}@endif</textarea>
	</div>
	<div class="form-group">
		<label class="control-label">Meta Data</label>
		<textarea readonly class="form-control" name="metaData[]">@if( isset( $appInputs) ){{$appInputs->metaData}}@endif</textarea>
	</div>
</div>