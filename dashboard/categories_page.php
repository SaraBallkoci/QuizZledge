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
   // else{echo "connected";}
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

        <title>QuizZLedge</title>
    </head>
    <body>
    <?php 
     ob_start();
     //Start Session
     session_start();

        $isUser = isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_SESSION['user']) && $_SESSION['user'] != 'admin';

        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        

        $sql = "SELECT avatar  FROM user WHERE userName = '".$_SESSION['user']."'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $image = $row['avatar'];
        }
    }?>
 <div class="container">
    
        <div>            
            <!-- header picture  -->
            <div class="container-fluid position-absolute top-0 w-100 nav-bar">
                <!-- start of navbar -->
                <nav id="nav-bar" class="navbar navbar-light bg-light navbar-expand-lg w-100 ">
                    <div class="container-fluid"> 
                        <a class="navbar-brand" href="../dashboard/index.php" id="QuizZLedge" >QuizZLedge</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                           <div class="navbar-nav ms-auto">
                                <?php if ($isUser): ?>    
                                <a class="username text-decoration-none ms-auto" href=""><img src="../registerlogin/<?php echo $image?>" class="img-fluid" id="avatar"></a>
                                <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php">Logout</a>
                                <?php else: ?>
                                <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                                <?php endif; ?>
                           </div>
                           <div class="row">
                            <div class="input-group col-md-4">
                                <input class="form-control py-2 border-right-0 border" id="search-box" type="search" placeholder="Search" >
                                <div class="searchResults" id="search-results"></div>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary border-left-0 border" id="btn-search" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            </div>
            <div class="container">  
                <!-- header image  -->
                <div class="row">
                    <!-- Column for the image (3/4 width) -->
                    <div class="col-md-9">
                        <div class="hero-slide-item img-bg img-fluid w-100">
                            <img src="../images/wooden.jpg" alt="">
                        </div>
                    </div>
                    <!-- Column for the text (1/4 width) -->
                    <div class="col-md-3 col-position mb-5">
                        <div class="top-down justify-content-center align-content-center">
                            <div class="item-content-description d-flex justify-content-center  top-down delay-4">
                                <a href="../create-quiz/new-quizz.html" class="btn button-1 text-center">Create Your Own Quiz</a>
                            </div>
                            <div class="text-center mt-4 mb-4"> OR </div>
                            <div class="join-btn">
                                <a href="" class="btn button-2 text-center">Join a Quiz Room</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid d-flex justify-content-center align-items-center">      
                <!-- end of navbar -->

                <div class="container mt-1 mb-6">

                    <div class="title-quiz mt-5 mb-6">
                        Search results
                    </div>
                    <!-- start of first row -->
                    <div class="container ">
                        <?php

                        $categoryName=mysqli_real_escape_string($db,$_GET['categoryName']);

                        //get data from database 
                        $sql = "SELECT * FROM online_quiz 
                        WHERE categoryName='$categoryName'";
                           
                            $res = mysqli_query($db, $sql);

                            if (mysqli_num_rows($res) > 0) {
                                $columnCount = 0;
                                echo '<div class="row row-2">'; // Start the first row

                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category = $row['categoryName'];
                                    $_SESSION['category'] = $category;
                                    $image = $row['image'];
                                    $description = $row['description'];
                                    ?>
                                    <div class="col-12 col-sm-6 col-md-3 text-center">
                                        <div class="card flip-card" style="width: 18rem;">
                                            <div class="flip-card-inner">
                                                <div class="flip-card-front">
                                                    <img src="<?= $image ?>" class="card-img-top quiz-image" alt="...">
                                                </div>
                                                <div class="card-body flip-card-back">
                                                    <h5 class="card-title"><?= $category ?></h5>
                                                    <p class="card-text"><?= $description ?></p>
                                                    <a href="../quiz/quiz.html" class="btn btn-start">Start Quiz</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="quiz-visible-title text-center"><?= $category ?></p>
                                        </div>
                                    </div>
                                <?php

                                $columnCount++;
                                
                                if ($columnCount === 4) {
                                    echo '</div><div class="row row-2">'; // Start a new row
                                    $columnCount = 0; // Reset the column count
                                    }
                                }

                                // Close any open row if it's not complete
                                if ($columnCount > 0) {
                                    echo '</div>';
                                }
                            }
                        ?>

                        <!-- end of second row -->
                    </div>    
                </div> 
            </div>
        </div>
        <p class="text-center">
    </p>

        <!-- end of navbar -->
        <script src="ajax.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

</html>