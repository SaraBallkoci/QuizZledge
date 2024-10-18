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
    <title>Created Quizzes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../dashboard/style.css">     
    <link rel="stylesheet" href="../dashboard/adminstyle.css">  
    <link rel="stylesheet" href="list-quizzes.css">
</head>

<body id="list-quizzes">

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
                            <div class="navbar-nav ms-auto">
                                <div  class="navbar-nav ">
                                    <?php if ($isUser): ?>    
                                    <a class="username text-decoration-none ms-auto" href=""><img src="../images/<?php echo $image?>" class="img-fluid" id="avatar"></a>
                                    <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php" id="logoutLink">Logout</a>
                                    <?php else: ?>
                                    <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                                    <?php endif; ?>
                                </div>
                           </div>
                        </div>
                </div>
            </nav>
        </div>
    </div>

    <div id="confirmationMessage" class="alert alert-success mt-5" style="display: none;">
  
</div>
    <div class="container mt-5 space">
        <div class="d-flex justify-content-between align-items-center">
            <h1>List of Created Quizzes</h1>
            <button class="btn btn-success btn-sm add-quiz-button">Add New Quiz</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Quiz Name</th>
                    <th>Quiz Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="quiz-table">
               
            </tbody>
        </table>
    </div>



 <!-- Delete Quiz Modal -->
<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Quiz</h5>
               
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this quiz?</p>
            </div>

             <div class="modal-footer">
                    <button type="button" class="btn btn-secondary ml-auto" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>

                <button type="button" class="btn btn-danger" id="deleteQuizzButton">Delete</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script type="module" src="./script/eventListener.js"></script>
    <script type="module" src="./script/manageData.js"></script>
    <script type="module" src="./script/globals.js"></script>
    <script type="module" src="./script/utils.js"></script>

    </body>


</html>
