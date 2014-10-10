<?php

class AccountController extends BaseController {

	public function createAccountView()
	{
		return View::make('account/create');
	}

	public function createAccountSubmit()
	{
		if (Utilities::form_submitted() 
				&& isset($_POST['username']) 
				&& isset($_POST['password']) 
				&& isset($_POST['confirm_password']) ) 
		{
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

	        /* this part of code below between '///////' needs to go global instead of being 
	        called in every function.
	        */

	        ///////
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
		    ////////


	        if ($idStore->username_exists($username)) {
	            print_error_message('The username you entered is already in use. Please select another.');
	        } else if (strlen($username) < 3) {
	            print_error_message('Username should be more than three characters long!');
	        } else if ($password != $confirm_password) {
	            print_error_message('The passwords that you entered do not match!');
	        }elseif(!isset($first_name)){
	            print_error_message('First name is required.');
	        }elseif(!isset($last_name)){
	            print_error_message('Last name is required.');
	        }elseif(!isset($email)){
	            print_error_message('Email address is required.');
	        }else{
	            $idStore->add_user($username, $password, $first_name, $last_name, $email, $organization,
	            $address, $country,$telephone, $mobile, $im, $url);
	            Utilities::print_success_message('New user created!');

	            return View::make('home');

			}

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
                	
                	return Redirect::to( "home");

                } else {
                    print_error_message('Invalid username or password. Please try again.');
                }
            } catch (Exception $ex) {
            	print_r( $ex); exit;
                print_error_message('Invalid username or password. Please try again.');
            }
        }

	}

	public function logout(){
		Session::flush();
		return Redirect::to('home');
	}
}
