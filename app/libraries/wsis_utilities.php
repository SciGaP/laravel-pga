<?php

require_once 'id_utilities.php';
require_once 'WSISClient.php';

//$GLOBALS['WSIS_ROOT'] = './lib/WSIS/';
//require_once $GLOBALS['WSIS_ROOT'] . 'WSISClient.php';

/**
 * Utilities for ID management with a WSO2 IS 4.6.0
 */

class WSISUtilities implements IdUtilities{

    const WSIS_CONFIG_PATH = "wsis_config.ini";

    /**
     * wso2 IS client
     * 
     * @var WSISClient
     * @access private
     */
    private $wsis_client;

    /**
     * Connect to the identity store.
     * @return mixed|void
     */
    public function connect() { 
   
        $wsis_config = null;

        try {
            if (file_exists( app_path() . "/libraries/wsis_config.ini" ) ) {

                try
                {
                    $wsis_config = parse_ini_file( app_path() . "/libraries/wsis_config.ini" );
                }

                catch( \Exception $e)
                {
                    print_r( $e); exit;
                }
            } 
            else 
            {
                throw new Exception("Error: Cannot open wsis_config.xml file!");
            }

            if (!$wsis_config) 
            {
                throw new Exception('Error: Unable to read wsis_config.xml!');
            }
            
            if(substr($wsis_config['service-url'], -1) !== "/"){
                $wsis_config['service-url'] = $wsis_config['service-url'] . "/";
            }
            
            if(!substr($wsis_config['cafile-path'], 0) !== "/"){
                $wsis_config['cafile-path'] = "/" . $wsis_config['cafile-path'];
            }
            $wsis_config['cafile-path'] = app_path() . $wsis_config['cafile-path'];            
            
            $this->wsis_client = new WSISClient(
                    $wsis_config['admin-username'],
                    $wsis_config['admin-password'],
                    $wsis_config['server'],
                    $wsis_config['service-url'],
                    $wsis_config['cafile-path'],
                    $wsis_config['verify-peer'],
                    $wsis_config['allow-self-signed']
            );            
        } catch (Exception $e) {
            throw new Exception('Unable to instantiate Identity Server client. Try editing the cafile-path within wsis_config.ini.', 0, NULL);
        }
    }

    /**
     * Return true if the given username exists in the identity server.
     * @param $username
     * @return bool
     */
    public function username_exists($username) {
        try{
            //$this->wsis_client = new WSISClient( $username);
            return $this->wsis_client->username_exists($username);
        } catch (Exception $ex) {
            print_r( $ex); exit;
            throw new Exception("Unable to check whether username exists", 0, NULL);
        }
        
    }

    /**
     * authenticate a given user
     * @param $username
     * @param $password
     * @return boolean
     */
    public function authenticate($username, $password) {
        try{
            return $this->wsis_client->authenticate($username, $password);
        } catch (Exception $ex) {
            throw new Exception("Unable to authenticate user", 0, NULL);
        }        
    }

    /**
     * Add a new user to the identity server.
     * @param $username
     * @param $password
     * @return void
     */
    public function add_user($username, $password, $first_name, $last_name, $email, $organization,
            $address, $country,$telephone, $mobile, $im, $url) {
        try{
            $this->wsis_client->addUser($username, $password, $first_name . " " . $last_name);
        } catch (Exception $ex) {
            var_dump($ex);
            throw new Exception("Unable to add new user", 0, NULL);
        }        
    }

    /**
     * Get the user profile
     * @param $username
     * @return mixed|void
     */
    public function get_user_profile($username)
    {
        // TODO: Implement get_user_profile() method.
    }

    /**
     * Update the user profile
     *
     * @param $username
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $organization
     * @param $address
     * @param $country
     * @param $telephone
     * @param $mobile
     * @param $im
     * @param $url
     * @return mixed
     */
    public function update_user_profile($username, $first_name, $last_name, $email, $organization, $address,
                                        $country, $telephone, $mobile, $im, $url)
    {
        // TODO: Implement update_user_profile() method.
    }

    /**
     * Function to update user password
     *
     * @param $username
     * @param $current_password
     * @param $new_password
     * @return mixed
     */
    public function change_password($username, $current_password, $new_password)
    {
        // TODO: Implement change_password() method.
    }

    /**
     * Function to remove an existing user
     *
     * @param $username
     * @return void
     */
    public function remove_user($username)
    {
        // TODO: Implement remove_user() method.
    }

    /**
     * Function to check whether a user has permission for a particular permission string(api method).
     *
     * @param $username
     * @param $permission_string
     * @return bool
     */
    public function checkPermissionForUser($username, $permission_string)
    {
        // TODO: Implement checkPermissionForUser() method.
    }

    /**
     * Function to get all the permissions that a particular user has.
     *
     * @param $username
     * @return mixed
     */
    public function getUserPermissions($username)
    {
        // TODO: Implement getUserPermissions() method.
    }

    /**
     * Function to check whether a role is existing 
     *
     * @param string $roleName 
     * @return IsExistingRoleResponse
     */
    public function isExistingRole( $roleName){
        try{
            return $this->wsis_client->is_existing_role( $roleName);
        } catch (Exception $ex) {
            var_dump($ex); exit;
            throw new Exception("Unable to check if role exists.", 0, $ex);
        }    
    }

    /**
     * Function to add new role by providing the role name.
     * 
     * @param string $roleName
     */
    public function addRole($roleName){
        try{
            return $this->wsis_client->add_role( $roleName);
        } catch (Exception $ex) {
            var_dump($ex); exit;
            throw new Exception("Unable to add role.", 0, $ex);
        }        
    }
    /**
     * Function to get the entire list of roles in the application
     *
     * @return mixed
     */
    public function getRoleNames()
    {
        try{
            return $this->wsis_client->get_all_roles();
        } catch (Exception $ex) {
            var_dump($ex);
            throw new Exception("Unable to get roles.", 0, NULL);
        }        
    }

    /**
     * Function to get the role list of a user
     *
     * @param $username
     * @return mixed
     */
    public function getRoleListOfUser($username)
    {
        try{
            return $this->wsis_client->get_user_roles( $username);
        } catch (Exception $ex) {
            var_dump($ex);
            throw new Exception("Unable to get roles.", 0, NULL);
        }  
    }

    /**
     * Function to get the user list of a particular role
     *
     * @param $role
     * @return mixed
     */
    public function getUserListOfRole($role)
    {
        // TODO: Implement getUserListOfRole() method.
    }

    /**
     * Function to add a role to a user
     *
     * @param $username
     * @param $role
     * @return void
     */
    public function addUserToRole($username, $role)
    {
        // TODO: Implement addUserToRole() method.
    }

    /**
     * Function to role from user
     *
     * @param $username
     * @param $role
     * @return void
     */

    /**
     * Function to update role list of user 
     *
     * @param UpdateRoleListOfUser $parameters
     * @return void
     */
    public function updateRoleListOfUser($username, $roles)
    {
        try{
            return $this->wsis_client->update_user_roles( $username, $roles);
        } catch (Exception $ex) {
            var_dump($ex); exit;
            throw new Exception("Unable to update User roles.", 0, NULL);
        }  
    }
    public function removeUserFromRole($username, $role)
    {
        // TODO: Implement removeUserFromRole() method.
    }

    /**
     * Function to list users
     *
     * @param void
     * @return void
     */
    public function listUsers(){
        try {
            return $this->wsis_client->list_users();
        } catch (Exception $ex) {
    
            throw new Exception( "Unable to list users", 0, $ex);
        }
    }
}
