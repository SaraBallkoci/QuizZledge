<?php
include ('db/connect.php');
ob_start();
session_start(); // Start Session
$errorMsg = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to check if username exists in the 'user' table
    $sql = "SELECT * FROM user WHERE userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password matches, login successful
            $_SESSION['login'] = "<div class='success'>Login successful.</div>";
            $_SESSION['user'] = $username;
            header('location:../dashboard/index.php');
            exit;
        } 
    }
    
    // If we reached here, either the user doesn't exist or the password was wrong
    $errorMsg = "<div class='error text-center'>Username or password is incorrect.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet"href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

  </head>
<body>

<div class="container container1">
<img class="img-fluid" src="images/pic3.jpg"/> 
</div>
<div class="container"> 
    <a href="../dashboard/index.php" ><i class="bi bi-chevron-compact-left"></i>Back</a>
  <form action="" method="post">
    <div class="form-group  login">
        <p class="title text-center" >Log In to your account:</p>
        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            ?>
            <?php echo $errorMsg; ?>
            <label for="username" class="form-label">Username:</label>
            <input type="username" class="form-control" id="username" name="username" placeholder="Enter username" required>
    </div>

    <div class="form-group">
      <label for="password" class="form-label">Password:</label>
      <div class="input-group" id="show_hide_password">
        <input class="form-control" type="password" name="password"placeholder="Enter password" required>
        <div class="input-group-addon">
          <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
        <div class="form-group login1">
        <button class="btn " type="submit" name="submit">Log In</button>
    </div>
    <div class="text-center">Not registered ?<a href="register.php"> Register here!</a></div>
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