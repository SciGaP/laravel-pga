<?php

//Thrift classes - loaded from Vendor/Thrift
use Thrift\Transport\TTransport;
use Thrift\Exception\TException;
use Thrift\Exception\TTransportException;
use Thrift\Factory\TStringFuncFactory;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;

//Airavata classes - loaded from app/libraries/Airavata
use Airavata\API\AiravataClient;
use Airavata\API\Error\InvalidRequestException;
use Airavata\API\Error\AiravataClientException;
use Airavata\API\Error\AiravataSystemException;
use Airavata\Model\AppCatalog\AppInterface\DataType;
use Airavata\Model\Workspace\Project;
use Airavata\Model\AppCatalog\ComputeResource\FileSystems;
use Airavata\Model\AppCatalog\ComputeResource\JobSubmissionInterface;
use Airavata\Model\AppCatalog\ComputeResource\JobSubmissionProtocol;
use Airavata\Model\AppCatalog\ComputeResource\SecurityProtocol;
use Airavata\Model\AppCatalog\ComputeResource\ResourceJobManager;
use Airavata\Model\AppCatalog\ComputeResource\ResourceJobManagerType;
use Airavata\Model\AppCatalog\ComputeResource\DataMovementProtocol;
use Airavata\Model\AppCatalog\ComputeResource\ComputeResourceDescription;
use Airavata\Model\AppCatalog\ComputeResource\SSHJobSubmission;
use Airavata\Model\AppCatalog\ComputeResource\LOCALSubmission;
use Airavata\Model\AppCatalog\ComputeResource\BatchQueue;

use Airavata\Model\AppCatalog\ComputeResource\SCPDataMovement;
use Airavata\Model\AppCatalog\ComputeResource\GridFTPDataMovement;
use Airavata\Model\AppCatalog\ComputeResource\LOCALDataMovement;



