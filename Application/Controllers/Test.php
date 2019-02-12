<?php

namespace Application\Controllers;

use Application\Services;

class Test
{
    private $User;
    private $Test;
    private $Question;

    public function __construct()
    {
        if (!empty($_POST['Username']) && !empty($_POST['Testname'])) {
            $this->User = new Services\UserService($_POST['Username']);
            $this->Test = new Services\TestService($_POST['Testname'], $this->User->UserID);
            setcookie('User', $this->User->serialize(), time()+3600);
            setcookie('Test', $this->Test->serialize(), time()+3600);
        } elseif (!empty($_COOKIE['User']) && !empty($_COOKIE['Test'])) {
            $this->User = new Services\UserService(unserialize($_COOKIE['User']));
            $this->Test = new Services\TestService(unserialize($_COOKIE['Test']), $this->User->UserID);
        } else {
            $this->Test = null;
            $this->User = null;
        }
        $this->Question = new Services\QuestionService();
    }

    public function actionStart()
    {
        if(!empty($this->Test) && !empty($this->User)) {
            if (!empty($_POST['Answer'])) {
                $this->User->Answer = $_POST['Answer'];
                $this->registerAnswer();
            }
            $this->nextQuestion();
        } else {
            $tests = Services\TestService::getTestNames();
            require_once(APP . '/Views/MainPage.php');
        }
    }

    private function registerAnswer()
    {
        $this->Test->registerResult($this->User->Answer);
        $this->Question->QuestionID = $this->Test->QuestionID;
        $res = $this->Question->checkAnswer($this->User->Answer);
        if ($res) {
            $this->User->Result++;
        }
        $this->Test->QuestionID++;
        $this->Question->QuestionID++;
        setcookie('User', $this->User->serialize(), time()+3600);
        setcookie('Test', $this->Test->serialize(), time()+3600);
    }

    private function nextQuestion()
    {
        if ($this->Test->QuestionID <= $this->Test->LastQuestionID) {
            $this->Question->QuestionID = $this->Test->QuestionID;
            $this->Question->getQuestion();
            $questionNum = $this->Test->QuestionID - ($this->Test->LastQuestionID - ($this->Test->QuestionTotal));
            $percent = intval((100 / intval($this->Test->QuestionTotal)) * ($questionNum - 1));
            require_once(APP . '/Views/QuestionPage.php');
        } else {
            $this->publishResult();
        }
    }

    private function publishResult()
    {
        $this->User->registerRecord($this->Test->ID, $this->Test->RecordID);
        setcookie('User', '', -1);
        setcookie('Test', '', -1);
        require_once(APP . '/Views/ResultsPage.php');
    }

}