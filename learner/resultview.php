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
        $quizResults = $db->fetchOne("SELECT * FROM quiz_results WHERE user_id = ? AND quiz_id = ? ORDER BY id DESC LIMIT 1", [$user['id'], $quiz_id]);
    }
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
            <div class="sided">
                <div class="menuBtn">
                    <div id="closer" onclick="closeSide()"><i class="fas fa-bars"></i></div>
                    <div id="opener" onclick="openSide()"><i class="fas fa-bars"></i></div>
                </div>

                <div class="logo"><img src="favicon.png" alt="Logo"></div>
            </div>

            <div class="pageTitle">results</div>
        </div>

        <div class="end">

            <div class="prompt" onclick="newQuiz()">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <path d="M16 4C8.8 4 3 9.8 3 17s5.8 13 13 13 13-5.8 13-13S23.2 4 16 4zm0 24.1c-6.1 0-11.1-5-11.1-11.1S9.9 5.9 16 5.9s11.1 5 11.1 11.1-5 11.1-11.1 11.1zM3.7 7.7l4-4c.4-.4.4-1 0-1.4s-1-.4-1.4 0l-4 4c-.4.4-.4 1 0 1.4.2.2.4.3.7.3s.5-.1.7-.3zm26-1.4-4-4c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l4 4c.2.2.4.3.7.3s.5-.1.7-.3c.4-.4.4-1 0-1.4z"/>
                        <path d="M23.9 18h-.1c-.5-.1-.9-.5-.9-1s.4-.9.9-1H25c-.5-4.2-3.8-7.5-8-8V9.2c-.1.5-.5.9-1 .9s-.9-.4-1-.9V8c-4.2.5-7.5 3.8-8 8H8.2c.5.1.9.5.9 1s-.4.9-.9 1H7c.5 4.2 3.8 7.5 8 8V24.8c.1-.5.5-.9 1-.9s.9.4 1 .9V26c4.2-.5 7.5-3.8 8-8h-1.1c.1 0 .1 0 0 0zM20 18h-3v3c0 .5-.5 1-1 1s-1-.5-1-1v-3h-3c-.5 0-1-.5-1-1s.5-1 1-1h3v-3c0-.5.5-1 1-1s1 .5 1 1v3h3c.5 0 1 .5 1 1s-.5 1-1 1z"/>
                    </svg>
                </div>

                <div class="text">join quiz</div>
            </div>

            <div class="fullbox">

                <div class="icon"><i class="fas fa-envelope"></i></div>
                <div class="counter">20</div>

            </div>

            <div class="fullbox">

                <div class="icon"><i class="fas fa-bell"></i></div>
                <div class="counter">10</div>

            </div>

            <div class="dropDown">

                <div class="user">
                    <div class="name fulluserName"><?php echo $user['firstName']." ".$user['lastName'] ?></div>
                    <div class="role userRole"><?php echo $user['type'] == 0 ? "Learner" : "Tutor"; ?></div>
                </div>

                <div class="icon mini"><i class="fas fa-angle-down"></i></div>

                <div class="dropContent">
                    <a href="profile.php" class="dropped">profile</a>
                    <a href="settings.php" class="dropped">settings</a>
                    <form style="width: 100%;" action="../functions/auth.php" method="post">
                        <input type="hidden" name="logout" value="logout">
                        <button type="submit" class="dropped">logout</button>
                    </form>
                </div>
            </div>

        </div>
        

    </div>

    <div class="sidenav" id="sidenav">
        
        <div class="sidelinks">

            <a href="index.php" class="sidelink">
                
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.75 16.75a.75.75 0 0 0 0 1.5h10.5a.75.75 0 0 0 0-1.5H6.75Z"/>
                        <path d="M12 1.976c-.671 0-1.263.221-1.879.574-.59.337-1.262.833-2.089 1.442l-3.677 2.71c-1.06.78-1.798 1.322-2.202 2.123-.404.8-.404 1.716-.403 3.033v3.697c0 1.367 0 2.47.117 3.337.12.9.38 1.658.981 2.26.602.602 1.36.86 2.26.982.867.116 1.97.116 3.337.116h7.11c1.367 0 2.47 0 3.337-.116.9-.122 1.658-.38 2.26-.982.602-.602.86-1.36.982-2.26.116-.867.116-1.97.116-3.337v-3.697c0-1.317.001-2.233-.403-3.033-.404-.8-1.142-1.343-2.203-2.124l-3.676-2.709c-.827-.61-1.5-1.105-2.09-1.442-.615-.353-1.207-.574-1.878-.574Zm-3.114 3.25c.872-.642 1.475-1.085 1.98-1.375.49-.28.82-.375 1.134-.375.315 0 .645.096 1.133.375.506.29 1.11.733 1.981 1.375l3.5 2.58c1.259.927 1.671 1.254 1.894 1.695.223.441.242.967.242 2.53V15.5c0 1.435-.002 2.436-.103 3.192-.099.734-.28 1.122-.556 1.399-.277.277-.665.457-1.4.556-.755.101-1.756.103-3.191.103h-7c-1.435 0-2.437-.002-3.192-.103-.734-.099-1.122-.28-1.399-.556-.277-.277-.457-.665-.556-1.4-.101-.755-.103-1.756-.103-3.191v-3.468c0-1.564.019-2.09.242-2.53.223-.442.635-.77 1.894-1.697l3.5-2.579Z">
                    </svg>
                </div>

                <div class="text">dashboard</div>
                
            </a>

            <a href="quizzes.php" class="sidelink">
                
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <path d="M20 60H10a6.007 6.007 0 0 1-6-6V33a6.007 6.007 0 0 1 6-6h16a6.007 6.007 0 0 1 6 6v15a1 1 0 0 1-.293.707l-11 11A1 1 0 0 1 20 60ZM10 29a4.004 4.004 0 0 0-4 4v21a4.004 4.004 0 0 0 4 4h9.586L30 47.586V33a4.004 4.004 0 0 0-4-4Zm21 19Z"/>
                        <path d="M20 60a1 1 0 0 1-1-1v-6a6.007 6.007 0 0 1 6-6h6a1 1 0 0 1 .707 1.707l-11 11A1 1 0 0 1 20 60zm5-11a4.004 4.004 0 0 0-4 4v3.586L28.586 49zm-11.5-8a5.5 5.5 0 1 1 5.5-5.5 5.507 5.507 0 0 1-5.5 5.5zm0-9a3.5 3.5 0 1 0 3.5 3.5 3.504 3.504 0 0 0-3.5-3.5z"/>
                        <path d="M14 38a.999.999 0 0 1-.707-.293l-2-2a1 1 0 0 1 1.414-1.414l1.226 1.226 4.298-5.16a1 1 0 0 1 1.538 1.281l-5 6a1.002 1.002 0 0 1-.724.359zm12-5h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2zm1 3h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zM13.5 54a5.5 5.5 0 1 1 5.5-5.5 5.507 5.507 0 0 1-5.5 5.5zm0-9a3.5 3.5 0 1 0 3.5 3.5 3.504 3.504 0 0 0-3.5-3.5zM26 46h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z"/>
                        <path d="M39 46a21.32 21.32 0 0 1-4.197-.42 1 1 0 0 1 .394-1.96A19.295 19.295 0 0 0 39 44a19 19 0 1 0-18.97-19.951 1.017 1.017 0 0 1-1.049.95 1 1 0 0 1-.95-1.048A20.998 20.998 0 1 1 39 46Z"/>
                        <path d="M39 42a17.03 17.03 0 0 1-4.25-.532 1 1 0 1 1 .5-1.936 15.004 15.004 0 1 0-11.222-15.47 1 1 0 0 1-1.996-.124A17 17 0 1 1 39 42Z"/>
                        <path d="M39 28a3 3 0 1 1 3-3 3.003 3.003 0 0 1-3 3Zm0-4a1 1 0 1 0 1 1 1.001 1.001 0 0 0-1-1Z"/>
                        <path d="M37.586 24.586a.997.997 0 0 1-.707-.293l-2.828-2.829a1 1 0 0 1 1.414-1.414l2.828 2.829a1 1 0 0 1-.707 1.707zm2.828 0a1 1 0 0 1-.707-1.707l6.364-6.364a1 1 0 0 1 1.414 1.414l-6.364 6.364a.997.997 0 0 1-.707.293zM39 12a1 1 0 0 1-1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1-1 1zm0 29a1 1 0 0 1-1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1-1 1zm15-15h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2z"/>
                    </svg>
                </div>

                <div class="text">quizzes</div>
                
            </a>

            <a href="results.php" class="sidelink active">

                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <path d="M4.04 32.492a1.001 1.001 0 0 1-.999-.946A29.14 29.14 0 0 1 3 29.977l.004-.502a1 1 0 0 1 1-.982h.019a1 1 0 0 1 .98 1.018L5 29.977q0 .727.04 1.461a1 1 0 0 1-.946 1.053 1.001 1.001 0 0 1-.055.001zm.317-5.978a1 1 0 0 1-.988-1.16c.11-.683.246-1.366.404-2.032a1 1 0 1 1 1.946.462 26.584 26.584 0 0 0-.375 1.889 1 1 0 0 1-.987.84zm1.584-5.775a.988.988 0 0 1-.366-.07 1 1 0 0 1-.564-1.297c.25-.635.529-1.274.83-1.9a1 1 0 1 1 1.802.866c-.279.582-.539 1.177-.771 1.767a1.001 1.001 0 0 1-.93.634zm49.895-4.443a1 1 0 0 1-.853-.475c-.333-.54-.693-1.079-1.07-1.601a1 1 0 1 1 1.622-1.171c.406.562.792 1.14 1.152 1.723a1 1 0 0 1-.85 1.524zm-47.112-.862a1 1 0 0 1-.83-1.556c.384-.574.792-1.14 1.214-1.68a1 1 0 1 1 1.577 1.23 26.915 26.915 0 0 0-1.13 1.561 1 1 0 0 1-.831.445zm43.436-3.866a.997.997 0 0 1-.72-.306 27.035 27.035 0 0 0-1.387-1.34 1 1 0 1 1 1.337-1.487c.508.457 1.01.94 1.49 1.438a1 1 0 0 1-.72 1.695zm-39.592-.726a1 1 0 0 1-.694-1.72 29.738 29.738 0 0 1 1.539-1.383 1 1 0 1 1 1.283 1.533 27.89 27.89 0 0 0-1.434 1.29.998.998 0 0 1-.694.28zm34.998-3.117a.997.997 0 0 1-.556-.17 27.29 27.29 0 0 0-1.638-1.015 1 1 0 1 1 .992-1.736 29.3 29.3 0 0 1 1.76 1.09 1 1 0 0 1-.558 1.83zm-30.271-.556a1 1 0 0 1-.527-1.851c.583-.36 1.187-.705 1.797-1.024a1 1 0 1 1 .928 1.77c-.567.299-1.13.62-1.673.955a.999.999 0 0 1-.525.15zm24.97-2.226a.987.987 0 0 1-.366-.07 27.668 27.668 0 0 0-1.818-.642 1 1 0 0 1 .6-1.908c.654.205 1.31.437 1.951.69a1 1 0 0 1-.366 1.93zm-19.573-.358a1 1 0 0 1-.332-1.943c.647-.227 1.31-.435 1.976-.617a1 1 0 1 1 .527 1.93c-.619.168-1.237.362-1.839.573a1.001 1.001 0 0 1-.332.057zm13.8-1.228a.992.992 0 0 1-.16-.013 27.056 27.056 0 0 0-1.913-.239 1 1 0 0 1-.908-1.084 1.016 1.016 0 0 1 1.084-.908c.682.06 1.373.147 2.056.257a1 1 0 0 1-.158 1.987zm-7.972-.14a1 1 0 0 1-.122-1.993 28.896 28.896 0 0 1 2.059-.182l.055.999v1c-.588.032-1.232.088-1.868.168a.958.958 0 0 1-.124.007zm32.187 22.077-16-16A1 1 0 0 0 44 9H24a5.005 5.005 0 0 0-4.999 5v11.1a5.008 5.008 0 0 0-4 4.9v5a3.003 3.003 0 0 1-3 3h-1v-2a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1V62a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2h8.431A4.972 4.972 0 0 0 24 63h32a5.006 5.006 0 0 0 5-5V26a1 1 0 0 0-.293-.706zM45 12.414 57.586 25H48a3.003 3.003 0 0 1-3-3zM9.001 61h-4V37h4zm2-21h1a5.006 5.006 0 0 0 5-5v-5A3 3 0 1 1 23 30v7a1 1 0 0 0 1 1h8.811a4.999 4.999 0 0 1 4.919 5.895l-1.816 9.999A5 5 0 0 1 30.994 58H11zM56 61H24a2.985 2.985 0 0 1-2.229-1h9.222a6.998 6.998 0 0 0 6.887-5.748l1.817-10A6.998 6.998 0 0 0 32.812 36H25v-6a5.008 5.008 0 0 0-3.999-4.899v-11.1A3.003 3.003 0 0 1 24 11h19v11a5.006 5.006 0 0 0 5 5h11V58a3.003 3.003 0 0 1-3 3zm-9.183-16.414a1 1 0 0 0-1.82 0l-5 11a1 1 0 1 0 1.82.828l1.105-2.43c.027.002.05.016.078.016h5.9l1.096 2.414a1 1 0 1 0 1.82-.828zM43.824 52l2.083-4.583L47.99 52zM55 47a1 1 0 0 1-1 1h-1v1a1 1 0 0 1-2 0v-1h-1a1 1 0 0 1 0-2h1v-1a1 1 0 0 1 2 0v1h1a1 1 0 0 1 1 1zM39 18a1 1 0 0 1-1 1h-9a1 1 0 0 1 0-2h9a1 1 0 0 1 1 1zm-11 5a1 1 0 0 1 1-1h5a1 1 0 0 1 0 2h-5a1 1 0 0 1-1-1zm11 5a1 1 0 0 1-1 1h-9a1 1 0 0 1 0-2h9a1 1 0 0 1 1 1z" data-name="Layer 2"/>
                    </svg>
                </div>

                <div class="text">results</div>
                
            </a>

        </div>

        <a href="help.html" class="sidelink ender">

            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
                    <path d="M20 25.3c-.6 0-1-.4-1-1v-4.4c0-.6.4-1 1-1 2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4c0 .6-.4 1-1 1s-1-.4-1-1c0-3.3 2.7-6 6-6s6 2.7 6 6c0 3-2.2 5.4-5 5.9v3.5c0 .6-.4 1-1 1z"/>
                    <path d="M20 40C9 40 0 31 0 20S9 0 20 0c4.5 0 8.7 1.5 12.3 4.2.4.3.5 1 .2 1.4-.3.4-1 .5-1.4.2C27.9 3.3 24 2 20 2 10.1 2 2 10.1 2 20s8.1 18 18 18 18-8.1 18-18c0-3.2-.9-6.4-2.5-9.2-.3-.5-.1-1.1.3-1.4.5-.3 1.1-.1 1.4.3C39 12.9 40 16.4 40 20c0 11-9 20-20 20z"/>
                    <path d="M20 32.5c-.6 0-1-.4-1-1v-2.7c0-.6.4-1 1-1s1 .4 1 1v2.7c0 .6-.4 1-1 1z"/>
                </svg>
            </div>

            <div class="text">help</div>
            
        </a>

    </div>

    <div id="truePage">

        <div class="tdv">
            <div class="breadcrumbs">
                <a href="results.php" class="crumb">results</a>
                <i class="icon fas fa-angle-double-right"></i>
                <div class="curr"><?php echo $quiz['title'] ?></div>
            </div>

            <div class="rlv">

                <div class="axis">

                    <div class="quizzer">

                        <div class="top">
                            <div class="title"><?php echo $quiz['title'] ?></div>
                            <div class="schedule">
                                <div class="date"><i class="icon fas fa-calendar-alt"></i><?php echo date('d / m / Y', strtotime($quiz['dateScheduled'])); ?></div>
                                <div class="time"><i class="icon fas fa-stopwatch"></i> <?php echo $quiz['duration'] . ": 00" ?></div>
                            </div>
                        </div>

                        <div class="details">

                            <div class="port">
                                <div class="tag">duration</div>
                                <div class="unit"> <?php echo $quiz['duration'] ?> minutes</div>
                            </div>

                            <div class="port">
                                <div class="tag">number of questions</div>
                                <div class="unit"><?php echo $quiz['noOfQuestions'] ?></div>
                            </div>

                            <div class="port desc">
                                <div class="tag">Description</div>
                                <div class="unit">
                                    <?php echo $quiz['description']; ?>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="axis">

                    <div style="margin-bottom: 40px;" class="records">

                        <div class="topped">
                            <div class="heading">Results</div>
                        </div>

                        <table>

                            <tr>
                                <th>name</th>
                                <th>score</th>
                                <th>class average (%)</th>
                                <th>time submitted</th>
                            </tr>
                            
                            <tr>
                                <td><?php echo $user['firstName'] . " " . $user['lastName'] ?></td>
                                <td><?php echo $quizResults['score'] . "/" . ($quiz['scorePerQuestions'] * $quiz['noOfQuestions']); ?></td>
                                <td><?php echo $quizResults['percentage'] ?></td>
                                <td><?php echo $quizResults['timeFinished']; ?></td>
                            </tr>
                            
                        </table>

                    </div>

                    <?php if($quiz['showAnswers'] == "yes"){ ?>

                        <div class="question-list">

                            <div class="heading">question list</div>

                            <?php 
                                    $i = 0; 
                                    $results = unserialize($quizResults['result']);
                                foreach($results as $result){ $i++;
                                    $question = $db->fetchOne("SELECT * FROM quiz_questions WHERE id= ?", [array_search($result, $results)]);
                                    if(count($question) > 0){ ?>
                                        <div class="question">
                                            <div class="numb"><?php echo $i; ?></div>
                                            <div class="task">
                                                <div class="quest"><?php echo $question['question'] ?></div>
                                                <div class="subs">
                                                    <?php 
                                                        $letter = "A";
                                                        $code = ord($letter);
                                                        $options = unserialize($question['options']);
                                                        foreach($options as $option){ ?>
                                                            <div class="sub <?php echo $option==$question['answer'] ? "answer" : ""; echo $option==$result ? " uranswer" : ""; ?>">
                                                                <div class="const"><?php echo chr($code++); ?></div>
                                                                <div class="var"><?php echo $option; ?></div>
                                                            </div>
                                                        <?php }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                            ?>

                        </div>

                    <?php } ?>

                </div>

            </div>
        </div>

    </div>


    <div class="backdrop" id="backdrop"></div>

<form action="" method="post" class="joinForm" id="quizForm">

        <div class="top">

            <div class="header">Join quiz</div>

            <div class="actions">
                <button type="submit"><i class="icon fas fa-check"></i></button>

                <button type="button" onclick="closeSetup()"><i class="icon fas fa-times"></i></button>
            </div>

        </div>

        <div class="mid">

            <div class="heading">input quiz code to join the quiz</div>

            <div class="part">
                <label for="title">code</label>
                <input type="text" name="enrolQuiz" id="" placeholder="Quiz code">
            </div>

        </div>
    </form>


    
    <script src="assets/js/main.js"></script>
</body>
</html>