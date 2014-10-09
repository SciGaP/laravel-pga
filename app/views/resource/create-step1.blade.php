@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<h3>Create a Resource</h3>
		<form role="form" method="POST" action="{{ URL::to('/') }}/cr/create">
			<div class="form-group required">
				<label class="control-label">Host Name</label>
				<input class="form-control" maxlength="30" name="hostname" required="required"/>
			</div>
			<div class="form-group required">
				<label class="control-label">Host Aliases</label>
				<input class="form-control" maxlength="30" name="hostaliases[]" required="required"/>
				<button type="button" class="btn btn-sm btn-default add-alias">Add More Aliases</button>
			</div>
			<div class="form-group required">
				<label class="control-label">IP Addresses</label>
				<input class="form-control" maxlength="30" name="ips[]" required="required"/>
				<button type="button" class="btn btn-sm btn-default add-ip">Add More IP Addresses</button>
			</div>
			<div class="form-group required">
				<label class="control-label">Resource Description</label>
				<textarea class="form-control" maxlength="255" name="description" required="required"></textarea>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-lg btn-primary" name="step1" value="Continue"/>
				<input type="reset" class="btn btn-lg btn-success" value="Reset"/>
			</div>
		</form>
	</div>
</div>

@stop

@section('scripts')
	@parent
	<script>
		$(document).ready( function(){
			$(".add-alias").click( function(){
				$(this).before( '<input class="form-control" maxlength="30" name="hostaliases[]"/>');
			});

			$(".add-ip").click( function(){
				$(this).before( '<input class="form-control" maxlength="30" name="ips[]"/>');
			})
		});
	</script>
@stop