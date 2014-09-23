<?php

require_once 'UserStoreManager/UserStoreManager.php';

/**
 * WSISClient class
 * 
 * This class provides a unified interface for the
 * WSO2 IS 4.6.0 service APIs.
 */
class WSISClient {

    /**
     * @var UserStoreManager
     * @access private
     */
    private $userStoreManager;

    /**
     * @var string
     * @access private
     */
    private $server;
    
    /**
     * @var string
     * @access private
     */
    private $service_url;


    /**
     * Constructor
     * 
     * @param string $admin_username
     * @param string $admin_password
     * @param string $server
     * @param string $service_url
     * @param string $cafile_path
     * @param bool   $verify_peer
     * @param bool   $allow_selfsigned_cer
     * @throws Exception
     */
    public function __construct($admin_username, $admin_password = null, $server,
            $service_url,$cafile_path, $verify_peer, $allow_selfsigned_cert) {
        
        $context = stream_context_create(array(
            'ssl' => array(
                'verify_peer' => $verify_peer,
                "allow_self_signed"=> $allow_selfsigned_cert,
                'cafile' => $cafile_path,
                'CN_match' => $server,
        )));

        $parameters = array(
            'login' => $admin_username,
            'password' => $admin_password,
            'stream_context' => $context,
            'trace' => 1,
            'features' => SOAP_WAIT_ONE_WAY_CALLS
        );

        $this->server = $server;
        $this->service_url = $service_url;
        
        try {
            $this->userStoreManager = new UserStoreManager($service_url, $parameters);
        } catch (Exception $ex) {
            print_r( $ex); exit;
            throw new Exception("Unable to instantiate client", 0, $ex);
        }
    }

    
    /**
     * Function to add new user
     * 
     * @param string $userName
     * @param string $password
     * @return void
     * @throws Exception
     */
    public function addUser($userName, $password) {
        try {
            $this->userStoreManager->addUser($userName, $password);
        } catch (Exception $ex) {
            throw new Exception("Unable to add new user", 0, $ex);
        }
    }
    
    /**
     * Function to delete existing user
     * 
     * @param string $username
     * @return void
     * @throws Exception
     */
    public function deleteUser($username) {
        try {
            $this->userStoreManager->deleteUser($username);
        } catch (Exception $ex) {
            throw new Exception("Unable to delete user", 0, $ex);
        }
    }

    
    /**
     * Function to authenticate user
     * 
     * @param string $username
     * @param string $password
     * @return boolean
     * @throws Exception
     */
    public function authenticate($username, $password){
        try {
            return $this->userStoreManager->authenticate($username, $password);
        } catch (Exception $ex) {
            throw new Exception("Unable to authenticate user", 0, $ex);
        }
    }
    
    /**
     * Function to check whether username exists
     * 
     * @param string $username
     * @return boolean
     * @throws Exception
     */
    public function username_exists($username){
        try {
            return $this->userStoreManager->isExistingUser($username);
        } catch (Exception $ex) {
            throw new Exception("Unable to verify username exists", 0, $ex);
        }
    }
}
