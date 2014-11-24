<?php


//Airavata classes - loaded from app/libraries/Airavata
use Airavata\API\AiravataClient;

use Airavata\Model\AppCatalog\ComputeResource\FileSystems;
use Airavata\Model\AppCatalog\ComputeResource\JobSubmissionInterface;
use Airavata\Model\AppCatalog\ComputeResource\JobSubmissionProtocol;
use Airavata\Model\AppCatalog\ComputeResource\SecurityProtocol;
use Airavata\Model\AppCatalog\ComputeResource\ResourceJobManager;
use Airavata\Model\AppCatalog\ComputeResource\ResourceJobManagerType;
use Airavata\Model\AppCatalog\ComputeResource\JobManagerCommand;
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
    $jmc = new JobManagerCommand();
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
                    "dataMovementProtocols" => $dmp::$__names,
                    "jobManagerCommands" => $jmc::$__names
                );
}


public static function createQueueObject( $queue){
    $queueObject = new BatchQueue( $queue); 
    return $queueObject;
}

public static function deleteQueue( $computeResourceId, $queueName)
{
    $airavataclient = Utilities::get_airavata_client();
    $airavataclient->deleteBatchQueue( $computeResourceId, $queueName);
}


/*
 * Creating Job Submission Interface.
*/

public static function create_or_update_JSIObject( $inputs, $update = false){

    $airavataclient = Utilities::get_airavata_client();
    $computeResource = Utilities::get_compute_resource(  $inputs["crId"]);

    if( $inputs["jobSubmissionProtocol"] == JobSubmissionProtocol::LOCAL)
    {

        //print_r( $jsiObject->resourceJobManager->resourceJobManagerId);
        $resourceManager = new ResourceJobManager(array( 
                                                    "resourceJobManagerType" => $inputs["resourceJobManagerType"],
                                                    "pushMonitoringEndpoint" => $inputs["pushMonitoringEndpoint"],
                                                    "jobManagerBinPath"      => $inputs["jobManagerBinPath"],
                                                    "jobManagerCommands"     => $inputs["jobManagerCommands"]
                                                    ));

        //$rmId = $jsiObject->resourceJobManager->resourceJobManagerId;
        //$rm = $airavataclient->updateResourceJobManager($rmId, $resourceManager);
        //print_r( $rm); exit;
        $localJobSubmission = new LOCALSubmission(  array(
                                                            "resourceJobManager" => $resourceManager
                                                        )
                                                    );

        if( $update) //update Local JSP
        {
            $jsiId = null;
            if( isset( $inputs["jsiId"]))
                $jsiId = $inputs["jsiId"];
            $jsiObject = $airavataclient->getLocalJobSubmission( $jsiId);
            $localSub = $airavataclient->updateResourceJobManager(  $jsiObject->resourceJobManager->resourceJobManagerId, $resourceManager);
            //$localSub = $airavataclient->updateLocalSubmissionDetails( $jsiId, $localJobSubmission);
        }
        else        // create Local JSP
        {
            $localSub = $airavataclient->addLocalSubmissionDetails( $computeResource->computeResourceId, 0, $localJobSubmission);
            return $localSub;
        }
        
    }
    else if( $inputs["jobSubmissionProtocol"] ==  JobSubmissionProtocol::SSH) /* SSH */
    {
        $resourceManager = new ResourceJobManager(array( 
                                                    "resourceJobManagerType" => $inputs["resourceJobManagerType"],
                                                    "pushMonitoringEndpoint" => $inputs["pushMonitoringEndpoint"],
                                                    "jobManagerBinPath"      => $inputs["jobManagerBinPath"],
                                                    "jobManagerCommands"     => $inputs["jobManagerCommands"]
                                                    ));
        $sshJobSubmission = new SSHJobSubmission( array
                                                    (
                                                        "securityProtocol" => intval( $inputs["securityProtocol"]),
                                                        "resourceJobManager" => $resourceManager,
                                                        "alternativeSSHHostName" => $inputs["alternativeSSHHostName"],
                                                        "sshPort" => intval( $inputs["sshPort"] )
                                                    )
                                                );
        if( $update) //update Local JSP
        {
            $jsiId = null;
            if( isset( $inputs["jsiId"]))
                $jsiId = $inputs["jsiId"];
            $jsiObject = $airavataclient->getSSHJobSubmission( $jsiId);

            //first update resource job manager
            $rmjId = $jsiObject->resourceJobManager->resourceJobManagerId;
            $airavataclient->updateResourceJobManager(  $rmjId, $resourceManager);
            $jsiObject = $airavataclient->getSSHJobSubmission( $jsiId);

            $jsiObject->securityProtocol = intval( $inputs["securityProtocol"] );
            $jsiObject->alternativeSSHHostName = $inputs["alternativeSSHHostName"];
            $jsiObject->sshPort = intval( $inputs["sshPort"] );
            $jsiObject->resourceJobManager = $airavataclient->getresourceJobManager( $rmjId);
            //var_dump( $jsiObject); exit;
            //add updated resource job manager to ssh job submission object.
            //$sshJobSubmission->resourceJobManager->resourceJobManagerId = $rmjId;
            $localSub = $airavataclient->updateSSHJobSubmissionDetails( $jsiId, $jsiObject);
        }
        else
        {
            $sshSub = $airavataclient->addSSHJobSubmissionDetails( $computeResource->computeResourceId, 0, $sshJobSubmission);
        }
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
public static function create_or_update_DMIObject( $inputs, $update = false){
    $airavataclient = Utilities::get_airavata_client();

    $computeResource = Utilities::get_compute_resource(  $inputs["crId"] );
    if( $inputs["dataMovementProtocol"] == DataMovementProtocol::LOCAL) /* LOCAL */
    {
        $localDataMovement = new LOCALDataMovement();
        $localdmp = $airavataclient->addLocalDataMovementDetails( $computeResource->computeResourceId, 0, $localDataMovement);
        
        if( $localdmp)
            print_r( "The Local Data Movement has been added. Edit UI for the Local Data Movement Interface is yet to be made.
                Please click <a href='" . URL::to('/') . "/cr/edit'>here</a> to go back to edit page for compute resource.");
    }
    else if( $inputs["dataMovementProtocol"] == DataMovementProtocol::SCP) /* SCP */
    {
        //var_dump( $inputs); exit;
        $scpDataMovement = new SCPDataMovement( array(
                                                "securityProtocol" => intval( $inputs["securityProtocol"] ),
                                                "alternativeSCPHostName" => $inputs["alternativeSSHHostName"],
                                                "sshPort" => intval( $inputs["sshPort"] )
                                                )

                                            );

        if( $update)
            $scpdmp = $airavataclient->updateSCPDataMovementDetails( $inputs["dmiId"], $scpDataMovement);
        else
            $scpdmp = $airavataclient->addSCPDataMovementDetails( $computeResource->computeResourceId, 0, $scpDataMovement);   
   }
    else if( $inputs["dataMovementProtocol"] == DataMovementProtocol::GridFTP) /* GridFTP */
    {
        //var_dump( $inputs); exit;
        $gridFTPDataMovement = new GridFTPDataMovement( array(
                "securityProtocol" => $inputs["securityProtocol"],
                "gridFTPEndPoints" => $inputs["gridFTPEndPoints"]
            ));
        if( $update)
            $gridftpdmp = $airavataclient->updateGridFTPDataMovementDetails( $inputs["dmiId"], $gridFTPDataMovement);
        else
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

public static function getBrowseCRData(){
    $airavataclient = Utilities::get_airavata_client();
	$appDeployments = $airavataclient->getAllApplicationDeployments();

    return array( 'crObjects' =>$airavataclient->getAllComputeResourceNames(),
    			  'appDeployments' => $appDeployments 
    			);
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

public static function deleteActions( $inputs){
    $airavataclient = Utilities::get_airavata_client();
    if( isset( $inputs["jsiId"]) )
        if( $airavataclient->deleteJobSubmissionInterface( $inputs["crId"], $inputs["jsiId"]) )
            return 1;
        else
            return 0;
    else if( isset( $inputs["dmiId"]) )
        if( $airavataclient->deleteDataMovementInterface( $inputs["crId"], $inputs["dmiId"]) )
            return 1;
        else 
            return 0;
    elseif( isset( $inputs["del-crId"]))
    	if( $airavataclient->deleteComputeResource( $inputs["del-crId"] ) )
    		return 1;
    	else
    		return 0;
}


}
?>