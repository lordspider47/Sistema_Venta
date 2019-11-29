<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
	[
		"venta"		=> $config->application->controllersDir,
		"venta" 	=> $config->application->modelsDir,
		"App\Forms"  => __DIR__ . '/../../app/forms/',


	]
);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
);

$loader->register();
