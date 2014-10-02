@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<form class="cr/create">
	<div class="form-group required">
		<label class="control-label">Host Name</label>
		<input class="form-control" maxlength="30" name="hostname" required="required"/>
	</div>
	<div class="form-group required">
		<label class="control-label">Host Aliases</label>
		<input class="form-control" maxlength="30" name="hostaliases[]" required="required"/>
	</div>
</form>
@stop