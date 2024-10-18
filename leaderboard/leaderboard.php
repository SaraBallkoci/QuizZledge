<?php
    session_start();
    $isUser = isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_SESSION['user']) && $_SESSION['user'] != 'admin';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "quizzledge";

    $db = new mysqli($servername, $username, $password, $database);

    if ($db->connect_errno) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Get the category value stored in the session
    $c=$_SESSION["category"]; //THIS IS THE CORRECT PARAMETER
    //$c=0; //THIS IS JUST FOR TESTING
    // Ensure the category exists in the session
    if (!isset($_SESSION["category"])) {
        file_put_contents("log.txt", "NO CATEGORY DEFINED!", FILE_APPEND);
    }

    //Check if the user is loggedin or not
    if(isset($_SESSION['user'])){
        $loggedin=true;
    }else{
        $loggedin=false;
    }

    //First we check if the c parameter is related to an
    //online_quiz leaderboard. If not is a private_quiz
    $sql="SELECT idLeaderboard FROM online_quiz 
    WHERE categoryIndex = '$c'";
    $quiz = $db->query($sql);
    /*if(empty($quiz)){
        $sql="SELECT idLeaderboard FROM private_quiz 
        WHERE idQuiz = '$c'";
        $quiz = $db->query($sql);
    }*/

    $row=$quiz->fetch_assoc();
    $idLeaderboard=$row['idLeaderboard'];

    //Query the first 5 people ranked
    $sql5 = "SELECT avatar, user.userName, correctAnswers, questionAmount FROM score 
    JOIN user ON score.userName=user.userName 
    WHERE score.idLeaderboard='$idLeaderboard' 
    ORDER BY correctAnswers DESC, time ASC LIMIT 5";

    $five = $db->query($sql5);
    $row5=$five->fetch_assoc();
   

    if($loggedin){
        //Query the position of the user in the ranking
        $sqlu = "
        SELECT COUNT(idScore) AS ranking, usuario.avatar, usuario.userName, usuario.correctAnswers, usuario.questionAmount
        FROM (
            SELECT avatar, user.userName, correctAnswers, questionAmount
            FROM score 
            JOIN user ON score.userName = user.userName
            WHERE score.idLeaderboard = '$idLeaderboard' 
            AND user.userName = '{$_SESSION['user']}'
        ) AS usuario,
        score 
        JOIN user ON score.userName = user.userName AND score.idLeaderboard = '$idLeaderboard'
        WHERE usuario.correctAnswers <= score.correctAnswers
        ORDER BY correctAnswers DESC, score.time ASC";

        $user = $db->query($sqlu);
        $rowu=$user->fetch_assoc();
    }
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
    }

    $totalQuestions=$row5["questionAmount"];

    mysqli_close($db);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../images/2690.png" type="image/x-icon">
        <title>QuizZLedge</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../dashboard/style.css">     
        <link rel="stylesheet" href="../dashboard/adminstyle.css">

        <link href="leaderboard.css" rel="stylesheet">

    </head>
    <body>
    
        <!-- start of navbar -->
        <div class="container-fluid position-absolute top-0 w-100 nav-bar">
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
        <!-- end of navbar -->

    <div class="container" style="margin-top: 10rem;">                                    
        <div class="table-responsive card ">
            <div class="card-body" >
                <table>
                    <tbody>
                        <?php
                            //Logical variables
                            if($loggedin){
                                $userPosition=$rowu["ranking"];
                                if($rowu["ranking"]<=5){
                                    $loggedinInto5=true;
                                    $userInto5=true;
                                }else{
                                    $loggedinInto5=false;
                                    $userInto5=false;
                                }
                            }else{
                                $loggedinInto5=false;
                            }
                        ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>HIGHSCORE</th>
                            <!--th>TIME</th-->
                        </tr>

                        <?php
                            for($i=1;$i<=mysqli_num_rows($five);$i++){
                                if($loggedinInto5===false&$i===mysqli_num_rows($five)){
                                    $lastRow=true;
                                }else{
                                    $lastRow=false;
                                }
                                
                                $avatar=$row5["avatar"];
                                $userName=$row5["userName"];
                                $correctAnswers=$row5["correctAnswers"];
                                $row5=$five->fetch_assoc();
                                //$time=$row5["time"];
                        ?>
                            <tr <?php if($loggedin){if($userPosition==$i){echo 'id="user_row"';}}?>>
                                <th class="number_field <?php if($lastRow){echo 'table_header';}?>" scope="row"><?php echo $i ?></th>
                                <td class="image_field <?php if($lastRow){echo 'table_header';}?>">
                                    <img src="../images/<?php echo $avatar?>" <?php if($loggedin){if($userPosition==$i){echo 'id="user_avatar"';}else{echo 'class="avatar"';}}else{echo 'class="avatar"';}?>>
                                </td>
                                <td <?php if($lastRow){echo 'class="table_header"';}?>><?php echo $userName?></td>
                                <td <?php if($lastRow){echo 'class="table_header"';}?>><?php echo $correctAnswers.'/'.$totalQuestions?></td>
                                <!--td><?php echo $time?></td-->
                            </tr>
                        <?php } ?>

                        <?php
                            if($loggedin){
                                if(!$userInto5){
                                    echo '<tr>
                                        <th class="number_field table_header" scope="row">፧</th>
                                    </tr>
                                    <tr id="user_row">
                                        <th class="number_field" scope="row">'.$rowu["ranking"].'</th>
                                        <td class="image_field"><img src="../images/'.$rowu["avatar"].'" id="user_avatar"></td>
                                        <td>'.$rowu["userName"].'</td>
                                        <td>'.$rowu["correctAnswers"].'/'.$totalQuestions.'</td>  
                                    </tr>';
                                }
                            }else{
                                echo '<tr>
                                    <td colspan="4" style="padding-left:1%">To see your Position in the LEADERBOARD you Have To Be LOGGEDIN</td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            
    </body>
</html>