<?php

namespace Tests\TestClasses\Deep;

use CascadeNamespaced\CascadeNamespaced;

/**
 * Class TestClass4
 */
class TestClass4
{

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return CascadeNamespaced::getLogger(get_called_class());
    }

}
