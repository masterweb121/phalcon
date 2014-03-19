<?php

namespace Photography;

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
            '../app/photography/controllers'
        ));
        $loader->registerNamespaces(
            array(
                'Photography\Controllers' => '../app/photography/controllers/',
                'Photography\Models'      => '../app/photography/models/',
                'Photography\Components'    => '../app/photography/components/',
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
            $dispatcher->setDefaultNamespace("Photography\Controllers");
            return $dispatcher;
        });

        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir('../app/photography/views/');
            return $view;
        });
    }

}