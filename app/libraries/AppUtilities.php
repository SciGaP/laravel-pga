<?php

//Airavata classes - loaded from app/libraries/Airavata
use Airavata\API\AiravataClient;

use Airavata\Model\AppCatalog\AppInterface\DataType;
use Airavata\Model\AppCatalog\AppInterface\InputDataObjectType;


use Airavata\Model\Workspace\Project;

use Airavata\Model\AppCatalog\AppDeployment\ApplicationModule;
use Airavata\Model\AppCatalog\AppDeployment\ApplicationParallelismType;


class AppUtilities{

	public static function create_or_update_appModule( $inputs){

		$Airavataclient = Utilities::get_airavata_client();

		$appModule = new ApplicationModule( array(
												"appModuleName" => $inputs["appModuleName"],
												"appModuleVersion" => $inputs["appModuleVersion"],
												"appModuleDescription" => $inputs["appModuleDescription"]
										));
		
		$result = $Airavataclient->registerApplicationModule( $appModule);

		print_r( $result);
	}

	public static function getAppInterfaceData(){
		$dataType = new DataType();
		//var_dump( $dataType::$__names);
		//echo "<br/><br/>";
		$InputDataObjectType = new InputDataObjectType();
		//var_dump( $InputDataObjectType);

		return array(
						"dataTypes" => $dataType::$__names
					);
	}

	public static function getAppDeploymentData(){
		$apt = new ApplicationParallelismType();

		return array( 
						"applicationParallelismTypes" => $apt::$__names
					);
	}
}