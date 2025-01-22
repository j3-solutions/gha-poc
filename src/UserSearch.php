<?php

namespace App;

class UserSearch
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function searchByName(string $name): array
    {
        // Vulnerable: SQL Injection
        $query = "SELECT * FROM users WHERE name LIKE '%" . $name . "%'";
        
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Versión segura para comparar
    public function searchByNameSafe(string $name): array
    {
        $query = "SELECT * FROM users WHERE name LIKE :name";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['name' => "%$name%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}