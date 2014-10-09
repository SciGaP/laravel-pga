@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<h3>Add Resource Data</h3>
		<form role="form" method="POST" action="{{ URL::to('/') }}/cr/create">
			<div class="form-group required">
				<button type="button" class="btn btn-sm btn-default add-queue">Add a Queue</button>
			</div>
			<hr/>
			<div class="form-group required">
				<label class="control-label">FileSystem</label>
				<div class="form-group required">
					<label class="control-label">Home</label>
					<input class="form-control" maxlength="255" name="filesystem-home"/>
				</div>
				<div class="form-group required">
					<label class="control-label">Work</label>
					<input class="form-control" maxlength="255" name="filesystem-work"/>
				</div>
				<div class="form-group required">
					<label class="control-label">Localtmp</label>
					<input class="form-control" maxlength="255" name="filesystem-localtmp"/>
				</div>
				<div class="form-group required">
					<label class="control-label">Scratch</label>
					<input class="form-control" maxlength="255" name="filesystem-scratch"/>
				</div>
				<div class="form-group required">
					<label class="control-label">Archive</label>
					<input class="form-control" maxlength="255" name="filesystem-archive"/>
				</div>
			</div>
			<hr/>
		</form>
	</div>
</div>

@stop

@section('scripts')
	@parent
	<script>
		$(document).ready( function(){
			$(".add-queue").click( function(){
				$(this).before( '\
						Queue - \
  						<input class="form-control" maxlength="30" name="qname[]" placeholder="Queue Name"/>\
  						<input class="form-control" maxlength="30" name="qdesc[]" placeholder="Queue Description"/>\
  						<input class="form-control" maxlength="30" name="qmaxruntime[]" placeholder="Queue Max Run Time"/>\
  						<input class="form-control" maxlength="30" name="qmaxnodes[]" placeholder="Queue Max Nodes"/>\
  						<input class="form-control" maxlength="30" name="qmaxprocessors[]" placeholder="Queue Max Processors"/>\
  						<input class="form-control" maxlength="30" name="qmaxjobsinqueue[]" placeholder="Max JObs In Queue"/>\
  						<hr/> \
  						');
			});


			$(".add-ip").click( function(){
				$(this).before( '<input class="form-control" maxlength="30" name="ips[]"/>');
			})
		});
	</script>
@stop