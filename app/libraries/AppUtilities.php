<?php

//Airavata classes - loaded from app/libraries/Airavata
use Airavata\API\AiravataClient;

use Airavata\Model\AppCatalog\AppInterface\DataType;
use Airavata\Model\AppCatalog\AppInterface\InputDataObjectType;
use Airavata\Model\AppCatalog\AppInterface\OutputDataObjectType;
use Airavata\Model\AppCatalog\AppInterface\ApplicationInterfaceDescription;

use Airavata\Model\Workspace\Project;

use Airavata\Model\AppCatalog\AppDeployment\ApplicationModule;
use Airavata\Model\AppCatalog\AppDeployment\ApplicationParallelismType;
use Airavata\Model\AppCatalog\AppDeployment\ApplicationDeploymentDescription;
use Airavata\Model\AppCatalog\AppDeployment\SetEnvPaths;

//use Airavata\Model\AppCatalog\ComputeResource


class AppUtilities{

	public static function create_or_update_appModule( $inputs, $update = false){

		$airavataclient = Utilities::get_airavata_client();

		$appModule = new ApplicationModule( array(
												"appModuleName" => $inputs["appModuleName"],
												"appModuleVersion" => $inputs["appModuleVersion"],
												"appModuleDescription" => $inputs["appModuleDescription"]
										));
		
		if( $update)
			return $airavataclient->updateApplicationModule( $inputs["appModuleId"], $appModule);
		else
			return $airavataclient->registerApplicationModule( $appModule);
	}

	public static function deleteAppModule( $appModuleId){

		$airavataclient = Utilities::get_airavata_client();

		return $airavataclient->deleteApplicationModule( $appModuleId);
	}

	public static function getAppInterfaceData(){

		$airavataclient = Utilities::get_airavata_client();

		$dataType = new DataType();
		$modules = AppUtilities::getAllModules();
		$appInterfaces = $airavataclient->getAllApplicationInterfaces();


		$InputDataObjectType = new InputDataObjectType();

		return array(
						"appInterfaces" 	=> $appInterfaces,
						"dataTypes" 		=> $dataType::$__names,
						"modules"   		=> $modules
						);
	}

	public static function create_or_update_appInterface( $appInterfaceValues, $update = false){
		
		$airavataclient = Utilities::get_airavata_client();
		//var_dump( $appInterfaceValues); exit;
		$appInterface = new ApplicationInterfaceDescription( array(
																"applicationName" => $appInterfaceValues["applicationName"],
																"applicationDescription" => $appInterfaceValues["applicationDescription"],
																"applicationModules" => $appInterfaceValues["applicationModules"]
															) ); 

		if( isset( $appInterfaceValues["inputName"]))
		{
			foreach ($appInterfaceValues["inputName"] as $index => $name) {
				$inputDataObjectType = new InputDataObjectType( array(
																	"name" => $name,
																	"value" => $appInterfaceValues["inputValue"][ $index],
																	"type" => $appInterfaceValues["inputType"][ $index],
																	"applicationArgument" => $appInterfaceValues["applicationArgument"][$index],
																	"standardInput" => $appInterfaceValues["standardInput"][ $index],
																	"userFriendlyDescription" => $appInterfaceValues["userFriendlyDescription"][ $index],
																	"metaData" => $appInterfaceValues["metaData"][ $index],
																	"inputOrder" => intval( $appInterfaceValues["inputOrder"][ $index]),
																	"dataStaged" => intval( $appInterfaceValues["dataStaged"][ $index]),
																	"isRequired" => $appInterfaceValues["isRequired"][ $index],
																	"requiredToAddedToCommandLine" => $appInterfaceValues["requiredToAddedToCommandLine"][$index]
																) );
				$appInterface->applicationInputs[] = $inputDataObjectType;
			}
		}

		if( isset( $appInterfaceValues["outputName"]))
		{
			foreach ( $appInterfaceValues["outputName"] as $index => $name) {
				$outputDataObjectType = new OutputDataObjectType( array(
																	"name" => $name,
																	"value" => $appInterfaceValues["outputValue"][ $index],
																	"type" => $appInterfaceValues["outputType"][ $index],
																	"dataMovement" => intval( $appInterfaceValues["dataMovement"][ $index]),
																	"dataNameLocation" => $appInterfaceValues["dataNameLocation"][ $index],
																	"isRequired" => $appInterfaceValues["isRequired"][ $index],
																	"requiredToAddedToCommandLine" => $appInterfaceValues["requiredToAddedToCommandLine"][$index]
																));
				$appInterface->applicationOutputs[] = $outputDataObjectType;
			}
		}

		//var_dump( $appInterface); exit;

		if( $update)
			$airavataclient->updateApplicationInterface( $appInterfaceValues["app-interface-id"], $appInterface);
		else
			$airavataclient->getApplicationInterface($airavataclient->registerApplicationInterface( $appInterface) );

		//print_r( "App interface has been created.");
	}

