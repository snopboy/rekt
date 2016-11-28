<?php

namespace Application\Packages\Monolog;

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Application\Packages\Monolog\MonologPackage;
use Symfony\Component\DependencyInjection\ContainerBuilder;

////////////////////////////////////////////////////////
// Recognition                                        //
////////////////////////////////////////////////////////
// Thanks to Taylor Otwell and the developers behind  //
// Laravel framework for the Monolog adapter API      //
////////////////////////////////////////////////////////

/**
 *
 */
class MonologAdapter extends MonologPackage
{

    /**
     * Singleton
     *
     * @var Application\Packages\Monolog\MonologAdapter
     */
    public static $instance = null;

    /**
     * Singleton
     *
     * @var Application\Packages\Monolog\MonologPackage
     */
    public $package = null;

    /**
     * MonologAdapter Constructor
     *
     * @return  void
     */
    public static function register()
    {
        self::$instance === null ? return self::$instance = new self() : return self::$instance;
    }

    /**
     * MonologAdapter Constructor
     *
     * @return  void
     */
    public function globalise()
    {
//        class_exists('\Logger')
//        ? die('Class \Logger already exists!')
//        : class_alias('\Application\Packages\Monolog\MonologAdapter', 'Logger');
        // which one would you prefer? a short ternary with die() func or a full if-else with an Exception?
        if (class_exists('\Logger')) {
            throw new \Exception('Class \Logger already exists!');
        }
        else {
            class_alias('\Application\Packages\Monolog\MonologAdapter', 'Logger');
        }
    }

    /**
     * MonologAdapter Constructor
     * Add the DI Container to the class's properties
     *
     * @param   Symfony\Component\DependencyInjection\ContainerBuilder    $container
     *
     * @return  void
     */
    public function handle(ContainerBuilder $container)
    {
        $this->threshold = \Config::get('logger.threshold');
        $this-$this->package->getLoggerInstance(\Config::get('app.name'), \Config::get('logger.threshold'), \Config::get('logger.format'))
        $this->package === null ? return $this->package = new MonologPackage($container) : return $this->package;
    }

    /**
     * Log an emergency message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function emergency($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function alert($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function critical($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function error($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function warning($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function notice($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function info($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * 
     * @return void
     */
    public static function debug($message, array $context = [])
    {
        return self::writeToLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a message to the logs.
     *
     * @param  string  $level
     * @param  string  $message
     * @param  array  $context
     *
     * @return void
     */
    public static function log($level, $message, array $context = [])
    {
        return self::writeToLog($level, $message, $context);
    }

    /**
     * Title
     * Description
     *
     * @param   string    $var
     *
     * @return  void
     */
    private function writeToLog($level, $message, $context)
    {
        $threshold = $this->threshold;
        $package = $this->package;
        $logger = $this->package->logger;
        $package->threshold[$level]
    }

}
