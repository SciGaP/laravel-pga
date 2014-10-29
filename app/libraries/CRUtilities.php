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
public static function register_or_update_compute_resource( $computeDescription, $update = false)
{
    $airavataclient = Utilities::get_airavata_client();
    if( $update)
    {
        $computeResourceId = $computeDescription->computeResourceId;

        if( $airavataclient->updateComputeResource( $computeResourceId, $computeDescription) )
        {
            $computeResource = $airavataclient->getComputeResource( $computeResourceId);
            return $computeResource;
        }
        else
            print_r( "Something went wrong while updating!"); exit;
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
                    "fileSystemsObject" => $files,
                    "fileSystems" => $files::$__names,
                    "jobSubmissionProtocolsObject" => $jsp,
                    "jobSubmissionProtocols" => $jsp::$__names,
                    "resourceJobManagerTypesObject" => $rjmt,
                    "resourceJobManagerTypes" => $rjmt::$__names,
                    "securityProtocolsObject" => $sp,
                    "securityProtocols" => $sp::$__names,
                    "dataMovementProtocolsObject" => $dmp,
                    "dataMovementProtocols" => $dmp::$__names
                );
}


public static function createQueueObject( $queue){
    $queueObject = new BatchQueue( $queue); 
    return $queueObject;
}


/*
 * Creating Job Submission Interface.
*/

public static function create_or_update_JSIObject( $inputs, $update = false){

    $airavataclient = Utilities::get_airavata_client();
    $computeResource = Utilities::get_compute_resource(  $inputs["crId"]);

    if( $inputs["jobSubmissionProtocol"] == JobSubmissionProtocol::LOCAL)
    {
        $jsiId = null;
        if( isset( $inputs["jsiId"]))
            $jsiId = $inputs["jsiId"];
        $resourceManager = new ResourceJobManager(array( "resourceJobManagerType"=> $inputs["resourceJobManagerType"]));
        $localJobSubmission = new LOCALSubmission(  array(
                                                            "JobSubmissionInterfaceId" => $jsiId,
                                                            "resourceJobManager" => $resourceManager
                                                        )
                                                    );
        if( $update)
        {
            $localSub = $airavataclient->updateLocalSubmissionDetails( $jsiId, $localJobSubmission);
        }
        else
        {
            $localSub = $airavataclient->addLocalSubmissionDetails( $computeResource->computeResourceId, 0, $localJobSubmission);
            return $localSub;
        }
        
    }
    else if( $inputs["jobSubmissionProtocol"] ==  JobSubmissionProtocol::SSH) /* SSH */
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
            return;
        
    }
    else /* Globus & Unicore currently */
    {
        print_r( "Whoops! We haven't coded for this Job Submission Protocol yet. Still working on it. Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
    }
}

/*
 * Creating Data Movement Interface Object.
*/
public static function createDMIObject( $inputs){
    $airavataclient = Utilities::get_airavata_client();

    $computeResource = Utilities::get_compute_resource(  $inputs["crId"] );
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
    else /* other data movement protocols */
    {
        print_r( "Whoops! We haven't coded for this Data Movement Protocol yet. Still working on it. Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
    }
}

public static function getAllCRObjects(){
    $airavataclient = Utilities::get_airavata_client();
    return $airavataclient->getAllComputeResourceNames();
}

public static function getJobSubmissionDetails( $jobSubmissionInterfaceId, $jsp){
    //jsp = job submission protocol type
    $airavataclient = Utilities::get_airavata_client();
    if( $jsp == JobSubmissionProtocol::LOCAL)
        return $airavataclient->getLocalJobSubmission( $jobSubmissionInterfaceId);
    else if( $jsp == JobSubmissionProtocol::SSH)
        return $airavataclient->getSSHJobSubmission( $jobSubmissionInterfaceId);
    else if( $jsp == JobSubmissionProtocol::UNICORE)
        return $airavataclient->getUnicoreJobSubmission( $jobSubmissionInterfaceId);
    else if( $jsp == JobSubmissionProtocol::CLOUD)
        return $airavataclient->getCloudJobSubmission( $jobSubmissionInterfaceId);

    //globus get function not present ??	
}

public static function getDataMovementDetails( $dataMovementInterfaceId, $dmi){
    //jsp = job submission protocol type
    $airavataclient = Utilities::get_airavata_client();
    if( $dmi == DataMovementProtocol::LOCAL)
        return $airavataclient->getLocalDataMovement( $dataMovementInterfaceId);
    else if( $dmi == DataMovementProtocol::SCP)
        return $airavataclient->getSCPDataMovement( $dataMovementInterfaceId);
    else if( $dmi == DataMovementProtocol::GridFTP)
        return $airavataclient->getGridFTPDataMovement( $dataMovementInterfaceId);
    else if( $dmi == JobSubmissionProtocol::CLOUD)
        return $airavataclient->getCloudJobSubmission( $dataMovementInterfaceId);

    //globus get function not present ??
}


}
?>