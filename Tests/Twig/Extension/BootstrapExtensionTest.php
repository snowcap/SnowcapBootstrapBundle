<?php

namespace Snowcap\BootstrapBundle\Tests\Twig\Extension;

use Snowcap\BootstrapBundle\Twig\Extension\BootstrapExtension;

class BootstrapExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BootstrapExtension
     */
    private $extension;

    /**
     * Sets the extension
     */
    public function setUp()
    {
        $this->extension = new BootstrapExtension();
    }

    /**
     * Test that the name is correctly set
     */
    public function testGetName()
    {
        $this->assertSame('snowcap_bootstrap', $this->extension->getName(), 'getName: ');
    }

    /**
     * Test that the functions are correctly set
     */
    public function testGetFunctions()
    {
        $filters = $this->extension->getFunctions();
        $this->assertEquals(count($filters), 1);
        $filter = $filters[0];
        $this->assertInstanceOf('\Twig_SimpleFunction', $filter);
        $this->assertEquals('form_row_classes', $filter->getName());
    }

    /**
     * Test the getFormRowClasses method
     */
    public function testGetFormRowClasses()
    {
        $this->assertEquals('type_foo', $this->extension->getFormRowClasses(['foo']));
        $this->assertEquals('type_bar', $this->extension->getFormRowClasses(['bar']));
        $this->assertEquals('type_foo type_bar', $this->extension->getFormRowClasses(['foo', 'bar']));
    }
}