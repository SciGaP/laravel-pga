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

        <h1>Add a User to Admin</h1>

        <form action="{{URL::to('/')}}/admin/add" method="POST" role="form" enctype="multipart/form-data">

            <div class="form-group required">
                <label for="experiment-name" class="control-label">Enter Username</label>
                <input type="text" class="form-control" name="username" id="experiment-name" placeholder="username" autofocus required="required">
            </div>
            <div class="btn-toolbar">
                <input name="add" type="submit" class="btn btn-primary" value="Add User">
                <input name="clear" type="reset" class="btn btn-default" value="Reset values">
            </div>   
        </form>

    </div>
</div>

@stop