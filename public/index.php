<?php 
//print_r(get_loaded_extensions()); 

try {


    //Read the configuration
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();

    //Create a DI
    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full-stack framework
    $di = new Phalcon\DI\FactoryDefault();

    //Setup the database service
    // Database connection is created based on parameters defined in the configuration file
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });

    //Start the session the first time a component requests the session service
    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    //Register an user component
    $di->set('elements', function(){
        return new Elements();
    });

	//Register a controller as a service
	$di->set('browse', function() {
		$component = new Browse();
		return $component;
	});

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}

?>
