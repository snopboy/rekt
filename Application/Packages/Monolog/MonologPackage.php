<?php

namespace Application\Packages\Monolog;

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
class MonologPackage
{

    /**
     * Symfony's DI Container
     *
     * @var Symfony\Component\DependencyInjection\ContainerBuilder
     */
    public $container;

    /**
     * Array of Loggers
     *
     * @var array
     */
    public $logger = array();

    /**
     * Array of Loggers Thresholds
     *
     * @var array
     */
    public $threshold = array(
        0 => false, // none
        1 => 400,   // error
        2 => 300,   // notice & warning
        3 => 200,   // info
        4 => 100,   // all (debug)
    );

    /**
     * Array of Loggers Thresholds
     *
     * @var array
     */
    public $level = array(
        false => false,   // none
        400 => 'ERROR',   // error
        300 => 'WARNING', // notice & warning
        200 => 'INFO',    // info
        100 => 'DEBUG',   // all (debug)
    );

    /**
     * Array of Loggers Formats
     *
     * @var array
     */
    public $format = array();

    /**
     * Array of Loggers Paths
     *
     * @var array
     */
    public $path = array();

    /**
     * MonologPackage Constructor
     * Add the DI Container to the class's properties
     *
     * @param   Symfony\Component\DependencyInjection\ContainerBuilder    $container
     *
     * @return  void
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * Generate Settings
     * Generate new Logger settings
     *
     * @param   string    $name
     * @param   int       $threshold
     * @param   string    $format
     *
     * @return  void
     */
    public function generateSettings($name, $threshold, $format)
    {
        $date = new DateTime();
        $this->format[$name] = $date->format($format);
        $this->path[$name] = $this->storage . $name . '/';
        $this->threshold[$name] = $threshold;
        return $this;
    }

    /**
     * Create New Logger
     * Create new Logger instance
     *
     * @param   string    $name
     *
     * @return  \Application\Packages\Monolog\MonologPackage $this
     */
    public function createNewLoggerInstance($name)
    {
        $this->logger[$name] = new Logger($name);
        return $this;
    }

    /**
     * Create New Stream
     * Create new Logger Stream
     *
     * @param   string    $name
     *
     * @return  \Application\Packages\Monolog\MonologPackage $this
     */
    public function createNewStream($name, $format, $threshold)
    {
        if ($threshold >= 0 && $threshold <= 4) {
            # code...
        }
        if (isset($this->threshold[$threshold])) {
            $getThresholdLevel = $this->threshold[$threshold];
        }
        if (isset($this->level[$getThresholdLevel])) {
            $realThresholdLevel = $this->level[$getThresholdLevel];
        }

        $this->logger[$name]->pushHandler(
            new StreamHandler(
                $this->path[$name] . $format,
                Logger::DEBUG
            )
        );
        return $this;
    }

    /**
     * Get Logger
     * Get existing Logger instance or Create a new one
     *
     * @param   string    $name
     * @param   int       $threshold
     * @param   string    $format
     *
     * @return  \Monolog\Logger
     */
    public function getLoggerInstance($name = 'Snopboy', $threshold = 4, $format = 'Y/m/d', $errorhandling = false)
    {
        return isset($this->logger[$name])
            ? $this->logger[$name]
            : $this->createNewLoggerInstance($name)->createNewStream($name, $format, $threshold)->registerErrorHandler($this->getLoggerInstance($name), $errorhandling);
    }

    /**
     * Register ErrorHandler
     * Override PHP's default error handling and reroute it to Monolog's ErrorHandler
     *
     * @return  void
     */
    public function registerErrorHandler(Logger $logger, $errorhandling = false)
    {
        $errorHandling == false ?: ErrorHandler::register($logger);
        return $logger;
    }
}
