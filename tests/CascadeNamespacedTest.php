<?php

namespace Tests;

use CascadeNamespaced\CascadeNamespaced;
use PHPUnit\Framework\TestCase;
use Tests\TestClasses\Deep\TestClass3;
use Tests\TestClasses\Deep\TestClass4;
use Tests\TestClasses\TestClass1;
use Tests\TestClasses\TestClass2;

/**
 * Class CascadeNamespacedTest
 */
class CascadeNamespacedTest extends TestCase
{

    /**
     * @var TestClass1
     */
    private $testObject1;

    /**
     * @var TestClass2
     */
    private $testObject2;

    /**
     * @var TestClass3
     */
    private $testObject3;

    /**
     * @var TestClass4
     */
    private $testObject4;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->testObject1 = new TestClass1();
        $this->testObject2 = new TestClass2();
        $this->testObject3 = new TestClass3();
        $this->testObject4 = new TestClass4();
    }

    /**
     * Logger channel equals called class name if there is no defined loggers in config.
     */
    public function testGetLoggerBeforeConfig()
    {
        $this->assertEquals('Tests\TestClasses\TestClass1', $this->testObject1->getLogger()->getName());
    }

    /**
     * Use root logger with "Root channel for [called_class_name]" channel name if there is the "root"
     * channel defined in Cascade config and there are no specific namespace/class loggers defined.
     */
    public function testGetRootLogger()
    {
        CascadeNamespaced::fileConfig(__DIR__ . '/resources/root_logger.yml');

        $this->assertEquals('Root channel for Tests\TestClasses\TestClass1', $this->testObject1->getLogger()->getName());
        $this->assertEquals('Root channel for Tests\TestClasses\TestClass2', $this->testObject2->getLogger()->getName());
        $this->assertEquals('Root channel for Tests\TestClasses\Deep\TestClass3', $this->testObject3->getLogger()->getName());
        $this->assertEquals('Root channel for Tests\TestClasses\Deep\TestClass4', $this->testObject4->getLogger()->getName());
    }

    /**
     * Use namespace logger if defined. If class name is "Name\Space\MyClassName" and there is a "Name\Space" logger
     * defined in Cascade config then all "Name\Space\[...]\[called_class_name]" will get this logger.
     */
    public function testNamespaceLogger()
    {
        CascadeNamespaced::fileConfig(__DIR__ . '/resources/namespace_logger.yml');

        $this->assertEquals('Tests\TestClasses', $this->testObject1->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses', $this->testObject2->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses', $this->testObject3->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses', $this->testObject4->getLogger()->getName());
    }

    /**
     * If there are two namespace loggers defined in Cascade config and one is more specific then will more specific
     * logger will be returned.
     *
     * Example:
     *  Class: Name\Space\Deep\ClassName
     *  NameSpaceLogger1: Name\Space
     *  NameSpaceLogger2: Name\Space\Deep
     *
     * NamespaceLogger2 will be returned for a given class.
     */
    public function testNamespaceLoggerLongerNamespacesWin()
    {
        CascadeNamespaced::fileConfig(__DIR__ . '/resources/namespace_multiple_loggers.yml');

        $this->assertEquals('Tests\TestClasses', $this->testObject1->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses', $this->testObject2->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses\Deep', $this->testObject3->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses\Deep', $this->testObject4->getLogger()->getName());
    }

    /**
     * If there is a class name logger defined in Cascade config then it will be returned despite of defined loggers
     * for the namespaces.
     */
    public function testNamespaceAndClassLogger()
    {
        CascadeNamespaced::fileConfig(__DIR__ . '/resources/namespace_and_class_loggers.yml');

        $this->assertEquals('Root channel for Tests\TestClasses\TestClass1', $this->testObject1->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses\TestClass2', $this->testObject2->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses\Deep', $this->testObject3->getLogger()->getName());
        $this->assertEquals('Tests\TestClasses\Deep\TestClass4', $this->testObject4->getLogger()->getName());
    }

}
