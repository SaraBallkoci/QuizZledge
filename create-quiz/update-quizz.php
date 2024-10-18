<?php
    //Database info
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de mise à jour du quiz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../dashboard/style.css">     
    <link rel="stylesheet" href="../dashboard/adminstyle.css">


</head>
<body id="update-quizz">

     <!-- start of php sesion -->
    <?php 
    ob_start();
    session_start();

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
        // If $_SESSION['user'] is not set, redirect to the login page
        header("Location: ../registerlogin/login.php");
        exit;
    }
    ?>
    <!-- end of php sesion -->
        
    <div class="container">
        <!-- start of navbar -->
        <div class="container-fluid position-absolute top-0 w-100 nav-bar">
            <nav id="nav-bar" class="navbar navbar-light bg-light navbar-expand-lg w-100 ">
                <div class="container-fluid"> 
                    <span class="Quizzlegde"><a class="navbar-brand" href="../dashboard/index.php" id="QuizZLedge" style="color:#0a5e78;">QuizZLedge</a></span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="toggleButton">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                        <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                            
                            <a class="navbar-nav  text-decoration-none ml-auto" href="#" id="homeLink" > Home </a>
                            <a class="navbar-nav  text-decoration-none ml-auto" href="" id="leaderboardLink"> Leaderboard</a>
                            <!-- <div class="navbar-nav ms-auto">
                                <div  class="navbar-nav ">
                                    <?php if ($isUser): ?>    
                                    <a class="username text-decoration-none ms-auto" href=""><img src="../images/<?php echo $image?>" class="img-fluid" id="avatar"></a>
                                    <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php" id="logoutLink">Logout</a>
                                    <?php else: ?>
                                    <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                                    <?php endif; ?>
                                </div>
                           </div> -->
                        </div>
                </div>
            </nav>
        </div>
    </div>

    <div id="confirmationMessage" class="alert alert-danger mt-5" style="display: none;">
</div>

    <div class="card mt-5" id="quiz-info">
            <div class="card-body">
                <h5 class="card-title">Quiz Details</h5>
                <div class="form-group">
                    <label for ="quizName">Quiz Name:</label>
                    <input type="text" class="form-control" id="quizName" placeholder="Do you really know me?">
                    <small style="display: none;" id="quizzNameError" class="form-text text-danger">This field is required.</small>

                </div>
                <div class="form-group">
                    <label for= "quizDescription">Quiz Description:</label>
                    <textarea class="form-control" id="quizDescription" rows="3" placeholder="Test your knowledge about me."></textarea>
                </div>

            </div>
        </div>

                <div id="addQuestionButtons" class="mt-3">
                    <button class="btn btn-danger ml-2" id="showQuestion1">1</button>
                   
                </div>
        <!-- Question Cards -->
        <div class="question-list mt-4">
           
            <!-- Question cards will be added here -->
        </div>
        
                <button class="btn btn-success mt-3" id="addQuestion">Add New Question</button>


        <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-danger" id="cancelCreation">Cancel</button>
            <button class="btn btn-primary" id="finishCreation" >Update quiz</button>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="quizPreview">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quiz Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="UpdateQuizzButton">Update quizz</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Get references to the "Home" and "Leaderboard" links
        var homeLink = document.getElementById('homeLink');
        var leaderboardLink = document.getElementById('leaderboardLink');
        var logoutLink = document.getElementById('logoutLink');


        // Add click event listeners to the links
        homeLink.addEventListener('click', function() {
            // Navigate to the home page
            window.location.href = '../dashboard/index.php'; // Replace with the actual URL
        });

        leaderboardLink.addEventListener('click', function() {
            // Navigate to the leaderboard page
            window.location.href = '../dashboard/categorie-session.php'; // Replace with the actual URL
        });      

    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="module" src="./script/globals.js"></script>
    <script type="module" src="./script/eventListener.js"></script>
    <script type="module" src="./script/manageCard.js"></script>
    <script type="module" src="./script/manageData.js"></script>
    <script type="module" src="./script/utils.js"></script>
</body>
 
</html>
