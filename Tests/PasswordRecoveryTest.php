<?php

use PHPUnit\Framework\TestCase;

require_once 'PHP/functions.php';

class PasswordRecoveryTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('sql8.freesqldatabase.com', 'sql8767118', 'ACVyISAule', 'sql8767118');
    }

    public function testPasswordRecoverySuccess()
    {
        $email = 'test@example.com';
        $password = 'NewPassword123!';
        $confirmPassword = 'NewPassword123!';

        $errors = validatePasswordData($email, $password, $confirmPassword, $this->conn);
        $this->assertEmpty($errors);

        $password = 'CorrectPassword123!';
        $result = updatePassword($email, $password, $this->conn);
        $this->assertTrue($result);
    }
}