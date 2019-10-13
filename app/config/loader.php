<?php

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
	[
		"venta" 	=> $config->application->modelsDir
	]
);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
	/*array(
		'../app/models/',
		'../../app/controllers/'
		
	)*/
    [
        $config->application->controllersDir,
        /*$config->application->ClasesExtraDir,*/
        $config->application->modelsDir
    ]
)->register();
