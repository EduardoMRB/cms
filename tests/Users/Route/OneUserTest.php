<?php
namespace Users\Route;

class OneUserTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
            interface_exists('Respect\Rest\Routable'),
            'Respect\Rest not installed.'
        );
        $this->assertTrue(
            class_exists($className = 'Users\Users'),
            'Expected class to exist: '.$className
        );
        $this->assertTrue(
            class_exists($className = 'Users\Route\OneUser'),
            'Expected class to exist: '.$className
        );
        $this->assertTrue(
            class_exists($className = 'Users\Route\AllUsers'),
            'Expected class to exist: '.$className
        );
    }

    public function setUp()
    {
        global $header;
        $header = array();
    }

    public function testHasGetMethod()
    {
        $reflection = new \ReflectionClass('Users\Route\OneUser');
        $this->assertTrue(
            $reflection->hasMethod($methodName = 'get'),
            'Expected method to exist: '.$methodName
        );
    }
}