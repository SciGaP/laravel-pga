<?php

class Constant extends Eloquent{

	const AIRAVATA_SERVER = 'gw111.iu.xsede.org';
	//const AIRAVATA_SERVER = 'gw127.iu.xsede.org';
	//const AIRAVATA_SERVER = 'gw56.iu.xsede.org'; //Mirror
	//const AIRAVATA_PORT = 8930; //development
	const AIRAVATA_PORT = 9930; //production
	const AIRAVATA_TIMEOUT = 100000;
	const EXPERIMENT_DATA_ROOT = '/../experimentData/';

	const SSH_USER = 'root';
	//const DATA_PATH = 'file://home/pga/production/experimentData/';

	const EXPERIMENT_DATA_ROOT_ABSOLUTE = '/var/www/experimentData/';
	//const EXPERIMENT_DATA_ROOT_ABSOLUTE = 'C:/wamp/www/experimentData/';

	//const USER_STORE = 'WSO2','XML','USER_API';
	const USER_STORE = 'WSO2';


	const REQ_URL = 'https://gw111.iu.xsede.org:8443/credential-store/acs-start-servlet';
	const GATEWAY_NAME = 'PHP-Reference-Gateway';
	const EMAIL = 'admin@gw120.iu.xsede.org';	

	const SERVER_ALLOWED_FILE_SIZE = 64; // in MB
}

?>
