<?php
namespace Users\Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Users\Entity\User'),
            'Class not found: ' . $class
        );
    }

    public function testIntantiationWithoutArgumentShouldWork()
    {
        $instance = new User();
        $this->assertInstanceOf(
            'Users\Entity\User',
            $instance
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsThrownWhenInvalidNameIsPassed()
    {
        $instance = new User();
        $invalidName = array();
        $instance->setName($invalidName);
    }

    public function testNameIsSetCorrectly()
    {
        $instance = new User();
        $name = 'Eduardo';
        $instance->setName($name);
        $this->assertEquals(
            $name,
            $instance->getName()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsThrownWhenInvalidEmailIsPassed()
    {
        $instance = new User();
        $invalidEmail = array();
        $instance->setEmail($invalidEmail);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsThrownWhenAlmosValidEmailIsPassed()
    {
        $instance = new User();
        $invalidEmail = 'eduardo@';
        $instance->setEmail($invalidEmail);
    }

    public function testEmailIsSetCorrectly()
    {
        $instance = new User();
        $email = 'eduardomrb@gmail.com';
        $instance->setEmail($email);
        $this->assertEquals(
            $email,
            $instance->getEmail()
        );
    }
}