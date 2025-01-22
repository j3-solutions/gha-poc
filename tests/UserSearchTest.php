<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\UserSearch;

class UserSearchTest extends TestCase
{
    private $pdo;
    private $userSearch;

    protected function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT)');
        $this->pdo->exec("INSERT INTO users (name) VALUES ('John Doe')");
        $this->pdo->exec("INSERT INTO users (name) VALUES ('Jane Doe')");
        
        $this->userSearch = new UserSearch($this->pdo);
    }

    public function testSearchByName(): void
    {
        $result = $this->userSearch->searchByName('John');
        $this->assertCount(1, $result);
        $this->assertEquals('John Doe', $result[0]['name']);
    }

    public function testSearchByNameSafe(): void
    {
        $result = $this->userSearch->searchByNameSafe('John');
        $this->assertCount(1, $result);
        $this->assertEquals('John Doe', $result[0]['name']);
    }
}