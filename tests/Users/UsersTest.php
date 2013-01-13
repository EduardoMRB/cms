<?php
namespace Users;

use Users\Users;
use Users\DataAccess\DataAccess;
use Users\Entity\User;

class UsersTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name']             = 'Eduardo';
        $_POST['email']            = 'eduardomrb@gmail.com';
        $_POST['password']         = '123456';
    }

    public function testInstantiation()
    {
        $mockedClassName  = 'Users\DataAccess\DataAccess';
        $mockedDataAccess = $this->getMockBuilder($mockedClassName)
                                 ->disableOriginalConstructor()
                                 ->getMock();

        $this->assertInstanceOf(
            $expected = 'Users\Users',
            $result = new Users($mockedDataAccess)
        );
        return $mockedDataAccess;
    }

    /**
     * @depends testInstantiation
     * @expectedException \UnexpectedValueException
     */
    public function testAcceptFromUserInputWithInvalidData($mockedDataAccess)
    {
        $_POST['name'] = '';

        $users = new Users($mockedDataAccess);
        $users->acceptFromUserInput();

        return $mockedDataAccess;
    }

    /**
     * @depends testAcceptFromUserInputWithInvalidData
     */
    public function testAcceptFromUserInputWithValidData()
    {
        $mockedClassname  = 'Users\DataAccess\DataAccess';
        $methods          = array('insert');
        $mockedDataAccess = $this->getMockBuilder($mockedClassname)
                                 ->setMethods($methods)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $mockedDataAccess->expects($this->once())
                         ->method('insert')
                         ->will($this->returnValue($expected = 1));
        $users = new Users($mockedDataAccess);

        $id = $users->acceptFromUserInput();

        $this->assertInternalType('int', $id);
        $this->assertGreaterThanOrEqual(1, $id);
    }
}