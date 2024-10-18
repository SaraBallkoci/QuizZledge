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
    }else{
        echo "connected";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../dashboard/style.css">     
        <link rel="stylesheet" href="../dashboard/adminstyle.css">   
        <link rel="stylesheet" href="quiz-room.css">     


        <title>QuizZLedge</title>
    </head>
    <body class=" background-image">
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
                            <span class="Quizzlegde"><a class="navbar-brand" href="../dashboard/index.php" id="QuizZLedge" style="color:#0a5e78;">QuizZLedge</a></span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            
                            <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                        
                                <a class="navbar-nav text-decoration-none ml-auto" href="../dashboard/index.php"> Home </a>
                                <a class="navbar-nav text-decoration-none ml-auto" href="../dashboard/categorie-session.php"> Leaderboard</a>
                                <div class="navbar-nav ms-auto">
                                    
                                    <?php if ($isUser): ?>    
                                    <a class="username text-decoration-none ms-auto" href=""><img src="../images/<?php echo $image?>" class="img-fluid" id="avatar" style="width:20%; float:right;"></a>
                                    <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php">Logout</a>
                                    <?php else: ?>
                                    <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>   
            
            <div class="container-fluid">
                <form id="quiz-id-form" action="CheckQuizId.php" method="post" charset="UTF-8" class="space">
                    <div class="form-group d-flex justify-content-center">
                        <input class="form-control form-edit" name="privateQuizId" aria-describedby="emailHelp" placeholder="Enter Code"> 
                    </div>
                    <div  class="d-flex justify-content-center">
                        <button id="submit-btn" type="submit" class="btn button-2 mt-5">Submit</button> 
                    </div >
                </form>                        
            </div>
        </div>    
        <!-- end of navbar -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

</html>