class CRUtilities{
/**
 * Basic utility functions
 */

//define('ROOT_DIR', __DIR__);

/**
 * Define configuration constants
 */
const AIRAVATA_SERVER = 'gw111.iu.xsede.org';
//const AIRAVATA_SERVER = 'gw127.iu.xsede.org';
//const AIRAVATA_SERVER = 'gw56.iu.xsede.org'; //Mirror
//const AIRAVATA_PORT = 8930; //development
const AIRAVATA_PORT = 9930; //production
const AIRAVATA_TIMEOUT = 100000;
const EXPERIMENT_DATA_ROOT = '../../experimentData/';

const SSH_USER = 'root';
const DATA_PATH = 'file://var/www/htm/experimentData/';

const EXPERIMENT_DATA_ROOT_ABSOLUTE = '/var/www/html/experimentData/';

//const EXPERIMENT_DATA_ROOT_ABSOLUTE = 'C:/wamp/www/experimentData/';

//const USER_STORE = 'WSO2','XML','USER_API';
const USER_STORE = 'WSO2';


const REQ_URL = 'https://gw111.iu.xsede.org:8443/credential-store/acs-start-servlet';
const GATEWAY_NAME = 'PHP-Reference-Gateway';
const EMAIL = 'admin@gw120.iu.xsede.org';
private $tokenFilePath = 'tokens.xml';
private $tokenFile = null;
const EXPERIMENT_PATH = null;

//already set inside app/config.php
//date_default_timezone_set('UTC');

/**
 * Import user store utilities
 */
/*
switch (USER_STORE)
{
    case 'WSO2':
        require_once 'wsis_utilities.php'; // WS02 Identity Server
        break;
    case 'XML':
        require_once 'xml_id_utilities.php'; // XML user database
        break;
    case 'USER_API':
        require_once 'userapi_utilities.php'; // Airavata UserAPI
        break;
}
*/
/**
 * import Thrift and Airavata
 */
//$GLOBALS['THRIFT_ROOT'] = './lib/Thrift/';

/*
require_once 'Thrift/Transport/TTransport.php';
require_once 'Thrift/Transport/TSocket.php';
require_once 'Thrift/Protocol/TProtocol.php';
require_once 'Thrift/Protocol/TBinaryProtocol.php';
require_once 'Thrift/Exception/TException.php';
require_once 'Thrift/Exception/TApplicationException.php';
require_once 'Thrift/Exception/TProtocolException.php';
require_once 'Thrift/Base/TBase.php';
require_once 'Thrift/Type/TType.php';
require_once 'Thrift/Type/TMessageType.php';
require_once 'Thrift/Factory/TStringFuncFactory.php';
require_once 'Thrift/StringFunc/TStringFunc.php';
require_once 'Thrift/StringFunc/Core.php';
*/


/*
 * Register or update a compute resource
*/

public static function register_or_update_compute_resource( $computeDescription, $update = false)
{
    $airavataclient = Utilities::get_airavata_client();
    if( $update)
    {
        $computeResourceId = $computeDescription->computeResourceId;
        if( $airavataclient->updateComputeResource( $computeResourceId, $computeDescription) )
        {
            // do something when update returns true.
        }
    }
    else
    {
        /*
        $fileSystems = new FileSystems();
        foreach( $fileSystems as $fileSystem)
            $computeDescription["fileSystems"][$fileSystem] = "";
        */
        $cd = new ComputeResourceDescription( $computeDescription);
        $computeResourceId = $airavataclient->registerComputeResource( $cd);
    }
    $computeResource = $airavataclient->getComputeResource( $computeResourceId);
    return $computeResource;

}

/*
 * Getting data for Compute resource inputs 
*/

public static function getEditCRData(){
    $files = new FileSystems();
    $jsp = new JobSubmissionProtocol();
    $rjmt = new ResourceJobManagerType();
    $sp = new SecurityProtocol();
    $dmp = new DataMovementProtocol();
    return array(
                    "fileSystems" => $files::$__names,
                    "jobSubmissionProtocols" => $jsp::$__names,
                    "resourceJobManagerTypes" => $rjmt::$__names,
                    "securityProtocols" => $sp::$__names,
                    "dataMovementProtocols" => $dmp::$__names
                );
}


public static function createQueueObject( $queue){
    $queueObject = new BatchQueue( $queue); 
    return $queueObject;
}


/*
 * Getting Job Submission Interface Object.
*/

public static function createJSIObject( $inputs){

    $airavataclient = Utilities::get_airavata_client();
    $computeResource = Session::get("computeResource");

    $computeResource = $airavataclient->getComputeResource( $computeResource->computeResourceId, $computeResource); 
    //print_r( $computeResource); exit;

    if( $inputs["jobSubmissionProtocol"] == 0) /* LOCAL */
    {
        $resourceManager = new ResourceJobManager(array( "resourceJobManagerType"=> $inputs["resourceJobManagerType"]));
        $localJobSubmission = new LOCALSubmission( array(
                                                            "resourceJobManager" => $resourceManager
                                                            )
                                                    );
        $localSub = $airavataclient->addLocalSubmissionDetails( $computeResource->computeResourceId, 0, $localJobSubmission);
        if( $localSub)
        {
            if( $localSub)
            print_r( "The SSH Job Interface has been added. Edit UI for the Job Interface is yet to be made.
                Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
        
        }
        
    }
    else if( $inputs["jobSubmissionProtocol"] == 1) /* SSH */
    {
        $resourceManager = new ResourceJobManager(array( "resourceJobManagerType"=> $inputs["resourceJobManagerType"]));
        $sshJobSubmission = new SSHJobSubmission( array
                                                    (
                                                        "securityProtocol" => intval( $inputs["securityProtocol"]),
                                                        "resourceJobManager" => $resourceManager,
                                                        "alternativeSSHHostName" => $inputs["alternativeSSHHostName"],
                                                        "sshPort" => intval( $inputs["sshPort"] )
                                                    )
                                                );

        $sshSub = $airavataclient->addSSHJobSubmissionDetails( $computeResource->computeResourceId, 0, $sshJobSubmission);
        if( $sshSub)
            print_r( "The SSH Job Interface has been added. Edit UI for the Job Interface is yet to be made.
                Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
        
    }
    else /* Globus & Unicore currently */
    {
        print_r( "Whoops! We haven't coded for this Job Submission Protocol yet. Still working on it. Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
    }
}



/*
 * Getting Job Submission Interface Object.
*/
public static function createDMIObject( $inputs){
    //print_r( $inputs); exit;
    $airavataclient = Utilities::get_airavata_client();

    $computeResource = Session::get("computeResource");
    if( $inputs["dataMovementProtocol"] == 0) /* LOCAL */
    {
        $localDataMovement = new LOCALDataMovement();
        $localdmp = $airavataclient->addLocalDataMovementDetails( $computeResource->computeResourceId, 0, $localDataMovement);
        
        if( $localdmp)
            print_r( "The Local Data Movement has been added. Edit UI for the Local Data Movement Interface is yet to be made.
                Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
    }
    else if( $inputs["dataMovementProtocol"] == 1) /* SCP */
    {
        //var_dump( $inputs); exit;
        $scpDataMovement = new SCPDataMovement( array(
                                                "securityProtocol" => intval( $inputs["securityProtocol"] ),
                                                "alternativeSCPHostName" => $inputs["alternativeSSHHostName"],
                                                "sshPort" => intval( $inputs["sshPort"] )
                                                )

                                            );
        $scpdmp = $airavataclient->addSCPDataMovementDetails( $computeResource->computeResourceId, 0, $scpDataMovement);
        if( $scpdmp)
            print_r( "The SCP Data Movement has been added. Edit UI for the SCP Data Movement Interface is yet to be made.
                Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");   
    }
    else if( $inputs["dataMovementProtocol"] == 3) /* GridFTP */
    {
        //var_dump( $inputs); exit;
        $gridFTPDataMovement = new GridFTPDataMovement( array(
                "securityProtocol" => $inputs["securityProtocol"],
                "gridFTPEndPoints" => $inputs["gridFTPEndPoints"]
            ));
        $gridftpdmp = $airavataclient->addGridFTPDataMovementDetails( $computeResource->computeResourceId, 0, $gridFTPDataMovement);
        
        if( $gridftpdmp)
            print_r( "The GridFTP Data Movement has been added. Edit UI for the Grid Data Movement Interface is yet to be made.
                Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
    }
}

}

?>