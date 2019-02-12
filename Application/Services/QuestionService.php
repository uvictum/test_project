<?php
/**
 * Created by PhpStorm.
 * User: vmorgan
 * Date: 10.02.19
 * Time: 12:50
 */

namespace Application\Services;


use Application\Components\ConnectDatabase;

class QuestionService
{
    public $QuestionData;
    public $Answers;
    public $QuestionID;
    private $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::establishConnection(1);
    }

    public function setQuestionID($value)
    {
        $this->QuestionID = $value;
    }

    public function getQuestion()
    {
        $sql = "SELECT Questions.QuestionText FROM Questions WHERE ID = $this->QuestionID";
        $stmnt =$this->pdo->query($sql);
        $text = $stmnt->fetch(\PDO::FETCH_ASSOC);
        $sql = "SELECT Answers.Answer, Answers.ID FROM Answers WHERE QuestionID = $this->QuestionID";
        $stmnt =$this->pdo->query($sql);
        $answers = $stmnt->fetchAll(\PDO::FETCH_ASSOC);
        $this->QuestionData['QuestionText'] = $text['QuestionText'];
        $this->QuestionData['Answers'] = $answers;
    }

    public function checkAnswer($Answer)
    {
        $sql = "SELECT Questions.CorrectAnswerID FROM Questions WHERE ID = $this->QuestionID";
        $stmnt = $this->pdo->query($sql);
        $res = $stmnt->fetch();
        if ($Answer == $res['CorrectAnswerID'])
            return true;
        return false;
    }

}