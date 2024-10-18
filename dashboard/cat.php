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
    //else{echo "connected";}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Show More Pictures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">     
    <link rel="stylesheet" href="adminstyle.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-6">
        <div class="title-quiz mt-5 mb-6">
            Pick a random Quiz
        </div>
        <!-- start of first row -->
        <div class="container" id="picture-container">
            <?php
            // Your existing PHP code to generate the quiz items
            $sql = "SELECT * FROM online_quiz";
            $res = mysqli_query($db, $sql);

            if (mysqli_num_rows($res) > 0) {
                $columnCount = 0;
                echo '<div class="row row-2">';

                while ($row = mysqli_fetch_assoc($res)) {
                    $category = $row['categoryName'];
                    $categoryIndex = $row['categoryIndex'];
                    $image = $row['image'];
                    $description = $row['description'];
                    ?>

                    <div class="col-12 col-sm-6 col-md-3 image">
                        <div class="card flip-card" style="width: 18rem;">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="../images/<?= $image; ?>" class="card-img-top quiz-image" alt="...">
                                </div>
                                <div class="card-body flip-card-back">
                                    <h5 class="card-title"><?= $category ?> <?= $categoryIndex ?></h5>
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

    <div class="text-center mb-5">
        <button onclick="togglePictures()" id="show-more-button" class="button-2 text-decoration-none">Show More</button>
    </div>

    <script>
        // JavaScript to toggle the display of pictures
        function togglePictures() {
            const images = document.querySelectorAll(".image");
            const showMoreButton = document.getElementById("show-more-button");

            images.forEach(function (image, index) {
                if (showMoreButton.textContent === "Show More") {
                    image.classList.remove("hidden");
                } else {
                    if (index >= 8) {
                        image.classList.add("hidden");
                    }
                }
            });

            if (showMoreButton.textContent === "Show More") {
                showMoreButton.textContent = "Show Less";
            } else {
                showMoreButton.textContent = "Show More";
            }
        }

        // Initially hide all images except the first 8
        const images = document.querySelectorAll(".image");
        images.forEach(function (image, index) {
            if (index >= 8) {
                image.classList.add("hidden");
            }
        });
    </script>
</body>
</html>
