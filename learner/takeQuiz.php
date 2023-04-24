<?php 
    session_start();
    include("../functions/conn.php");
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if($user['type'] !== 0){
            header("location: ../tutor");
        }
    }else{
        header("location: ../index.html");
    }
    if(isset($_GET['quiz_id'])){
        $quiz_id = $_GET['quiz_id'];
        $quiz = $db->fetchOne("SELECT * FROM quizzes WHERE id= ?", [$quiz_id]);
        if(count($quiz) > 0){
            if(empty($_SESSION['shuffle']) || $_SESSION['shuffle'] == "no"){
                if(empty($_SESSION['shuffle'])){
                    if($quiz['isRandom'] == "yes"){
                        $_SESSION['shuffle'] = "yes";
                    }else{
                        $_SESSION['shuffle'] = "no";
                    }
                }
                $questions = $db->fetchAll("SELECT * FROM quiz_questions WHERE bank_id=?", [$quiz['questionBank']]);
            }else{
                $questions = $_SESSION['shuffle'];
            }
            $scheuled =  strtotime($quiz['dateEnd']);
            if(time() >= $scheuled ){
                header("location: ../learner");
            }
        }
    }
    $banks = $db->fetchAll("SELECT * FROM questionbank");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD for tutors | QuizWiz</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css">

    <!-- PLUGINS -->
    <!-- FONT AWESOME --><link rel="stylesheet" href="assets/plugins/fontawesome.css">
    <!-- OWL CAROUSEL --><link rel="stylesheet" href="assets/plugins/owl.carousel.min.css">
    <!-- OWL CAROUSEL --><link rel="stylesheet" href="assets/plugins/owl.theme.default.min.css">

    <!-- JQUERY --><script src="assets/plugins/jquery.min.js"></script>
    <!-- FONT AWESOME --><script src="assets/plugins/fontawesome.js"></script>
    <!-- OWL CAROUSEL --><script src="assets/plugins/owl.carousel.min.js"></script>
</head>
<body>

    <div class="topnav">

        <div class="start">
            <div class="sided big">
                <div class="logo big"><img src="assets/img/logo.png" alt="Logo"></div>
            </div>

            <div class="pageTitle"><?php echo $quiz['title'] ?></div>
        </div>

        <div class="end">

            <div class="timer">
                <div class="icon fas fa-stopwatch"></div>
                <div class="time">08:30</div>
            </div>
           
            <div class="dropDown">

                <div class="user qp">
                    <div class="name">Nwabuikwu Chizuruoke</div>
                </div>
            </div>

        </div>
        

    </div>

    <div id="truePage" class="wide">

        <div class="quiz-content">

            <div class="top">

                <div class="ref">Quiz</div>

                <div class="quest-numbs">
                    <?php 
                        $i = 0;
                        foreach(array_slice($questions, 0, $quiz['noOfQuestions']) as $question){
                            $i++; ?>
                            <div class="question-tag"><?php echo $i; ?></div>
                        <?php }
                    ?>

                </div>

            </div>

            <form id="quizFormer" class="taking">

            <?php 
                $x = 0;
                if($_SESSION['shuffle'] == "yes"){
                    shuffle($questions);
                    $_SESSION['shuffle'] = $questions;
                }
                foreach(array_slice($questions, 0, $quiz['noOfQuestions']) as $question){
                    $s = 0;
                    if($x == 0){
                        $s = "show";
                    }
                    $x++; ?>
                        <div id="question<?php echo $x; ?>" class="question <?php echo $s; ?>">

                            <div class="quiz-que"><span class="numb"><?php echo $x ?>.</span><?php echo $question['question'] ?></div>

                            <div class="quiz-ops">
                                <?php 
                                    foreach(unserialize($question['options']) as $option){ ?>
                                        <label for="<?php echo $question['id'].$option ?>ans"><input id="<?php echo $question['id'].$option ?>ans" type="radio" value="<?php echo $option; ?>" name="<?php echo $question['id'] ?>"><?php echo $option; ?></label><br>
                                    <?php }
                                ?>

                            </div>
                            
                        </div>
                    
                <?php }
            ?>
                <input type="hidden" id="quizId" name="quiz_id" value="<?php echo $quiz_id ?>">
                <input type="hidden" name="bringResults" value="bringResults">
                <input type="hidden" id="timeFinished" name="timeFinished" value="">

                    <div class="controls">

                        <div class="start">
                            <button onclick="prevQuestion()" type="button" class="np prevBu"><i class="icon fas fa-caret-left"></i> previous</button>
                            <button onclick="nextQuestion()" type="button" class="np nextBu">next <i class="icon fas fa-caret-right"></i></button>
                        </div>

                        <div class="end">
                            <span onclick="newQuiz()" class="submitter"><i class="fas fa-dot-circle"></i> submit</span>
                        </div>

                    </div>
            </form>

        </div>
       
    </div>




    <div class="backdrop" id="backdrop"></div>

    <form action="" method="post" class="endForm" id="quizForm">

        <div class="top">

            <div class="header">Submit quiz</div>

        </div>

        <div class="mid">

            <div class="heading">Are you sure you want to end the quiz</div>
            <div class="emphasis">This cannot be undone and your score would be recorded immedately</div>
            
        </div>

        <div class="end">
            <div class="actions">
                <button id="submitQuiz" type="button"><i class="icon fas fa-check"></i></button>

                <button type="button" onclick="closeSetup()"><i class="icon fas fa-times"></i></button>
            </div>
        </div>
    </form>

    <script src="assets/js/main.js"></script>
    <script>
        countdown(<?php echo $quiz['duration']; ?>);
    </script>
</body>
</html>