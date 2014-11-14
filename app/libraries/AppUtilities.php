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
		$appInterfaces = $airavataclient->getallapplicationinterfaces();
		//var_dump( $dataType::$__names);
		//echo "<br/><br/>";
		$InputDataObjectType = new InputDataObjectType();
		//var_dump( $InputDataObjectType);

		return array(
						"appInterfaces" => $appInterfaces,
						"dataTypes" 	=> $dataType::$__names,
						"modules"   	=> $modules
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
																	"standardInput" => $appInterfaceValues["standardInput"],
																	"userFriendlyDescription" => $appInterfaceValues["userFriendlyDescription"][ $index],
																	"metaData" => $appInterfaceValues["metaData"][ $index]
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
																	"type" => $appInterfaceValues["outputType"][ $index]
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

		$appDeployments = array();//$airavataclient->getAllAppDeployments();
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

	public static function create_or_update_appDeployment( $inputs){

		$appDeploymentValues = $inputs;

		$airavataclient = Utilities::get_airavata_client();

		foreach( $appDeploymentValues["libraryPrependPathName"] as $index => $prependName)
		{
			$envPath = new SetEnvPaths(array(
											"name" => $prependName,
											"value" => $appDeploymentValues["libraryPrependPathValue"][ $index]
										));
			$appDeploymentValues["libPrependPaths"][] = $envPath;
		}
		foreach( $appDeploymentValues["libraryAppendPathName"] as $index => $appendName)
		{
			$envPath = new SetEnvPaths(array(
											"name" => $appendName,
											"value" => $appDeploymentValues["libraryAppendPathValue"][ $index]
										));
			$appDeploymentValues["libAppendPaths"][] = $envPath;
		}
		foreach( $appDeploymentValues["environmentName"] as $index => $envName)
		{
			$envPath = new SetEnvPaths(array(
											"name" => $envName,
											"value" => $appDeploymentValues["environmentValue"][$index]
										));
			$appDeploymentValues["setEnvironment"][] = $envPath;
		}

		$appDeployment = new ApplicationDeploymentDescription(  $appDeploymentValues);
		$appDeploymentId = $airavataclient->registerApplicationDeployment( $appDeployment);

		return;

	}

	public static function getAllModules(){
		$airavataclient = Utilities::get_airavata_client();
		return $airavataclient->getAllAppModules();
	}
}