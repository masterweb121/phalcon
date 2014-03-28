<?php 
//print_r(get_loaded_extensions()); 
//print_r($_SERVER);
//print_r($_POST);
//die();
//if(!extension_loaded ( 'phalcon' )) print('OK');
//if(!extension_loaded ( 'mongo' )) print('mongo cannot load');
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
    $loader->registerNamespaces(
        array(
           'Radio'          => $config->application->modelsDir."/radio/",
           'Photograpy'   =>  $config->application->modelsDir."/radio/",
        )
    );
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
    
    $di->set('radio', function() use ($config){
        $mongo = new Mongo($config->mongodb->dsn);
        return $mongo->selectDb("radio");
    }, true);
    $di->set('member', function() use ($config){
        $mongo = new Mongo($config->mongodb->dsn);
        return $mongo->selectDb("member");
    }, true);
    $di->set('outdoor', function() use ($config){
        $mongo = new Mongo($config->mongodb->dsn);
        return $mongo->selectDb("radio");
    }, true);
    // Setting up the collection Manager
    $di->set('collectionManager', function(){
        return new Phalcon\Mvc\Collection\Manager();
    }, true);
    
    //Setup the view component
    $di->set('view', function() use ($config){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir($config->application->viewsDir);
        /*$view->registerEngines(array(".tpl" => 'Phalcon\Mvc\View\Engine\Smarty'));*/
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
    
    $di->set('router', function() {

        $router = new \Phalcon\Mvc\Router();
        //$router->setDefaultModule("home");
        //$router->setDefaultNamespace('Home\Controllers');
        //$router->setDefaultController('index');
        $router->setDefaultAction('index');
        $router->add('/:module(/?)', array(
            'module' => 1,
            'controller' => 'index',
            'action' => 'index',
        ));
        $router->add('/:module/:controller(/?)', array(
            'module' => 1,
            'controller' => 2,
            'action' => 'index',
        ));
        $router->add('/:module/:controller/:action/:params', array(
            'module' => 1,
            'controller' => 2,
            'action' => 3,
            'params' => 4
        ));
        $router->add("/member(/?)", array(
            /*'module'     => 'home',*/
            'controller' => 'member',
            'action'     => 'index',
            'params' => 2
        ));
        $router->add("/member/:action/:params", array(
            /*'module'     => 'home',*/
            'controller' => 'member',
            'action'     => 1,
            'params' => 2
        ));
        $router->add("/about(/?)", array(
            /*'module'     => 'home',*/
            'controller' => 'about',
            'action'     => 'index',
            'params' => 2
        ));
        return $router;
    });
    
    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    // Register the installed modules
    $application->registerModules(
        array(
            'photography'  => array(
                'className' => 'Photography\Module',
                'path'      => $config->photography->module.'/Module.php',
            ),
            'technology' => array(
                'className' => 'Technology\Module',
                'path'      => $config->technology->module.'/Module.php',
            ),
            'radio'  => array(
                'className' => 'Radio\Module',
                'path'      => $config->radio->module.'/Module.php',
            ),
            'outdoor'  => array(
                'className' => 'Outdoor\Module',
                'path'      => $config->outdoor->module.'/Module.php',
            )
            /*,
            'member'  => array(
                'className' => 'Member\Module',
                'path'      => $config->member->module.'/Module.php',
            )
            */
        )
    );
    
    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}

?>
