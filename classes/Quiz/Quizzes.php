<?php
class QuizManager {
    private $db;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
    }

    // Create a new quiz
    public function createQuiz($name, $quizCode, $description, $userId, $duration, $noOfQuestions, $scorePerQuestions, $dateStart, $dateEnd, $questionBank, $isRandom, $showAnswers) {
        $dateCreated = time();
        $this->db->query('INSERT INTO quizzes (title, quizCode, description, user_id, duration, noOfQuestions, scorePerQuestions, dateScheduled, dateEnd, questionBank, isRandom, showAnswers, dateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name, $quizCode, $description, $userId, $duration, $noOfQuestions, $scorePerQuestions, $dateStart, $dateEnd, $questionBank, $isRandom, $showAnswers, $dateCreated]);
        return $this->db->getLastInsertId();
    }

    // Create a question bank
    public function createQuestionBank($name, $description, $userId) {
        $dateCreated = time();
        $this->db->query('INSERT INTO questionbank (name, description, user_id, dateCreated) VALUES (?, ?, ?, ?)', [$name, $description, $userId, $dateCreated]);
        return $this->db->getLastInsertId();
    }

    // Delete a quiz
    public function deleteQuiz($quizId) {
        $this->db->query('DELETE FROM quizzes WHERE id = ?', [$quizId]);
        $this->db->query('DELETE FROM quiz_questions WHERE quiz_id = ?', [$quizId]);
        $this->db->query('DELETE FROM quiz_results WHERE quiz_id = ?', [$quizId]);
        return true;
    }

    // Delete a quiz
    public function deleteBank($quizId) {
        $this->db->query('DELETE FROM questionbank WHERE id = ?', [$quizId]);
        $this->db->query('DELETE FROM quiz_questions WHERE bank_id = ?', [$quizId]);
        $this->db->query('DELETE FROM quiz_results WHERE bank_id = ?', [$quizId]);
        return true;
    }

    // Add a question to a quiz
    public function addQuestionToQuiz($bankId, $question, $options, $answer) {
        $userId = $_SESSION['user_id'];
        $dateCreated = time();
        $this->db->query('INSERT INTO quiz_questions (bank_id, question, options, answer, user_id, dateCreated) VALUES (?, ?, ?, ?, ?, ?)', [$bankId, $question, $options, $answer, $userId, $dateCreated]);
        return $this->db->getLastInsertId();
    }

    // Add a student to a quiz
    public function enrolQuiz($userId, $quizCode) {
        if($_SESSION['user_id'] == $userId){
            if($_SESSION['user']['type'] == 0){
                $dateCreated = time();
                $quiz = $this->db->fetchOne("SELECT * FROM quizzes WHERE quizCode = ?", [$quizCode]);
                if(!$quiz){
                    return "This Quiz Code Doesn't Exist, please try another";
                }else{
                    $quizId = $quiz['id'];
                    $checkEnrolls = $this->db->fetchOne("SELECT * FROM quiz_enrolls WHERE quiz_id = ? AND user_id = ?", [$quizId, $userId]);
                    is_countable($checkEnrolls) ? $checkEnrolls = $checkEnrolls : $checkEnrolls = array();
                    if(count($checkEnrolls) > 0){
                        return "You're already enrolled to this quiz!";
                    }else{
                        $this->db->query('INSERT INTO quiz_enrolls (quiz_id, user_id, dateEnrolled) VALUES (?, ?, ?)', [$quizId, $userId, $dateCreated]);
                        return $this->db->getLastInsertId();
                    }
                }
            }
        }
    }

    // Get a list of quizzes
    public function getQuizzes() {
        return $this->db->fetchAll('SELECT * FROM quizzes');
    }

    // Get a quiz by ID
    public function getQuizById($quizId) {
        return $this->db->fetchOne('SELECT * FROM quizzes WHERE id = ?', [$quizId]);
    }

    // Take a quiz and save the results
    public function takeQuiz($quizId, $userId, $answers, $questions, $timeFinished) {
        $correctAnswers = 0;
        $dateTaken = time();
        $results = serialize($answers);
        $quiz = $this->db->fetchOne('SELECT * FROM quizzes WHERE id = ?', [$quizId]);
        foreach($answers as $ansQu){
            $questionsOpt = $this->db->fetchOne('SELECT * FROM quiz_questions WHERE id = ?', [array_search($ansQu, $answers)]);
            $answer = $questionsOpt['answer'];
            if($answer == $ansQu){
                $correctAnswers++;
            }
        }

        $score = $correctAnswers * intval($quiz['scorePerQuestions']);
        $percentage = $correctAnswers / count($questions) * 100;
        $this->db->query('INSERT INTO quiz_results (quiz_id, user_id, score, percentage, result, timeFinished, dateTaken) VALUES (?, ?, ?, ?, ?, ?, ?)', [$quizId, $userId, $score, $percentage, $results, $timeFinished, $dateTaken]);
        return $score . "/" . (count($questions)  * intval($quiz['scorePerQuestions']));
    }

    // Get quiz results for a user
    public function getQuizResults($quizId, $userId) {
        return $this->db->fetchOne('SELECT * FROM quiz_results WHERE quiz_id = ? AND user_id = ?', [$quizId, $userId]);
    }
}