	public static function deleteAppInterface( $appInterfaceId){

		$airavataclient = Utilities::get_airavata_client();

		return $airavataclient->deleteApplicationInterface( $appInterfaceId);
	}


	public static function getAppDeploymentData(){

		$airavataclient = Utilities::get_airavata_client();

		$appDeployments = $airavataclient->getAllApplicationDeployments();
		//var_dump( $appDeployments); exit;
		$computeResources = $airavataclient->getAllComputeResourceNames();
		$modules = AppUtilities::getAllModules();
		$apt = new ApplicationParallelismType();

		return array( 
						"appDeployments" 			  => $appDeployments,
						"applicationParallelismTypes" => $apt::$__names,
						"computeResources"            => $computeResources,
						"modules"			          => $modules
					);
	}

	public static function create_or_update_appDeployment( $inputs, $update = false){

		$appDeploymentValues = $inputs;

		$airavataclient = Utilities::get_airavata_client();

		if( isset( $appDeploymentValues["moduleLoadCmds"]))
			$appDeploymentValues["moduleLoadCmds"] = array_unique( array_filter( $appDeploymentValues["moduleLoadCmds"]));

		if( isset( $appDeploymentValues["libraryPrependPathName"] )) 
		{	
			$libPrependPathNames = array_unique( array_filter( $appDeploymentValues["libraryPrependPathName"],"trim" ));
		
			foreach( $libPrependPathNames as $index => $prependName)
			{
				$envPath = new SetEnvPaths(array(
												"name" => $prependName,
												"value" => $appDeploymentValues["libraryPrependPathValue"][ $index]
											));
				$appDeploymentValues["libPrependPaths"][] = $envPath;
			}
		}

		if( isset( $appDeploymentValues["libraryAppendPathName"] )) 
		{
			$libAppendPathNames = array_unique( array_filter( $appDeploymentValues["libraryAppendPathName"],"trim" ));
			foreach( $libAppendPathNames as $index => $appendName)
			{
				$envPath = new SetEnvPaths(array(
												"name" => $appendName,
												"value" => $appDeploymentValues["libraryAppendPathValue"][ $index]
											));
				$appDeploymentValues["libAppendPaths"][] = $envPath;
			}
		}

		if( isset( $appDeploymentValues["environmentName"] )) 
		{
			$environmentNames = array_unique( array_filter( $appDeploymentValues["environmentName"], "trim"));
			foreach( $environmentNames as $index => $envName)
			{
				$envPath = new SetEnvPaths(array(
												"name" => $envName,
												"value" => $appDeploymentValues["environmentValue"][$index]
											));
				$appDeploymentValues["setEnvironment"][] = $envPath;
			}
		}
		
		if( isset( $appDeploymentValues["preJobCommand"] )) 
		{
			$appDeploymentValues["preJobCommands"] = array_unique( array_filter( $appDeploymentValues["preJobCommand"], "trim"));
		}

		if( isset( $appDeploymentValues["postJobCommand"] )) 
		{
			$appDeploymentValues["postJobCommands"] = array_unique( array_filter( $appDeploymentValues["postJobCommand"], "trim"));
		}

		//var_dump( $appDeploymentValues); exit;
		$appDeployment = new ApplicationDeploymentDescription(  $appDeploymentValues);
		if( $update)
			$airavataclient->updateApplicationDeployment( $inputs["app-deployment-id"], $appDeployment);
		else
			$appDeploymentId = $airavataclient->registerApplicationDeployment( $appDeployment);

		return;

	}

	public static function deleteAppDeployment( $appDeploymentId )
	{

		$airavataclient = Utilities::get_airavata_client();

		return $airavataclient->deleteApplicationDeployment( $appDeploymentId);
	}

	public static function getAllModules(){
		$airavataclient = Utilities::get_airavata_client();
		return $airavataclient->getAllAppModules();
	}
}