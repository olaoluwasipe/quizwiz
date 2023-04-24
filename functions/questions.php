<?php
include("conn.php");
require_once '../classes/Quiz/Quizzes.php';
require_once '../classes/Authentication/LoginProcess.php';
require_once '../classes/Authentication/SignUpProcess.php';
session_start();

$quiz = new QuizManager($db);

if(isset($_POST['addBank'])){
    $name = $_POST['title'];
    $description = $_POST['describe'];
    if($quiz->createQuestionBank($name, $description, $_SESSION['user_id'])){
        echo json_encode(array("success"=> "Question Bank created successfully"));
    }else{
        // echo $addBank->getErrors();
    }
}

if(isset($_POST['addQuiz'])){
    $name = $_POST['title'];
    $description = $_POST['describe'];
    $duration =  $_POST['duration'];
    $noOfQuestions = $_POST['noOfQuestions'];
    $scorePerQuestion = $_POST['score'];
    $dateStart = $_POST['startDate'];
    $dateEnd = $_POST['endDate'];
    $questionBank = $_POST['bank'];
    $isRandom = $_POST['random'];
    $showAnswers = $_POST['reveal'];
    $quizCode = substr(uniqid(), -10) . mt_rand(1000, 9999);
    if($quiz->createQuiz($name, $quizCode, $description, $_SESSION['user_id'], $duration, $noOfQuestions, $scorePerQuestion, $dateStart, $dateEnd, $questionBank, $isRandom, $showAnswers)){
        echo json_encode(array("success"=> "Quiz created successfully"));
    }else{
        // echo $addBank->getErrors();
    }
}

if(isset($_POST['deleteBank'])){
    $id = $_POST['deleteBank'];
    if($quiz->deleteBank($id)){
        echo json_encode(array("success" => "Question Bank successfully deleted"));
    }
}

if(isset($_POST['deleteQuestion'])){
    $id = $_POST['deleteQuestion'];
    if($db->delete("quiz_questions", "id=".$id)){
        echo json_encode(array("success" => "Question successfully deleted"));
    }
}

if(isset($_POST['newQuestion'])){
    $question = $_POST['question'];
    $options = serialize($_POST['option']);
    $answer = $_POST['answer'];
    $bank_id = $_POST['bank_id'];
    if($quiz->addQuestionToQuiz($bank_id, $question, $options, $answer)){
        echo json_encode(array("success"=> "Question added to bank successfully"));
    }else{
        echo json_encode(array("error"=> "Question failed to add to bank, please try again"));
    }
}

if(isset($_POST['updateQuestion'])){
    $where = 'id='. $_POST['quest_id'].' AND bank_id='.$_POST['bank_id'];
    $data = [
        'question' => $_POST['question'],
        'options' => serialize($_POST['option']),
        'answer' => $_POST['answer'],
    ];
    if($db->update('quiz_questions', $data, $where)){
        echo json_encode(array("success"=> "Question updated successfully"));
    }else{
        echo json_encode(array("error"=> "Question failed to update, please try again"));
    }
}

if(isset($_POST['bringResults'])){
    $quiz_id = $_POST['quiz_id'];
    $timeFinished = $_POST['timeFinished'];
    unset($_POST['quiz_id']);
    unset($_POST['bringResults']);
    unset($_POST['timeFinished']);
    $questions = array_keys($_POST);
    $answers = $_POST;

    $qui = $quiz->takeQuiz($quiz_id, $_SESSION['user_id'], $answers, $questions, $timeFinished);

    if($qui){
        echo json_encode(array("score"=>$qui));
    }
}

if(isset($_POST['enrolQuiz'])){
    $quizCode = $_POST['enrolQuiz'];
    $enrol = $quiz->enrolQuiz($_SESSION['user_id'], $quizCode);
    if(is_numeric($enrol)){
        echo json_encode(array("success" => "You have enrolled successfully"));
    }else{
        echo json_encode(array("errors" => $enrol));
    }
}

if(isset($_POST['updateQuiz'])){
    $where = 'id='. $_POST['updateQuiz'].' AND user_id='.$_SESSION['user_id'];
    $data = [
        'title' => $_POST['title'],
        'duration' => $_POST['duration'],
        'noOfQuestions' => $_POST['questions'],
        'scorePerQuestions' => $_POST['score'],
        'description' => $_POST['describe'],
        'dateScheduled' => $_POST['startDate'],
        'dateEnd' => $_POST['endDate'],
        'questionBank' => $_POST['bank'],
        'isRandom' => $_POST['random'],
        'showAnswers' => $_POST['reveal'],
    ];
    if($db->update('quizzes', $data, $where)){
        echo json_encode(array("success"=> "Quiz updated successfully"));
    }else{
        echo json_encode(array("error"=> "Quiz failed to update, please try again"));
    }
}

