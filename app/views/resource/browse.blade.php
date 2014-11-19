@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container">

    @if ( isset( $allCRs) )
        @if (sizeof($allCRs) == 0)
            {{ Utilities::print_warning_message('No Compute Resources exist at the moment. Please register compute resources and then try again.') }}
        @else
            <div class="col-md-12">
                <input type="text" class="pull-right filterinput col-md-6" placeholder="Search by Compure Resource Name"/>
            <div class="table-responsive">
                <table class="table">

                    <tr>

                        <th>Name</th>
                        <th>Id</th>
                        <th>Edit</th>
                        <th>View</th>

                    </tr>

            @foreach ($allCRs as $crId => $crName)

	                <tr id="crDetails">
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

        @endif
    @endif

</div>

@stop
@section('scripts')
	@parent
	<script type="text/javascript">
    $(".view-cr").click( function(){
    	alert("The functionality to view a Compute Resource is under construction.");
    });
    $('.filterinput').keyup(function() {
        var value = $(this).val();
        if (value.length > 0) {
             $("table tr").each(function(index) {
                if (index != 0) {

                    $row = $(this);

                    var id = $row.find("td:first").text();
                    id = $.trim( id);
                    id = id.substr( 0, value.length);
                    if (id == value )
                    {
                        $(this).slideDown();
                    }
                    else {
                        $(this).slideUp();
                    }
                }
            });
        } else {
            $("table tr").slideDown();
        }
        return false;
    });
    </script>
@stop