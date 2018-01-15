<?php

namespace CascadeNamespaced;

use Cascade\Cascade;
use Cascade\Config\ConfigLoader;

/**
 * Class CascadeNamespaced
 */
class CascadeNamespaced extends Cascade
{

    /**
     * {@inheritdoc}
     */
    public static function fileConfig($resource)
    {
        self::$config = new Config($resource, new ConfigLoader());
        self::$config->load();
        self::$config->configure();
    }

    /**
     * Get a Logger for namespace/class. Creates a new one if a Logger for the
     * provided namespace/class does not exist.
     *
     * @param string $name Namespace/class name of the requested Logger instance
     *
     * @return Logger Requested instance of Logger or new instance
     */
    public static function getLogger($name = 'root')
    {
        $loggers = array();

        if (!empty(self::$config)) {
            $loggers = self::getConfig()->getLoggers();
        }

        // Look for partial/full match (logger for namespace/class).
        foreach ($loggers as $loggerName => $logger) {
            if (strpos($name, $loggerName) !== false) {
                return $logger;
            }
        }

        if (isset($loggers['root'])) {
            // Return logger with channel == class name.
            return $loggers['root']->withName("Root channel for $name");
        }

        return parent::getLogger($name);
    }

}
