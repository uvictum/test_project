<?php
/**
 * Created by PhpStorm.
 * User: vmorgan
 * Date: 10.02.19
 * Time: 12:46
 */

namespace Application\Services;

use Application\Components\ConnectDatabase;

class TestService
{
    private $ID;
    private $QuestionID;
    private $LastQuestionID;
    private $QuestionTotal;
    private $pdo;
    private $UserID;
    private $RecordID;

    public function __construct($TestInfo, $UserID)
    {
        $this->UserID = $UserID;
        $this->pdo = ConnectDatabase::establishConnection(1);
        if (gettype($TestInfo) == 'string') {
            $this->createNew($TestInfo);
        } else if (gettype($TestInfo) == 'array') {
            $this->recreateTest($TestInfo);
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    private function createNew($testname)
    {
        try {
            $sql = "SELECT * FROM Tests WHERE Testname = :Testname";
            $stmnt = $this->pdo->prepare($sql);
            $stmnt->execute(Array(':Testname' => $testname));
            $res = $stmnt->fetch(\PDO::FETCH_ASSOC);
            $this->ID = $res['ID'];
            $this->QuestionID = $res['FirstQuestionID'];
            $this->QuestionTotal = $res['QuestionTotal'];
            $this->LastQuestionID = $res['LastQuestionID'];
            $sql = "INSERT INTO TestResults_$this->ID (UserID) VALUES ($this->UserID)";
            $stmnt = $this->pdo->query($sql);
            $this->RecordID = $this->pdo->lastInsertId();
        } catch (\Exception $err) {
            header('HTTP/1.0 400 Bad error');
            echo $err->getMessage();
            die;
        }
    }

    public function recreateTest($test)
    {
        if (preg_match("/^[0-9]{1,8}$/", $test['ID'])) {
            $this->ID = $test['ID'];
            $this->QuestionID = $test['QuestionID'];
            $this->QuestionTotal = $test['QuestionTotal'];
            $this->LastQuestionID = $test['LastQuestionId'];
            $this->RecordID = $test['RecordID'];
        }
        return null;
    }

    public function registerResult($answer)
    {
        $sql = "UPDATE TestResults_$this->ID SET Answer_Question_$this->QuestionID = $answer WHERE ID = $this->RecordID";
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute();
    }

    public static function getTestNames()
    {
        $sql = "SELECT Tests.Testname FROM Tests";
        $pdo = ConnectDatabase::establishConnection(1);
        $stmnt = $pdo->query($sql);
        return($stmnt->fetch(\PDO::FETCH_ASSOC));
    }

    public function serialize()
    {
        $test = Array();
        $test['ID'] = $this->ID;
        $test['QuestionID'] = $this->QuestionID;
        $test['QuestionTotal'] = $this->QuestionTotal;
        $test['LastQuestionId'] = $this->LastQuestionID;
        $test['RecordID'] = $this->RecordID;
        $test['UserID'] = $this->UserID;
        return serialize($test);
    }

}