@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container" style="width: 500px">
    <div class="page-header">
        <h3>Create New Account
            <small>
                <small> (Already registered? <a href="login">Log in</a>)</small>
            </small>
        </h3>
    </div>

    <form action="create" method="post" role="form">
        <div class="form-group required"><label class="control-label">Username</label>

            <div><input class="form-control" id="username" minlength="3" maxlength="30" name="username"
                        placeholder="Username" required="required" title="" type="text"/></div>
        </div>
        <div class="form-group required"><label class="control-label">Password</label>

            <div><input class="form-control" id="password" name="password" placeholder="Password"
                        required="required" title="" type="password"/></div>
        </div>
        <div class="form-group required"><label class="control-label">Password (again)</label>

            <div><input class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Password (again)" required="required" title="" type="password"/>
            </div>
        </div>
        <div class="form-group required"><label class="control-label">E-mail</label>

            <div><input class="form-control" id="email" name="email" placeholder="E-mail"
                        required="required" title="" type="email"/></div>
        </div>
        <div class="form-group required"><label class="control-label">First Name</label>

            <div><input class="form-control" id="first_name" maxlength="30" name="first_name"
                        placeholder="First Name" required="required" title="" type="text"/></div>
        </div>
        <div class="form-group required"><label class="control-label">Last Name</label>

            <div><input class="form-control" id="last_name" maxlength="30" name="last_name"
                        placeholder="Last Name" required="required" title="" type="text"/></div>
        </div>
        <div class="form-group"><label class="control-label">Organization</label>

            <div><input class="form-control" id="organization" name="organization"
                        placeholder="Organization" title="" type="text"/>
            </div>
        </div>
        <div class="form-group"><label class="control-label">Address</label>

            <div><input class="form-control" id="address" name="address"
                        placeholder="Address" title="" type="text"/>
            </div>
        </div>
        <div class="form-group"><label class="control-label">Country</label>

            <div><input class="form-control" id="country" name="country"
                        placeholder="Country" title="" type="text"/>
            </div>
        </div>
        <div class="form-group"><label class="control-label">Telephone</label>

            <div><input class="form-control" id="telephone" name="telephone"
                        placeholder="Telephone" title="" type="tel"/>
            </div>
        </div>
        <div class="form-group"><label class="control-label">Mobile</label>

            <div><input class="form-control" id="mobile" name="mobile"
                        placeholder="Mobile" title="" type="tel"/>
            </div>
        </div>
        <div class="form-group"><label class="control-label">IM</label>

            <div><input class="form-control" id="im" name="im"
                        placeholder="IM" title="" type="text"/>
            </div>
        </div>
        <div class="form-group"><label class="control-label">URL</label>

            <div><input class="form-control" id="url" name="url"
                        placeholder="URL" title="" type="text"/>
            </div>
        </div>
        <br/>
        <input name="Submit" type="submit" class="btn btn-primary btn-block" value="Create">
    </form>

    <style media="screen" type="text/css">
        .form-group.required .control-label:after {
            content: " *";
            color: red;
        }
    </style>
    <br/><br/><br/>
</div>
</body>

@stop

