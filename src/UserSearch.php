<?php

namespace App;

class UserSearch
{
    private $pdo;

    /**
     * UserSearch constructor.
     * @param \PDO $pdo
     * 
     * @return void
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Search users by name
     * 
     * @param string $name
     * @return array
     */
    public function searchByName(string $name): array
    {
        // Vulnerable: SQL Injection
        $query = "SELECT * FROM users WHERE name LIKE '%" . $name . "%'";
        
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Search users by name
     * 
     * @param string $name
     * @return array
     */
    public function searchByNameSafe(string $name): array
    {
        $query = "SELECT * FROM users WHERE name LIKE :name";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['name' => "%$name%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}