<?php
include ('db/connect.php');
ob_start();
//Start Session
session_start();

$usernameErr = $passwordErr = $emailErr = "";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $avatar = $_POST['radio'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Check password length
    if (strlen($password) < 8) {
        $passwordErr = "<div class='error text-center'>Password should be at least 8 characters in length!</div>";
    } else {
        // Use prepared statement to check for existing username or email
        $stmt = $conn->prepare("SELECT * FROM user WHERE userName=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['userName'] === $username) {
                $usernameErr = "<div class='error text-center'>Username already exists!</div>";
            }
            if ($row['email'] === $email) {
                $emailErr = "<div class='error text-center'>Email already exists!</div>";
            }
        } else {
            // Use prepared statement to insert user data
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO user (userName, password, email, avatar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $hashedPassword, $email, $avatar);
            
            if ($stmt->execute()) {
                echo "<h8>Data stored successfully in the database.</h8>";
                $_SESSION['login'] = "<div class='success'>Successfully registered.</div>";
                header('location: login.php');
            } else {
                echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet"href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

  </head>
<body>
<div class="container container1">
<img class="img-fluid" style="max-width: 100%; height: auto;" src="images/pic3.jpg"/> 
</div>
<div class="container">  
<a href="../dashboard/index.php" ><i class="bi bi-chevron-compact-left"></i>Back</a>
  <form action="register.php" method="post">
    <div class="form-group">
        <p class="title text-center" >Create your account:</p>
        <?php echo $emailErr; ?>
        <label for="email" class="form-label">Email address:</label>
        <input type="email" class="form-control" id="email" name="email"placeholder="Enter email" required>
    </div>
    <div class="form-group">
    <?php echo $usernameErr; ?>
            <label for="username" class="form-label">Username:</label>
            <input type="username" class="form-control" id="username" name="username" placeholder="Enter username" required>
    </div>
  
       <div class="form-group">
       <?php echo $passwordErr; ?> 
        <label for="password" class="form-label">Password:</label>
        <div class="input-group" id="show_hide_password">
          <input class="form-control" type="password" name="password"placeholder="Enter password" required>
          <div class="input-group-addon">
            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
       
        <div class="text-center">Choose your Avatar</div>
        <div class="form-check">
          <label for="flexRadio">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio" value="icon.png"  required>
          <img src="../images/icon.png" alt="Option 1" class="img-fluid">
          </label>
          <label for="flexRadio1">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio1" value="icon2.png" required>
          <img src="../images/icon2.png" alt="Option 2" class="img-fluid">
          </label>

          <label for="flexRadio2">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio2" value="icon3.png" required>
          <img src="../images/icon3.png" alt="Option 3" class="img-fluid">
          </label>

          <label for="flexRadio3">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio3" value="icon4.png"  required>
          <img src="../images/icon4.png" alt="Option 4" class="img-fluid">
          </label>

        </div>
        <div class="form-check">
        <label for="flexRadio4">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio4" value="icon5.png" required>
          <img src="../images/icon5.png" alt="Option 5" class="img-fluid">
          </label>

      
          <label for="flexRadio5">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio5" value="icon6.png"  required>
          <img src="../images/icon6.png" alt="Option 6" class="img-fluid">
          </label>

       
          <label for="flexRadio6">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio6" value="icon7.png" required>
          <img src="../images/icon7.png" alt="Option 7" class="img-fluid">
          </label>

      
          <label for="flexRadio7">
          <input class="form-check-input" type="radio" name="radio" id="flexRadio7" value="icon8.png"  required>
          <img src="../images/icon8.png" alt="Option 8" class="img-fluid">
          </label>

        </div>
       
        <div class="form-group">
        <button class="btn" type="submit" name="submit" class="btn-submit">Register</button>
    </div>
    <div class="text-center">Already registered ?<a href="login.php"> Log In here!</a></div>
    </div>

  </form>  
  

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="script.js"></script>
  </body>
</html>