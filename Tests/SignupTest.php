<?php

use PHPUnit\Framework\TestCase;

require_once 'PHP/functions.php';

class SignupTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('sql8.freesqldatabase.com', 'sql8767118', 'ACVyISAule', 'sql8767118');
    }
    
    public function testSignupEmailExists()
    {
        $name = 'Test';
        $email = 'newuser@example.com';
        $password = 'NewPassword123!';
        $confirmPassword = 'NewPassword123!';

        $errors = validateSignupData($name, $email, $password, $confirmPassword, $this->conn);
        $this->assertContains('Email is already registered.', $errors);
    }
}