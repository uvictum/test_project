<?php
namespace Application\Components;

/**
 * Class ConnectDatabase
 * @package Application\Components
 */
class ConnectDatabase
{
    /**
     * Method checks whether the database exists
     * @return bool
     */
    public static function checkConnection()
    {
        require (ROOT . '/Config/database.php');
        try {
            $pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo = null;
            return TRUE;
        } catch (\PDOException $err) {
            echo 'Database not found<br/>';
            return FALSE;
        }
    }

    /**
     * Method has two modes, if mode == null method connects
     * directly to the host for creating a database. Another creates
     * connection to database selected from config file.
     * @param $mode
     * @return bool|\PDO
     */
    public static function establishConnection($mode)
    {
        require (ROOT . '/Config/database.php');
        try {
            if (!empty($mode)) {
                $pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            } else {
                $pdo = new \PDO($DB_DSN_SETUP, $DB_USER, $DB_PASSWORD);
            }
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $err) {
            echo ('Connection Failed: ' . $err->getMessage());
            return FALSE;
        }
    }
}