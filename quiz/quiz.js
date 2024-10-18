// Variables
let questions = [];
let questionCounter = -1;
let amountOfQuestions;
let category;
let privateQuizId;
let score = 0;
let correctAnswerIndex = -1;
let decrementInterval; // Progressbar
let answerSelected = false;
let timeRanOut = false;
let isQuizCompleted = false;
let progressBarTimeout;
let userResponses = [];
// Buttons
let answerButtons;
let nextButton;
let leaderboardButton;
let skipButton;
let skipCol;
let nextCol;

// SESSION:
// amountOfQuestions
// category


window.addEventListener('DOMContentLoaded', onload)

async function onload() {
    // Fetching the variables from the global quizConfig
    amountOfQuestions = window.quizConfig && window.quizConfig.amountOfQuestions || 10;
    category = window.quizConfig && window.quizConfig.category;
    privateQuizId = window.quizConfig && window.quizConfig.privateQuizId;
    
    if (category.length === 0 && privateQuizId.length === 0) {
        category = 9;
    }

    // Load score and questionCounter from sessionStorage if they exist
    if (sessionStorage.getItem("score")) {
        score = parseInt(sessionStorage.getItem("score"));
        updateScore();
    }
    if (sessionStorage.getItem("questionCounter")) {
        questionCounter = parseInt(sessionStorage.getItem("questionCounter"));
    }

    // DOM Elements
    answerButtons = document.getElementsByClassName('answer');
    nextButton = document.getElementById('nextButton');
    skipButton = document.getElementById('skipButton');
    skipCol = document.getElementById('skipCol');
    nextCol = document.getElementById('nextCol');

    if (questionCounter === amountOfQuestions) {
        handleQuizCompletion();
        return;
    }

    addEventListenersToButtons();

    questions = await loadQuestions();
    amountOfQuestions = questions.length;

    prepareNextQuestion();
}

// Fetch and return questions from api
async function loadQuestions() {
    let apiUrl = "";

    if (privateQuizId.length !== 0) {
        apiUrl = `../quiz-api/quiz-db.php?quizId=${privateQuizId}`;
    } else {
        apiUrl = `../quiz-api/quiz-api.php?type=multiple&amount=${amountOfQuestions}&category=${category}`;
    }

    const questions = fetch(apiUrl, {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "Access-Control-Allow-Origin": "*"
            }
        }).then((response) => {
            if (response.status >= 200 && response.status < 300) {
                console.log("QUESTIONS LOADED SUCESSFULLY");
                return response.json();
            } else {
                console.log("QUESTIONS FAILED TO LOAD!");
                return Promise.reject("An error occured while fetching the news!");
            }
        })
        .catch((error) => console.error(error));  

    return questions;
}


// Display questions and start progressbar
function displayQuestion() {
    //document.getElementById('categoryApi').textContent = category;
    const question = questions[questionCounter];
    const questionText = decodeHTMLEntities(question['question']);  // Decoding here
    const answers = question['answers'];

    const questionEdit = document.getElementById('question-text');
    questionEdit.textContent = questionText;

    const answerButtons = document.getElementsByClassName('answer');
    for (let i = 0; i < answerButtons.length; ++i) {
        const answerButton = answerButtons[i];
        const answer = answers[i];
        const answerText = decodeHTMLEntities(answer['answer']);  // Decoding here

        // Assign index to answer
        answerButton.setAttribute("data-answer-index", i);
        answerButton.textContent = answerText;

        // Store the correct answer index
        if (answer.isCorrect) {
            correctAnswerIndex = i;
            //document.getElementById('cheat').textContent = correctAnswerIndex+1;
        }
    }
}

// Central logic for the quiz
function prepareNextQuestion() {
    // Save score and questionCounter to session
    saveToSession();
    
    // Clear timeout and interval to avoid race conditions
    clearTimeout(progressBarTimeout);
    clearInterval(decrementInterval);

    // Increment question counter and check for end of quiz
    if (!incrementQuestionCounter()) {
        return;
    }

    // Last question
    if (questionCounter === amountOfQuestions - 1) { 
        // Before the last question:
        nextButton.textContent = 'Finish Quiz';
        skipButton.style.display = 'none';

        // Set a flag for the quiz state
        isQuizCompleted = true;
    }
    
    // Reset answer buttons, hide next button and show skip button
    resetUIForNextQuestion(); 
    // Update UI and show the new question
    updateQuestionCount();
    displayQuestion();
    startProgressBar();

}

