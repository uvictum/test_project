<?php

namespace Application\Components;

class Setup
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::establishConnection(null);
    }

    public function setupDB()
    {
        require (ROOT . '/Config/database.php');
        $sql = "CREATE DATABASE $DB_NAME";
        try {
            $this->pdo->query($sql);
            $this->pdo = null;
            $this->pdo = ConnectDatabase::establishConnection(1);
            $sql = file_get_contents(ROOT . '/sql/setup.sql');
            $this->pdo->query($sql);
        } catch (\PDOException $err) {
            echo $err->getMessage();
        }
        $this->pdo = null;
    }
}