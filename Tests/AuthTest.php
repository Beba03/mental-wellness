<?php

use PHPUnit\Framework\TestCase;

require_once 'PHP/functions.php';

class AuthTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('sql8.freesqldatabase.com', 'sql8767118', 'ACVyISAule', 'sql8767118');
    }

    public function testLoginSuccess()
    {
        $email = 'test@example.com';
        $password = 'CorrectPassword123!';
        $user = getUserByEmail($email, $this->conn);
        $this->assertTrue(verifyPassword($password, $user['password']));
    }

    public function testLoginFailure()
    {
        $email = 'test@example.com';
        $password = 'WrongPassword';
        $user = getUserByEmail($email, $this->conn);
        $this->assertFalse(verifyPassword($password, $user['password']));
    }
}