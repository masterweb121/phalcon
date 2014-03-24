<?php

namespace Outdoor;

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
            '../app/oubdoor/controllers'
        ));
        $loader->registerNamespaces(
            array(
                'Outdoor\Controllers' => '../app/outdoor/controllers/',
                'Outdoor\Models'      => '../app/outdoor/models/',
                'Outdoor\Components'  => '../app/outdoor/components/',
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
            $dispatcher->setDefaultNamespace("Outdoor\Controllers");
            return $dispatcher;
        });

        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir('../app/outdoor/views/');
            return $view;
        });
    }

}