function addEventListenersToButtons() {    
    // Highlight button, display next button and stop progress bar
    for (const answerButton of answerButtons) {
        answerButton.addEventListener('click', function() {
            answerSelected = true;

            // Disable answer buttons to allow only one try
            disableButtons(answerButtons);
            // Stop progressbar
            clearInterval(decrementInterval);
            clearTimeout(progressBarTimeout);

            var answerIsCorrect = checkAnswer(this); // Pass clicked button
            if (answerIsCorrect) {  
                score++; 
                updateScore();
                this.style.backgroundColor = "#39d629";
            } else {
                this.style.backgroundColor = "#d92d2d";
                // Highlight the right answer if answered wrong
                answerButtons[correctAnswerIndex].style.backgroundColor = "#39d629";
            }

            // Display Next button only if more questions are left
            if (questionCounter < amountOfQuestions) {
                nextCol.style.display = 'block';
                nextButton.style.display = 'block';
                
                skipCol.style.display = 'none';
                skipButton.style.display = 'none';
            } else {
                console.log("Last question: "+questionCounter);
            }

            // Code for automatically jumping to the next question here
        });
    }

    nextButton.addEventListener('click', function() {    
        // Clear timeout and interval to avoid race conditions
        clearTimeout(progressBarTimeout);
        clearInterval(decrementInterval);    

        if (timeRanOut || answerSelected) {
            if (isQuizCompleted) {
                // Save score and questionCounter to session
                saveToSession();
                handleQuizCompletion();
            } else {
                prepareNextQuestion();
            }
            timeRanOut = false;
        }
    });

    skipButton.addEventListener('click', function() {
        // Clear timeout and interval to avoid race conditions
        clearTimeout(progressBarTimeout);
        clearInterval(decrementInterval);
        
        

        if (questionCounter < amountOfQuestions-1) {
            console.log("SKIP BUTTON, questionCounter: "+questionCounter);
            // Record user response but dont update the session yet
            const question = questions[questionCounter];

            userResponses.push({
                question: decodeHTMLEntities(question['question']),
                givenAnswer: "*",
                isCorrect: 0
            });
        }

        prepareNextQuestion();
    });
}

function startProgressBar() {    
    let progressBar = document.querySelector('.progress-bar');

    // Apply instant-update class for instant changes
    progressBar.classList.add('instant-update');
    progressBar.classList.remove('smooth-transition');

    // Immediately set progress bar to 100%
    progressBar.style.width = '100%';
    progressBar.setAttribute('aria-valuenow', '100');

    // Pause before starting the decrement
    progressBarTimeout = setTimeout(() => {
        // Fallback safety check 
        if (questionCounter === amountOfQuestions) {
            clearInterval(decrementInterval);
            clearTimeout(progressBarTimeout);
            return;
        }

        // Switch to smooth-transition before decrementing
        progressBar.classList.remove('instant-update');
        progressBar.classList.add('smooth-transition');
        
        let progressValue = 100;
        const decreaseStep = 0.25; // (100 / 20) / (1000 / 50ms) = 0.25

        decrementInterval = setInterval(() => {
            progressValue -= decreaseStep;
            progressBar.style.width = progressValue + '%';
            progressBar.setAttribute('aria-valuenow', progressValue);

            if (progressValue <= 0) {
                clearInterval(decrementInterval);
                clearTimeout(progressBarTimeout);
                timeRanOut = true;

                // Highlight the correct answer, highlight answer and show next button
                disableButtons(answerButtons);
                answerButtons[correctAnswerIndex].style.backgroundColor = "#39d629";
                nextCol.style.display = 'block';
                nextButton.style.display = 'block';

                // Hide the skip button
                skipCol.style.display = 'none';
                skipButton.style.display = 'none';
            }
        }, 50)
    }, 500); // 500ms pause before decrement starts
}

