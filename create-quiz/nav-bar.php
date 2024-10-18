<!DOCTYPE html>
<html>
<head>
    <title>Create New Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../dashboard/style.css">     
  
</head>
<body>
   
    <div class="container">
        <!-- start of navbar -->
        <div class="container-fluid position-absolute top-0 w-100 nav-bar">
            <nav id="nav-bar" class="navbar navbar-light bg-light navbar-expand-lg w-100 ">
                <div class="container-fluid"> 
                    <span class="Quizzlegde"><a class="navbar-brand" href="#"  style="color:#0a5e78;">QuizZLedge</a></span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                        <a class="navbar-nav  text-decoration-none ml-auto" href="#" id="HomeLink"> Home </a>
                        <a class="navbar-nav  text-decoration-none ml-auto" href="..leaderboard/leaderboard.php" > Leaderboard</a>
                        <div class="navbar-nav ms-auto">
                            <div class="navbar-nav ">
                                <a class="username text-decoration-none ms-auto" href=""><img src="../images/" class="img-fluid" id="avatar"></a>
                                <a  class="text-decoration-none ms-auto" href="../registerlogin/logout.php">Logout</a>
                                <a class="text-decoration-none" href="../registerlogin/login.php">Login</a>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- end of navbar -->
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const homeLink = document.getElementById("HomeLink");

    homeLink.addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "google.com"; 
    });

    
});

    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script type="module" src="./script/eventListener.js"></script>
    <script type="module" src="./script/manageData.js"></script>
    <script type="module" src="./script/globals.js"></script>
    <script type="module" src="./script/utils.js"></script>

</body>
</html>
