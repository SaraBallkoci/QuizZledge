<?php
session_start();

if (isset($_POST['categoryName']) && isset($_POST['category'])) {
    $_SESSION['categoryName'] = $_POST['categoryName'];
    $_SESSION['category'] = $_POST['category'];
    echo 'success';
} else {
    echo 'error';
}
?>