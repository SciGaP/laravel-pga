@if( isset( $interface) )
	<input type="hidden" name="app-interface-id" value="{{$interface->applicationInterfaceId}}"/>
@endif
<div class="appInterfaceInputs">
	<div class="form-group required">
		<label class="control-label">Application Name</label>
		<input type="text" readonly class="form-control" name="applicationName" required value="@if( isset( $interface) ){{ $interface->applicationName}} @endif"/>
	</div>
	<div class="form-group">
		<label class="control-label">Application Description</label>
		<input type="text" readonly class="form-control" name="applicationDescription" value="@if( isset( $interface) ){{ $interface->applicationDescription }} @endif" />
	</div>
	<div class="form-group">
		<label class="control-label">Application Modules</label>
		<div class="app-modules">
		@if( isset( $interface))
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
		@endif
		</div>
		<button type="button" readonly class=" hide btn btn-default add-app-module">Add Application Module</button>
	</div>
	<div class="form-group">
		@if( isset( $interface))
		@if( count( $interface->applicationInputs) )
			@foreach( $interface->applicationInputs as $index => $appInputs)
				@include( 'partials/interface-input-block', array('dataTypes' => $dataTypes, 'appInputs' => $appInputs) )
			@endforeach
		@endif
		@endif
		<button type="button" readonly class=" hide btn btn-default add-input">Add Application Input</button>
		<div class="app-inputs"></div>
	</div>
	<div class="form-group">
		@if( isset( $interface) )
		@if( count( $interface->applicationOutputs) )
			@foreach( $interface->applicationOutputs as $index => $appOutputs)
				@include( 'partials/interface-output-block', array('dataTypes' => $dataTypes, 'appInputs' => $appInputs) )
			@endforeach
		@endif
		@endif
		<button type="button" class=" hide btn btn-default add-output">Add Application Output</button>
		<div class="app-outputs"></div>
	</div>
</div>