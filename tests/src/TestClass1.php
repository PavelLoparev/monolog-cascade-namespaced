<?php

namespace Tests\TestClasses;

use CascadeNamespaced\CascadeNamespaced;

/**
 * Class TestClass1
 */
class TestClass1
{

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return CascadeNamespaced::getLogger(get_called_class());
    }

}
