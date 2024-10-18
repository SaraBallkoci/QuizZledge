function startQuiz(categoryName, category) {
    // Use AJAX to send data to a PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'set_session.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200 && this.responseText == 'success') {
            // If session was set successfully, redirect to quiz.php
            window.location.href = `../quiz/quiz.php?category=${category}`;
        }
    };
    xhr.send('categoryName=' + categoryName + '&category=' + category);
}

function goLeaderboard(categoryName, category) {
    // Use AJAX to send data to a PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'set_session.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200 && this.responseText == 'success') {
            // If session was set successfully, redirect to quiz.php
            window.location.href = "../leaderboard/leaderboard.php";
        }
    };
    xhr.send('categoryName=' + categoryName + '&category=' + category);
}