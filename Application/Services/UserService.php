<?php
/**
 * Created by PhpStorm.
 * User: vmorgan
 * Date: 10.02.19
 * Time: 12:17
 */

namespace Application\Services;

use Application\Components\ConnectDatabase;

class UserService
{
    private $UserID;
    private $Username;
    private $Result;
    private $Answer;
    private $pdo;

    public function __construct($UserInfo)
    {
        $this->pdo = ConnectDatabase::establishConnection(1);
        if ((gettype($UserInfo) == 'string')) {
            $this->createNew($UserInfo);
        } else if (gettype($UserInfo) == 'array') {
            $this->recreateUser($UserInfo);
        } else {
           return null;
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    private function createNew($username)
    {
        try {
            $res = $this->validateUsername($username);
            if (empty($res)) {
                $sql = "INSERT INTO Users(Username) VALUES (:Username);";
                $stmnt = $this->pdo->prepare($sql);
                $stmnt->execute(Array(':Username' => $username));
                $this->UserID = $this->pdo->lastInsertId();
            } else {
                $this->UserID = $res['ID'];
            }
            $this->Username = $username;
            $this->Result = 0;
        } catch (\Exception $err) {
            header('HTTP/1.0 400 Bad error');
            echo $err->getMessage();
            die;
        }
    }

    public function registerRecord($testID, $recordID)
    {
        $sql = "INSERT INTO UserRecords(UserID, TestID, Result, RecordID)
                VALUES ($this->UserID, $testID, $this->Result, $recordID);";
        $this->pdo->query($sql);
    }

    private function validateUsername($username)
    {
        if (preg_match("/^[A-z0-9-_]{1,16}$/", $username)) {
            $sql = "SELECT Users.ID FROM Users WHERE Username = :Username;";
            $stmnt = $this->pdo->prepare($sql);
            $stmnt->execute(Array(':Username' => $username));
            return $stmnt->fetch();
        } else {
            throw new \Exception("Wrong Username please check input");
        }
    }

    private function recreateUser($User)
    {
        if (preg_match("/^[0-9]{1,8}$/", $User['UserID'])) {
            $this->UserID = $User['UserID'];
            $this->Result = $User['Result'];
            $this->Username = $User['Username'];
        }
        return null;
    }

    public function serialize()
    {
        $User = Array();
        $User['UserID'] = $this->UserID;
        $User['Result'] = $this->Result;
        $User['Username'] = $this->Username;
        return serialize($User);
    }
}