function resetUIForNextQuestion() {
    // Reset answer buttons
    resetButtons(answerButtons);    

    // Always hide the next button
    nextCol.style.display = 'none';
    nextButton.style.display = 'none';

    // Always show the skip button unless its the last question
    if (questionCounter < amountOfQuestions - 1) {
        skipCol.style.display = 'block';
        skipButton.style.display = 'block';
    } else {
        skipCol.style.display = 'none';
        skipButton.style.display = 'none';
    }
}

function incrementQuestionCounter() {
    questionCounter++;

    if (questionCounter === amountOfQuestions) {
        handleQuizCompletion();
        return false; // false means the quiz has ended
    }
    return true; // true means there are more questions
}

function updateScore() {
    document.getElementById('points-score').textContent = score;  
}

function saveToSession() {
    // Save score and questionCounter to sessionStorage after every answer
    sessionStorage.setItem("score", score.toString());
    sessionStorage.setItem("questionCounter", questionCounter.toString());
} 

function updateQuestionCount() {
    document.getElementById('question-count').textContent = questionCounter+1;
    document.getElementById('question-amount').textContent = amountOfQuestions;
}

function disableButtons(buttonsArray) { //[...answerButtons, nextButton, leaderboardButton]
    for (const btn of buttonsArray) {
        btn.disabled = true;
    }
}

function resetButtons(buttonsArray) {
    for (const btn of buttonsArray) {
        btn.disabled = false;
        btn.style.backgroundColor = "";
    }
}

function handleQuizCompletion() {
    // Stop timer
    clearInterval(decrementInterval);
    clearTimeout(progressBarTimeout);

    // Save data to session
    updateSessionData();

    // Hide unnecessary quiz elements
    for (const answerButton of document.querySelectorAll('.answer')) {
        answerButton.style.display = 'none';
    }
    document.getElementById('question-count-text').style.display = 'none';
    document.querySelector('.progress-points-header').style.display = 'none';

    // Update question text to display the score message
    const questionText = document.getElementById('question-text');
    questionText.textContent = `You scored ${score} points!`;

    // Modify and display the "View Leaderboard" button using the Skip button's properties
    const skipButton = document.getElementById('skipButton');
    skipButton.textContent = "View Resultpage";
    skipButton.style.backgroundColor = "#ffc107";
    skipCol.style.display = 'block';
    skipButton.style.display = 'block';
    skipButton.onclick = function() {
        sessionStorage.clear();
        window.location.href = "../result/result.php";
    };

    // Modify and display the "Choose another quiz" button using the Next button's properties
    const nextButton = document.getElementById('nextButton');
    nextButton.textContent = "Choose another quiz";
    nextButton.style.backgroundColor = "#0d637e";
    nextButton.style.color = "white";

    nextButton.classList.remove('p-3');


    nextCol.style.display = 'block';
    nextButton.style.display = 'block';
    nextButton.onclick = function() {
        sessionStorage.clear();
        window.location.href = "../dashboard/index.php"; // replace with your main quiz page URL
    };
}

// Used for decoding the text for the questions and answers
function decodeHTMLEntities(text) {
    const parser = new DOMParser();
    const dom = parser.parseFromString(
        '<!doctype html><body>' + text,
        'text/html');
    return dom.body.textContent;
}

// Checks answer and calls updateSessionData function
function checkAnswer(answerButton) {
    const clickedAnswerIndex = parseInt(answerButton.getAttribute("data-answer-index"));
    const correctAnswer = questions[questionCounter].answers[clickedAnswerIndex].isCorrect;

    // Record user response but dont update the session yet
    const question = questions[questionCounter];
    const selectedAnswer = question['answers'][clickedAnswerIndex];

    userResponses.push({
        question: decodeHTMLEntities(question['question']),
        givenAnswer: decodeHTMLEntities(selectedAnswer['answer']),
        isCorrect: correctAnswer
    });

    return correctAnswer;
}

// Send data to php script to store in session
function updateSessionData() {
    fetch('storeSessionData.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            responses: userResponses,
            score: score
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Session data and score updated successfully');
        } else {
            console.error('Error updating session data and score:', data.message);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}



// Shift + Alt + A = multi line comment