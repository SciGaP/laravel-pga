@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container">

<?php

    if ( isset( $allCRs) )
    {
        if (sizeof($allCRs) == 0)
        {
            Utilities::print_warning_message('No Compute Resources exist at the moment. Please register compute resources and then try again.');
        }
        else
        {
        ?>
            <div class="table-responsive">
                <table class="table">

                    <tr>

                        <th>Name</th>
                        <th>Id</th>
                        <th>Edit</th>
                        <th>View</th>

                    </tr>

            @foreach ($allCRs as $crId => $crName)

	                <tr>
	                    <td>
	                        {{ $crName }}
	                    </td>
	                    <td>
	                        {{ $crId }}
	                    </td>
	                    <td>
	                        <a href="{{URL::to('/')}}/cr/edit?crId={{ $crId }}" title="Edit">
	                            <span class="glyphicon glyphicon-pencil"></span>
	                        </a>
	                    </td>
	                    <td>
	                        <a  class="view-cr" href="#" > <!-- {{URL::to('/')}}/cr/summary?crId={{ $crId }}"> -->
	                            <span class="glyphicon glyphicon-list"></span>
	                        </a>
	                    </td>
	                </tr>
	            @endforeach

	           </table>
			</div>
	<?php

        }

    }
    
?>

</div>

@stop
@section('scripts')
	@parent
	<script type="text/javascript">
    $(".view-cr").click( function(){
    	alert("The functionality to view a Compute Resource is under construction.");
    })
    </script>
@stop