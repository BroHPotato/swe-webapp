<?php

namespace Tests\Models;

use App\Providers\UserServiceProvider;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetAuthIdentifierName()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals('userId', $user->getAuthIdentifierName());
    }

    public function testGetWrongAuthIdentifier()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals(null, $user->getAuthIdentifier());
    }
    public function testGetAuthIdentifier()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals("0", $user->getAuthIdentifier());
    }

    public function testGetRole()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals("Amministratore", $user->getRole());
    }
    public function testGetPassword()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals("password", $user->getAuthPassword());
    }
    public function testGetTelegramName()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals("pippo", $user->getTelegramName());
    }
    public function testGetChatId()
    {
        $user = UserServiceProvider::GetAUser();
        $this->assertEquals("00000", $user->getChatId());
    }
    public function testDelete()
    {
        $user = UserServiceProvider::GetAUser();
        $user->setDeleted(true);
        $this->assertEquals(true, $user->getDeleted());
    }
}
