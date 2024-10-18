<?php

session_start();
//destroy the session
session_unset();
//1.Destroy the session
session_destroy();//Unset $_SESSION['user']

//2. Redirect to login page
header('location:../dashboard/index.php');

?>