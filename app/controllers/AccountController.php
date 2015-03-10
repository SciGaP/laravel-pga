<?php

class AccountController extends BaseController {

	public function createAccountView()
	{
		return View::make('account/create');
	}

	public function createAccountSubmit()
	{
		$rules = array(
				"username" => "required|min:6",
				"password" => "required|min:6",
				"confirm_password" => "required|same:password",
				"email" => "required",
		);

		$validator = Validator::make( Input::all(), $rules);
		if( $validator->fails()){
			$messages = $validator->messages();

			return Redirect::to("create")
										->withInput(Input::except('password', 'password_confirm'))
										->withErrors( $validator);
		}

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email = $_POST['email'];
        $organization = $_POST['organization'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $telephone = $_POST['telephone'];
        $mobile = $_POST['mobile'];
        $im = $_POST['im'];
        $url = $_POST['url'];

        $idStore = new WSISUtilities();

        try
	    {
	        $idStore->connect();
	    }
	    catch (Exception $e)
	    {
	        Utilities::print_error_message('<p>Error connecting to ID store.
	            Please try again later or report a bug using the link in the Help menu</p>' .
	            '<p>' . $e->getMessage() . '</p>');
	    }

        if ($idStore->username_exists($username)) {
        	return Redirect::to("create")
										->withInput(Input::except('password', 'password_confirm'))
										->with("username_exists", true);
		}
        else{
            $idStore->add_user($username, $password, $first_name, $last_name, $email, $organization,
            $address, $country,$telephone, $mobile, $im, $url);
            Utilities::print_success_message('New user created!');

            return View::make('home');
		}
	}

	public function loginView(){
		return View::make('account/login');
	}

	public function loginSubmit(){

        if ( Utilities::form_submitted() ) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            try {
                if ( Utilities::id_matches_db($username, $password)) {
                	
                    Utilities::store_id_in_session($username);
                    Utilities::print_success_message('Login successful! You will be redirected to your home page shortly.');
                	$app_config = Utilities::read_config();
                	Session::put("gateway_id", $app_config["gateway-id"]);
                	//TODO::If this option is not safe, have to find a better method to send credentials to identity server on every connection.
                	Session::put("password", $_POST["password"]);
                	
                	return Redirect::to( "home");

                } else {
                	return Redirect::to("login")->with("invalid-credentials", true); 
                }
            } catch (Exception $ex) {
                return Redirect::to("login")->with("invalid-credentials", true); 
            }
        }

	}

	public function forgotPassword(){
		return View::make("account/forgot-password");
	}

	public function logout(){
		Session::flush();
		return Redirect::to('home');
	}
	
}
