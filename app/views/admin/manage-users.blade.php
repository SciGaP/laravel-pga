@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')
<div class="container">
    <div class="col-md-12">
        @if( Session::has("message"))
            <div class="row">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{ Session::get("message") }}
                </div>
            </div>
            {{ Session::forget("message") }}
        @endif

        <h1>Users</h1>

        <table class="table table-striped table-condensed">
            <tr>
                <th>Username</th>
                <th>Role</th>
            </tr>
            @foreach( $users as $user)
            <tr>
                <td>{{ $user }}</td>
                <td><button class="button btn btn-default" type="button">Check Role</button></td>
            </tr>
            @endforeach
        </table>

    </div>
</div>

@stop