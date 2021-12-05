<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

	'connectionString' => 'mysql:host=localhost;dbname=company',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'psmysql22112021%',
	'charset' => 'utf8',
    'enableProfiling' => true,
    'enableParamLogging' => true,
);