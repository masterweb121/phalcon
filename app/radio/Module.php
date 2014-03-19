<?php

namespace Radio;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{

    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();
        $loader->registerDirs(
        array(
            '../app/radio/controllers'
        ));
        $loader->registerNamespaces(
            array(
                'Radio\Controllers' => '../app/radio/controllers/',
                'Radio\Models'      => '../app/radio/models/',
                'Radio\Components'      => '../app/radio/components/',
            )
        );

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices($di)
    {

        //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Radio\Controllers");
            return $dispatcher;
        });

        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir('../app/radio/views/');
            return $view;
        });
    }

}