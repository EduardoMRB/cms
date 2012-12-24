<?php
namespace Users\DataAccess;

use \PDO;
use Users\Entity\User;
use Users\DataAccess\DataAccess;

class DataAccessTest extends \PHPUnit_Framework_TestCase
{
    protected $pdo;

    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Users\DataAccess\DataAccess'),
            'Class not found: ' . $class
        );
    }

    protected function setUp()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=test_cms', 'root', 'asdzxc');

            $this->pdo->exec('
                CREATE TABLE IF NOT EXISTS user (
                    id INTEGER PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(255),
                    email VARCHAR(255),
                    password VARCHAR(255)
                );
            ');
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function tearDown()
    {
        $this->pdo->exec('DROP TABLE user');
    }

    public function testInsertUser()
    {
        $user2Insert = new User();
        $user2Insert->setName('Eduardo')
                    ->setEmail('eduardomrb@gmail.com')
                    ->setPassword('asdzxc');

        $dataAccess = new DataAccess($this->pdo);
        $id = $dataAccess->insert($user2Insert);

        $this->assertEquals(
            1,
            $id
        );

        $insertedUser = $dataAccess->getById($id);

        $this->assertInstanceOf(
            'Users\Entity\User',
            $insertedUser
        );

        $this->assertEquals(
            $user2Insert->getName(),
            $insertedUser->getName()
        );

        $this->assertEquals(
            $user2Insert->getEmail(),
            $insertedUser->getEmail()
        );

        $this->assertEquals(
            $user2Insert->getPassword(),
            $insertedUser->getPassword()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInsertWithAnInvalidArgument()
    {
        $dataAccess = new DataAccess($this->pdo);

        $dataAccess->getById(null);
    }

    /**
     * @expectedException \RunTimeException
     * @expectedExceptionMessage Fail to retrieve user
     */
    public function testInsertTrhowsARuntimeErrorWhenIdIsNotFound()
    {
        $dataAccess = new DataAccess($this->pdo);
        $dataAccess->getById(-1);
    }
}