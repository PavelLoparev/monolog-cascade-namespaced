<?php

namespace Tests\TestClasses;

use CascadeNamespaced\CascadeNamespaced;

/**
 * Class TestClass2
 */
class TestClass2
{

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return CascadeNamespaced::getLogger(get_called_class());
    }

}
