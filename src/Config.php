<?php

namespace CascadeNamespaced;

/**
 * Class Config
 */
class Config extends \Cascade\Config
{

    /**
     * Get loggers defined in Cascade config.
     *
     * @return Logger[]
     */
    public function getLoggers()
    {
        return $this->loggers;
    }

    /**
     * {@inheritdoc}
     */
    public function configureLoggers(array $loggers)
    {
        parent::configureLoggers($loggers);

        // Sort loggers: more longest names comes first.
        uasort($this->loggers, function ($a, $b) {
            return strlen($a->getName()) > strlen($b->getName()) ? -1 : 1;
        });
    }

}
