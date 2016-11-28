<?php

namespace System\Core;

use Config;
use System\Core\Http\Kernel;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as SymfonyResolver;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyDispatcher;
use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

class Framework
{

    public $__application = array();
    public $_storage = array();
    public $_logger = array();

    public $container;
    public $dispatcher;
    public $resolver;
    public $kernel;

    public function __construct(ContainerBuilder $sc, SymfonyDispatcher $dispatcher, SymfonyResolver $resolver)
    {
        $this->container = $sc;
        $this->dispatcher = $dispatcher;
        $this->resolver = $resolver;
        $this->_storage['root'] = $this->container->getParameter('path.storage');

        //$this->kernel = new Kernel($this->dispatcher, $this->resolver);
        $this->container->register('kernel', 'System\Core\Http\Kernel')
        	->setArguments(array(new Reference('dispatcher'), new Reference('resolver')))
        ;
        $this->kernel = $this->container->get('kernel');
    }

    public function getKernel()
    {
        return $this->kernel;
    }

    /*public function __construct(ContainerBuilder $sc, SymfonyDispatcher $dispatcher, SymfonyResolver $resolver)
    {
        parent::__construct($dispatcher, $resolver);
        $this->configConstructor();
        $this->loggerConstructor();
    }*/

    private function configConstructor()
    {
        class_alias('\System\Core\DataLoader\Config', 'Config');
        Config::populate();
        $this->_application['name'] = Config::get('app.name');
    }

    private function loggerConstructor()
    {
        $this->_logger['format'] = Config::get('logger.format');
        $this->_logger['threshold'] = Config::get('logger.threshold');
        if ($this->loggerThreshold()) {
            // create a log channel
            $log = new Logger(
                $this->_application['name']
            );

            $log->pushHandler(
                new StreamHandler(
                    $this->_storage['root'] . '/logs/' . $this->_logger['format'],
                    Logger::DEBUG
                )
            );

            ErrorHandler::register($log);

            // add records to the log
            $log->warning('Foo', array('key' => 'value'));
            $log->error('Bar');
        }
    }

    // move it out and make component adapters instead.
    private function loggerThreshold()
    {
        //$this->_logger['threshold'];
        $threshold = Config::get('logger.threshold');
        if ($threshold == 0) {
            $level = false;
        }
        elseif($threshold == 1) {
            $level = "ERROR";
        }
        elseif($threshold == 2) {
            $level = "NOTICE";
        }
        elseif($threshold == 3) {
            $level = "DUBUG";
        }
        else {
            $level = "DEBUG";
        }

        return $level;
    }

    private function sessionConstructor()
    {
        $__storage = new NativeSessionStorage(array(), new NativeFileSessionHandler());
        $session = new SymfonySession($__storage);
        $session->start();
    }

    private function databaseConstructor(){}

    private function middlewareConstructor(){}

    private function getMiddleware(){}

    private function setMiddleware(){}

}
