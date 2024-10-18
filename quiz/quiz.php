<?php
ob_start();
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "quizzledge";

//Create a connection
$db = new mysqli($servername, $username, $password, $database);

//Check connection
if ($db->connect_errno) {
    die("Connection failed: " . mysqli_connect_error());
}
// else{echo "connected"; }
// Fetch from session
//$amountOfQuestions = isset($_SESSION['amountOfQuestions']) ? $_SESSION['amountOfQuestions'] : 10; // default

$amountOfQuestions = 10;
$_SESSION['amountOfQuestions'] = $amountOfQuestions;

$category = "";
$privateQuizId = "";

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $isPrivate=false;
} else if (isset($_GET['privateQuizId'])) {
    $privateQuizId = $_GET['privateQuizId'];
    $_SESSION['category']=$privateQuizId;
    $isPrivate=true;

    $sql="SELECT idQuestion FROM question 
    WHERE idQuiz = '$privateQuizId'";
    $numQuestions = $db->query($sql);

    $amountOfQuestions = mysqli_num_rows($numQuestions);
    $_SESSION['amountOfQuestions'] = $amountOfQuestions;
}

/* 
// Validate amountOfQuestions
$amountOfQuestions = isset($_GET['q']) && is_numeric($_GET['q']) && $_GET['q'] >= 1 && $_GET['q'] <= 10 ? $_GET['q'] : 10;

// Validate category
$allowed_categories = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
$category = isset($_GET['c']) ? $_GET['c'] : 9; 
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="../common/styles.css">
    <link rel="stylesheet" href="quiz-style.css">
    <script>
        window.quizConfig = {
            amountOfQuestions: <?php echo json_encode($amountOfQuestions); ?>,
            category: <?php echo json_encode($category); ?>,
            privateQuizId: <?php echo json_encode($privateQuizId); ?>
        };
    </script>
    <script src="quiz.js"></script>
    <title>QuizZLedge</title>
</head>
<body>
    
    <!-- start of php session -->
    <?php 
    $isUser = false;

    // Check if the 'user' session variable is set
    if(isset($_SESSION['user'])) {
        $isUser = isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_SESSION['user']) && $_SESSION['user'] != 'admin';

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $db->prepare("SELECT avatar FROM user WHERE userName = ?");
        $stmt->bind_param("s", $_SESSION['user']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $image = $row['avatar'];
            }
        }
    } else {
        // No action if the user is not logged in
    }
    ?>
    <!-- end of php sesion -->
        
    <!-- start of navbar -->
    <div class="container">
        <div class="container-fluid position-absolute top-0 w-100 nav-bar">
            <nav id="nav-bar" class="navbar navbar-light bg-light navbar-expand-lg w-100 ">
                <div class="container-fluid"> 
                    <span class="Quizzlegde"><a class="navbar-brand" href="../dashboard/index.php" id="QuizZLedge" style="color:#0a5e78;">QuizZLedge</a></span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                    
                        <a class="navbar-nav  text-decoration-none ml-auto" href="../dashboard/index.php"> Home </a>
                        <a class="navbar-nav  text-decoration-none ml-auto" href="../dashboard/categorie-session.php"> Leaderboard</a>
                        <div class="navbar-nav ms-auto">   
                            <?php if ($isUser): ?>    
                            <a class="username text-decoration-none ms-auto" href=""><img src="../images/<?php echo $image?>" class="img-fluid" id="avatar" style="width:20%; float:right"></a>
                            <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php">Logout</a>
                            <?php else: ?>
                            <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                            <?php endif; ?>
                        </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- end of navbar -->

    <!-- start of main -->
    <main class="h-100" role="main">
        <div class="container pt-5 h-100">                            
            <div class="container h-100 d-flex flex-column justify-content-evenly align-items-center">
                <div class="progress-points-header mx-auto mt-3">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="points">
                            <span id="points-score">0</span>
                        </div>
                        <span>Points</span>
                    </div>
                    
                </div>

                <div class="container d-flex flex-column justify-content-center align-items-center">
                    <h4 id="question-count-text" class="text-center p-1 mt-3">Question <span id="question-count">1</span> of <span id="question-amount">10</span></h4> <!-- Count of the current question -->
                    <?php 
                    if (!$isPrivate) {
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "quizzledge";
                    
                        //Create a connection
                        $db = new mysqli($servername, $username, $password, $database);
                    
                        //Check connection
                        if ($db->connect_errno) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $sql = "SELECT image FROM online_quiz where categoryIndex='".$_SESSION['category']."'";
                        $res = mysqli_query($db, $sql);

                        if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $category = $row['image'];
                            
                            }
                        }
                    } 
                    ?>
                    
                    <?php if (!$isPrivate) { ?>
                        <img class="mx-auto col-8 col-sm-6 col-lg-4 img-fluid rounded-2" src="../images/<?php echo $category;?>" alt="...">
                    <?php } ?>
                    
                    <h2 id="question-text" class="text-center p-3 mt-3"></h2>
                    <div class="w-50 row row-cols-1 row-cols-sm-2 gx-5 gy-3">
                        <div data-answer-index="0" class="col">
                            <button type="button" class="answer w-100 shadow btn btn-light btn-block p-3"></button>
                        </div>
                        <div data-answer-index="1" class="col">
                            <button type="button" class="answer w-100 shadow btn btn-light btn-block p-3"></button>
                        </div>
                        <div data-answer-index="2" class="col">
                            <button type="button" class="answer w-100 shadow btn btn-light btn-block p-3"></button>
                        </div>
                        <div data-answer-index="3" class="col">
                            <button type="button" class="answer w-100 shadow btn btn-light btn-block p-3"></button>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="row">
                            <div class="col" id="skipCol">
                                <button type="button" id="skipButton" class="shadow btn btn-warning btn-block p-3">Skip</button>
                            </div>
                            <div class="col" id="nextCol" style="display: none;">
                                <button type="button" id="nextButton" class="shadow btn btn-block p-3" style="display: none; background-color: #0d637e; color:white;">Next</button>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </main>   
    <!-- end of main -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>