<?php

namespace Tests\TestClasses\Deep;

use CascadeNamespaced\CascadeNamespaced;

/**
 * Class TestClass3
 */
class TestClass3
{

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return CascadeNamespaced::getLogger(get_called_class());
    }

}
