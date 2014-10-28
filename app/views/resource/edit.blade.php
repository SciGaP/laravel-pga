@extends('layout.basic')

@section('page-header')
    @parent
    {{ HTML::style('css/style.css') }}
@stop

@section('content')

<div class="container">
	<div class="col-md-offset-2 col-md-8">

		<div class="well">
			<h4>Compute Resource : {{ $computeResource->hostName }}</h4>
		</div>

		<ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
		  <li class="active"><a href="#tab-desc" data-toggle="tab">Description</a></li>
		  <li><a href="#tab-queues" data-toggle="tab">Queues</a></a></li>
		  <li><a href="#tab-filesystem" data-toggle="tab">FileSystem</a></li>
		  <li><a href="#tab-jobSubmission" data-toggle="tab">Job Submission Interfaces</a></li>
		  <li><a href="#tab-dataMovement" data-toggle="tab">Data Movement Interfaces</a></li>
		</ul>

		<div class="tab-content">
        	
        	<div class="tab-pane active" id="tab-desc">

				<form role="form" method="POST" action="{{ URL::to('/') }}/cr/edit">
					<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
					<input type="hidden" name="cr-edit" value="resDesc"/>
					<div class="form-group required">
						<label class="control-label">Host Name</label>
						<input class="form-control hostName" value="{{ $computeResource->hostName }}" maxlength="30" name="hostname" required="required"/>
					</div>
					<div class="form-group">
						<label class="control-label">Host Aliases</label>
						@if( count(  $computeResource->hostAliases) )
							@foreach( $computeResource->hostAliases as $hostAlias )
								<input class="form-control" value="{{$hostAlias}}" maxlength="30" name="hostaliases[]"/>
							@endforeach
						@else
							<input class="form-control" value="" maxlength="30" name="hostaliases[]"/>
						@endif
						<button type="button" class="btn btn-sm btn-default add-alias">Add Aliases</button>
					</div>
					<div class="form-group">
						<label class="control-label">IP Addresses</label>
						@if( count( $computeResource->ipAddresses))
							@foreach( $computeResource->ipAddresses as $ip )
								<input class="form-control" value="{{ $ip }}" maxlength="30" name="ips[]"/>
							@endforeach
						@else
							<input class="form-control" value="" maxlength="30" name="ips[]"/>
						@endif
						<button type="button" class="btn btn-sm btn-default add-ip">Add IP Addresses</button>
					</div>
					<div class="form-group">
						<label class="control-label">Resource Description</label>
						<textarea class="form-control" maxlength="255" name="description">{{ $computeResource->resourceDescription }}</textarea>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="step1" value="Save changes"/>
					</div>
				</form>

			</div>

        	<div class="tab-pane" id="tab-queues">

        		@if( is_array( $computeResource->batchQueues) )
					<h3>Existing Queues :</h3>
					<div class="panel-group" id="accordion">
					@foreach( $computeResource->batchQueues as $index => $queue)
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$index}}">
									Queue : {{ $queue->queueName }}
									</a>
								</h4>
							</div>
							<div id="collapse-{{$index}}" class="panel-collapse collapse">
								<div class="panel-body">
									<form role="form" method="POST" action="{{ URL::to('/')}}/cr/edit">
										<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
										<div class="queue">
											<div class="form-group">
												<input type="hidden" name="cr-edit" value="queue"/>
												<label class="control-label">Queue Name</label>
												<input class="form-control" value="{{ $queue->queueName }}" maxlength="30" name="qname" placeholder="Queue Name"/>
												<label class="control-label">Queue Description</label>
												<input class="form-control" value="{{ $queue->queueDescription }}" maxlength="30" name="qdesc" placeholder="Queue Description"/>
												<label class="control-label">Queue Max Run Time</label>
												<input class="form-control" value="{{ $queue->maxRunTime }}" maxlength="30" name="qmaxruntime" placeholder="Queue Max Run Time"/>
												<label class="control-label">Queue Max Nodes</label>
												<input class="form-control" value="{{ $queue->maxNodes }}" maxlength="30" name="qmaxnodes" placeholder="Queue Max Nodes"/>
												<label class="control-label">Queue Max Processors</label>
												<input class="form-control" value="{{ $queue->maxProcessors }}" maxlength="30" name="qmaxprocessors" placeholder="Queue Max Processors"/>
												<label class="control-label">Max Jobs in Queue</label>
												<input class="form-control" value="{{ $queue->maxJobsInQueue }}" maxlength="30" name="qmaxjobsinqueue" placeholder="Max Jobs In Queue"/>
						          			</div>
						          			<div class="form-group">
												<input type="submit" class="btn btn-primary" name="step1" value="Save Changes"/>
											</div>
						          		</div>
						      		</form>
						      	</div>
						    </div>
						</div>
			  		@endforeach
			  		</div>
			  	@endif
				<div class="queue-block hide">
					<form role="form" method="POST" action="{{ URL::to('/')}}/cr/edit">
						<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
						<div class="queue">
							<div class="form-group">
								<input type="hidden" name="cr-edit" value="queue"/>
								<label class="control-label">Queue Name</label>
								<input class="form-control" value="" maxlength="30" name="qname" placeholder="Queue Name"/>
								<label class="control-label">Queue Description</label>
								<input class="form-control" maxlength="30" name="qdesc" placeholder="Queue Description"/>
								<label class="control-label">Queue Max Run Time</label>
								<input class="form-control" maxlength="30" name="qmaxruntime" placeholder="Queue Max Run Time"/>
								<label class="control-label">Queue Max Nodes</label>
								<input class="form-control" maxlength="30" name="qmaxnodes" placeholder="Queue Max Nodes"/>
								<label class="control-label">Queue Max Processors</label>
								<input class="form-control" maxlength="30" name="qmaxprocessors" placeholder="Queue Max Processors"/>
								<label class="control-label">Max Jobs in Queue</label>
								<input class="form-control" maxlength="30" name="qmaxjobsinqueue" placeholder="Max Jobs In Queue"/>
		          			</div>
		          			<div class="form-group">
								<input type="submit" class="btn  btn-primary" name="step1" value="Create"/>
								<input type="reset" class="btn  btn-success" value="Reset"/>
							</div>
		          		</div>
		      		</form>
		      	</div>
				<div class="form-group well">
					<button type="button" class="btn btn-sm btn-default add-queue">Add a Queue</button>
				</div>

			</div>

        	<div class="tab-pane" id="tab-filesystem">

        		<form role="form" method="POST" action="{{URL::to('/')}}/cr/edit">
					<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
					<input type="hidden" name="cr-edit" value="fileSystems"/>
					<div class="form-group">
						<h3>FileSystem</h3>
						@foreach( $fileSystems as $index => $fileSystem)
							<label class="control-label">{{ $fileSystem }}</label>
							<input class="form-control" name="fileSystems[{{ $index }}]" placeholder="{{ $fileSystem }}" value="@if( isset( $computeResource->fileSystems[ $index]) ){{ $computeResource->fileSystems[ $index] }} @endif"/>
						@endforeach
						</select>
					</div>
					<div class="form-group">
						<button class="btn btn-prim">Update</button>
					</div>
				</form>

			</div>

        	<div class="tab-pane" id="tab-jobSubmission">

        		@if( count( $jobSubmissionInterfaces ) )
        			<div class="job-edit-info">
        			@foreach( $jobSubmissionInterfaces as $index => $JSI )

        				<div class="job-protocol-block">

							<form role="form" method="POST" action="{{ URL::to('/') }}/cr/edit">
								<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
								<input type="hidden" name="cr-edit" value="edit-jsp"/>
								<input type="hidden" name="jsiId" value="{{ $JSI->jobSubmissionInterfaceId }}"/>
								<?php $selectedJspIndex = $computeResource->jobSubmissionInterfaces[ $index]->jobSubmissionProtocol; ?>

        						<h4>Job Submission Protocol : {{ $jobSubmissionProtocols[ $selectedJspIndex] }}
									<button type='button' class='close'>
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</h4>
								<div class="form-group">
								</div>
								@if( $selectedJspIndex == $jobSubmissionProtocolsObject::LOCAL)
									<h4> Local Data </h4>
								@elseif( $selectedJspIndex == $jobSubmissionProtocolsObject::SSH)

									<div class="form-group">		
										<label class="control-label">Select Security Protocol</label>
										<select name="securityProtocol">
											<option></option>
										@foreach( $securityProtocols as $index => $sp)
											<option value="{{ $index }}" @if( $JSI->securityProtocol == $index ) selected @endif>{{ $sp }}</option>
										@endforeach
										</select>
									</div>

									<div class="form-group addedScpValue">
										<label class="control-label">Alternate SSH Host Name</label>
						                <input class='form-control' name='alternativeSSHHostName' value="{{ $JSI->alternativeSSHHostName}}"/>
						            </div>
						            <div class="form-group addedScpValue">
										<label class="control-label">SSH Port</label>
						                <input class='form-control' name='sshPort' value="{{ $JSI->sshPort }}"/>
						            </div>

									<div class="form-group">
										<div class="select-resource-manager-type">
											<h4>Select resource manager type</h4>
											<select name="resourceJobManagerType" class="form-control selected-resource-manager">
												<option></option>
											@foreach( $resourceJobManagerTypes as $index => $rJmT)
												<option value="{{ $index }}" @if( $JSI->resourceJobManager->resourceJobManagerType == $index ) selected @endif >{{ $rJmT }}</option>
											@endforeach
											</select>
										</div>
									</div>

								@endif
								<div class="form-group">
									<button type="submit" class="btn">Update</button>
								</div>
							</form>

						</div>
        			@endforeach
        			</div>
        		@endif
        				<div class="select-job-protocol hide">
							<form role="form" method="POST" action="{{ URL::to('/') }}/cr/edit">
								<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
								<input type="hidden" name="cr-edit" value="edit-jsp"/>
								<h4>
									Job Submission Protocol:
									<button type='button' class='close'>
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</h4>
								<div class="form-group">

									<select name="jobSubmissionProtocol" class="form-control selected-job-protocol">
								  		<option></option>
									@foreach( $jobSubmissionProtocols as $index => $jobSubmissionProtocol)
										<option value="{{ $index }}">{{ $jobSubmissionProtocol }}</option>
									@endforeach
									</select>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary jspSubmit hide">Add Job Submission Protocol</button>
								</div>
							</form>
						</div>


        		<div class="form-group">
					<div class="job-submission-info row hide"></div>
					<button type="button" class="btn btn-sm btn-default add-job-submission">Add a new Job Submission Interface</button>
				</div>

				<div class="select-job-protocol hide">
					<form role="form" method="POST" action="{{ URL::to('/') }}/cr/edit">
						<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
						<input type="hidden" name="cr-edit" value="edit-jsp"/>
						<h4>
							Select the Job Submission Protocol
							<button type='button' class='close' data-dismiss='alert'>
								<span class="glyphicon glyphicon-trash"></span>
							</button>
						</h4>
						<div class="form-group">

							<select name="jobSubmissionProtocol" class="form-control selected-job-protocol">
						  		<option></option>
							@foreach( $jobSubmissionProtocols as $index => $jobSubmissionProtocol)
								<option value="{{ $index }}">{{ $jobSubmissionProtocol }}</option>
							@endforeach
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary jspSubmit hide">Add Job Submission Protocol</button>
						</div>
					</form>
				</div>

				<div class="select-job-protocol hide">
					<form role="form" method="POST" action="{{ URL::to('/') }}/cr/edit">
						<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
						<input type="hidden" name="cr-edit" value="jsp"/>
						<h4>
							Select the Job Submission Protocol
							<button type='button' class='close' data-dismiss='alert'>
								<span class="glyphicon glyphicon-trash"></span>
							</button>
						</h4>
						<div class="form-group">

							<select name="jobSubmissionProtocol" class="form-control selected-job-protocol">
						  		<option></option>
							@foreach( $jobSubmissionProtocols as $index => $jobSubmissionProtocol)
								<option value="{{ $index }}">{{ $jobSubmissionProtocol }}</option>
							@endforeach
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary jspSubmit hide">Add Job Submission Protocol</button>
						</div>
					</form>
				</div>

        	</div>

        	<div class="tab-pane" id="tab-dataMovement">

				<div class="form-group">
					<div class="data-movement-info row hide"></div>
					<button type="button" class="btn btn-sm btn-default add-data-movement">Add a new Data Movement Interface</button>
				</div>

        		<div class="select-data-movement hide">

					<form role="form" method="POST" action="{{ URL::to('/') }}/cr/edit">
						<input type="hidden" name="crId" value="{{Input::get('crId') }}"/>
						<input type="hidden" name="cr-edit" value="dmp"/>
						<h4>
							Select the Data Movement Protocol
							<button type='button' class='close' data-dismiss='alert'>
								<span class="glyphicon glyphicon-trash"></span>
							</button>
						</h4>

						<select name="dataMovementProtocol" class="form-control selected-data-movement-protocol">
					  		<option></option>
						@foreach( $dataMovementProtocols as $index => $dmp)
							<option value="{{ $index }}">{{ $dmp }}</option>
						@endforeach
						</select>

						<div class="form-group">
							<button type="submit" class="btn btn-primary dmpSubmit hide">Add Data Movement Protocol</button>
						</div>

					</form>

				</div>

        	</div>


		</div>


		<div class="resource-manager-block hide">
			<div class="select-resource-manager-type">
				<h4>Select resource manager type</h4>
				<select name="resourceJobManagerType" class="form-control selected-resource-manager">
					<option></option>
				@foreach( $resourceJobManagerTypes as $index => $rJmT)
					<option value="{{ $index }}">{{ $rJmT }}</option>
				@endforeach
				</select>
			</div>
		</div>

		<div class="ssh-block hide">
			<div class="form-group">		
				<label class="control-label">Select Security Protocol</label>
				<select name="securityProtocol">
					<option></option>
				@foreach( $securityProtocols as $index => $sp)
					<option value="{{ $index }}">{{ $sp }}</option>
				@endforeach
				</select>
			</div>

			<div class="form-group addedScpValue hide">
				<label class="control-label">Alternate SSH Host Name</label>
                <input class='form-control' name='alternativeSSHHostName'/>
            </div>
            <div class="form-group addedScpValue hide">
				<label class="control-label">SSH Port</label>
                <input class='form-control' name='sshPort'/>
            </div>
		</div>

		<div class="cloud-block hide">
			<div class="form-group">
				<label class="control-label">Node Id</label>
				<input class="form-control" name="nodeId" placeholder="nodId"/>
			</div>
			<div class="form-group">
				<label class="control-label">Node Id</label>
				<input class="form-control" name="nodeId" placeholder="nodId"/>
			</div>
			<div class="form-group">
				<label class="control-label">Executable Type</label>
				<input class="form-control" name="nodeId" placeholder="executableType"/>
			</div>
			<div class="form-group">
			<label class="control-label">Select Provider Name</label>
			<select class="form-control">
				<option name="EC2">EC2</option>
				<option name="AWSEC2">AWEC2</option>
				<option name="RACKSPACE">RACKSPACE</option>
			</select>
			</div>
		</div>

		<div class="dm-gridftp hide">
			<div class="form-group required">
				<label class="control-label">Grid FTP End Points</label>
				<input class="form-control" maxlength="30" name="gridFTPEndPoints[]" required="required"/>
				<button type="button" class="btn btn-sm btn-default add-gridFTPEndPoint">Add More Grid FTP End Points</button>
			</div>
		</div>

		<!-- 
		<div class="form-group">
			<input type="submit" class="btn  btn-primary" name="step2" value="Continue"/>
			<input type="reset" class="btn  btn-success" value="Reset"/>
		</div>

		--> 
	</div>
</div>

@stop

@section('scripts')
	@parent
    {{ HTML::script('js/script.js') }}
@stop