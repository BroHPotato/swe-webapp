<?php

namespace Tests\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetAuthIdentifierName()
    {
        $user = new User();
        $this->assertEquals('userId', $user->getAuthIdentifierName());
    }

    public function testGetWrongAuthIdentifier()
    {
        $user = new User();
        $this->assertEquals(null, $user->getAuthIdentifier());
    }
}
