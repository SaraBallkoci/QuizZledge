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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../images/2690.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link rel="stylesheet" href="style.css">     
        <link rel="stylesheet" href="adminstyle.css">
        <link rel="stylesheet" href="resposive.css">
        

        <script>
            sessionStorage.clear();
        </script>

        <script src="index.js"></script>      
        <title>QuizZLedge</title>

    </head>

    <body>
        <!-- start of php session -->
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
            // Handle the case where $_SESSION['user'] is not set
            // Redirect to login page or show an error message
        }
        ?>
        <!-- end of php sesion -->
        
        <div class="container">
            <!-- start of navbar -->
            <div class="container-fluid position-absolute top-0 w-100 nav-bar">
                <nav id="nav-bar" class="navbar navbar-light bg-light navbar-expand-lg w-100 ">
                    <div class="container-fluid"> 
                        <span class="Quizzlegde"><a class="navbar-brand" href="#" id="QuizZLedge" style="color:#0a5e78;">QuizZLedge</a></span>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                       
                            <a class="navbar-nav text-decoration-none ml-auto" href="#"> Home </a>
                            <a class="navbar-nav text-decoration-none ml-auto" href="../dashboard/categorie-session.php"> Leaderboard</a>
                            <div class="navbar-nav ms-auto">
                                
                                <?php if ($isUser): ?>    
                                <a class="username text-decoration-none ms-auto" href=""><img src="../images/<?php echo $image?>" class="img-fluid" id="avatar"></a>
                                <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php">Logout</a>
                                <?php else: ?>
                                <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                                <?php endif; ?>
                           </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="container" id="position-resposive">  
            <!-- header image  -->
            <div class="row">
                <div class="col-md-9">
                    <div class="hero-slide-item img-bg img-fluid w-100">
                        <img src="../images/wooden.jpg" alt="" class="slides">
                    </div>
                </div>
                
                <!-- Column for the text (1/4 width) -->
                <div class="col-md-3 col-position mb-5">
                    <div class="top-down justify-content-center align-content-center">
                        <div class="item-content-description d-flex justify-content-center  top-down delay-4">
                            <a href="../create-quiz/list-quizzes.php" class="btn button-1 text-center">Create Your Own Quiz</a>
                        </div>
                        <div class="text-center mt-4 mb-4" id="or"> OR </div>
                            <div class="join-btn">
                                <a href="../quiz-room/quiz-room.php" class="btn button-2 text-center">Join a Quiz Room</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="container-fluid d-flex justify-content-center align-items-center">
                <!-- end of navbar -->   
                <div class="container mt-1 mb-6">                
                    <div class="container">
                        <div class="row">
                            <div class="col col-lg-2">
                                <div class="input-group col-md-4">
                                    <input class="form-control py-2 border-right-0 border" id="search-box" type="search" placeholder="Search ..." >
                                    <div class="searchResults" id="search-results"></div>
                                    <span class="input-group-append">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col title-quiz mt-5 ml-3">
                                Pick a random Quiz
                            </div>
                            <div class="col col-lg-2"></div>
                        </div>
                    </div>
                    
                    <!-- start of first row -->
                    <div class="container" id="picture-container">
                        <?php
                            $sql = "SELECT * FROM online_quiz";
                            $res = mysqli_query($db, $sql);

                            if (mysqli_num_rows($res) > 0) {
                                $columnCount = 0;
                                $rowCount = 0; // Keep track of how many rows are being output.
                                $itemsFetched = 0; // Counter to keep track of the number of items fetched.

                                while ($row = mysqli_fetch_assoc($res)) {
                                    // Only start a new row if we're not at the beginning.
                                    if ($columnCount === 0) {
                                        echo '<div class="row row-2">';
                                        $rowCount++;
                                    }

                                    $category = $row['categoryName'];
                                    $categoryIndex = $row['categoryIndex'];
                                    $image = $row['image'];
                                    $description = $row['description'];
                                    $itemsFetched++;
                        ?>

                        <div class="col-12 col-sm-6 col-md-3 image justify-content-center">
                            <div class="card flip-card" style="width: 16.5rem;">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front">
                                        <img src="../images/<?= $image; ?>" class="card-img-top quiz-image" alt="...">
                                    </div>
                                    <div class="card-body flip-card-back">
                                        <h5 class="card-title"><?= $category ?></h5>
                                        <p class="card-text"><?= $description ?></p>
                                        <a href="javascript:void(0);" onclick="startQuiz('<?= addslashes($category) ?>', '<?= addslashes($categoryIndex) ?>');" class="btn btn-start">Start Quiz</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="quiz-visible-title text-center"><?= $category ?></p>
                            </div>
                        </div>

                        <?php
                                    $columnCount++;

                                    // Check if it's time to end the row or if we are at the last item.
                                    if ($columnCount === 4 || $itemsFetched === mysqli_num_rows($res)) {
                                        echo '</div>'; // Close the current row.
                                        $columnCount = 0; // Reset the column count for a new row.
                                    }
                                }
                            }
                        ?>
                    </div>
                    <!-- end of container -->


                </div>
            </div>

            <div class="text-center mb-3 mt-4">
                <button onclick="togglePictures()" id="show-more-button" class="button-2 text-decoration-none">Show More</button>
            </div>
        </div>      
        
        <!-- start of footer section -->

        <script>
            let isShowMoreActive = false; // Flag to track the state of "Show More"

            function togglePictures() {
            // Select the row containers
            const rows = document.querySelectorAll("#picture-container > .row-2");
            const showMoreButton = document.getElementById("show-more-button");
            isShowMoreActive = !isShowMoreActive; // Toggle the state of the flag

            // Start with the third row (index 2), since the first two rows should always be shown
            rows.forEach(function (row, index) {
                if (index >= 2) { // Only target rows after the first two
                    row.style.display = isShowMoreActive ? 'flex' : 'none'; // Show or hide based on the flag
                }
            });

            // Update button text based on the flag
            showMoreButton.textContent = isShowMoreActive ? "Show Less" : "Show More";
        }

        // Call this function to initialize the "Show More/Less" state correctly
        function initializePictureDisplay() {
            const rows = document.querySelectorAll("#picture-container > .row-2");
            // Initially hide all rows after the first two
            rows.forEach(function (row, index) {
                if (index >= 2) {
                    row.style.display = 'none';
                }
            });
        }

        // Run this once to initialize the state on page load
        document.addEventListener('DOMContentLoaded', initializePictureDisplay);



        </script>
        <!-- end of script for show more button -->

        <!-- script links  -->
        <script src="../dashboard/ajax.js"></script>
        <script src="../dashboard/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

</html>