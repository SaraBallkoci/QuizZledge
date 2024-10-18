import { newQuizz,getInputIds} from './globals.js';
import { generateIdQuizz,copyLink,inputOnReadOnly,transformQuizStructure,afficherConfirmationModal} from './utils.js';
import { createQuestionCard,fillQuestionCard,addQuestionButton} from './manageCard.js';




document.addEventListener("DOMContentLoaded", function() {
    const currentPage = document.body.id;
if (currentPage === "list-quizzes") {
 const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));

}



});



const confirmationMessage = document.getElementById("confirmationMessage");
const urlParams = new URLSearchParams(window.location.search);
const added = urlParams.get("added");
const updated = urlParams.get("updated");


if (added === "true") {
    window.onload = function () {
        confirmationMessage.textContent = "Quiz added successfully!";
        confirmationMessage.style.display = "block";

        setTimeout(function () {
            confirmationMessage.style.display = "none";
        }, 3000); 
    };

    const newURL = window.location.href.replace("?added=true", "");
    window.history.replaceState({}, document.title, newURL);
}


if (updated === "true") {
    window.onload = function () {
        confirmationMessage.textContent = "Quiz updated successfully!";
        confirmationMessage.style.display = "block";

        setTimeout(function () {
            confirmationMessage.style.display = "none";
        }, 3000); 
    };

    const newURL = window.location.href.replace("?updated=true", "");
    window.history.replaceState({}, document.title, newURL);
}



export function displayQuizInfos() {
// Récupérez les données du quiz depuis l'URL
const urlParams = new URLSearchParams(window.location.search);
const quizDataParam = urlParams.get("quizData");

// Vérifiez si les données du quiz sont présentes dans l'URL
if (quizDataParam) {
    // Décodez les données et convertissez-les en objet
    const quizData = JSON.parse(decodeURIComponent(quizDataParam));
    newQuizz.idQuizz = quizData.idQuiz;
    newQuizz.title = quizData.title;
    newQuizz.description = quizData.description;
    newQuizz.userName = quizData.userName;
newQuizz.questions = [];

newQuizz.questions = quizData.questions.map(questionData => {
const answers = questionData.answers.map(answer => answer.answer); 
const correctAnswer = answers.indexOf(questionData.correctAnswer);
return {
    question: questionData.question,
    answers,
    correctAnswer
};
});




   

    const quizInfoElement = document.getElementById("quiz-info");
    document.getElementById("quizName").value =  quizData.title ;

    document.getElementById("quizDescription").value =  quizData.description ;



    let questionList = document.querySelector(".question-list");
    if (questionList === null) {
        questionList = document.createElement("div");
        questionList.className = "question-list";
        quizInfoElement.appendChild(questionList);
    }

    quizData.questions.forEach((question, index) => {
        const i = index + 1;
        const questionCard = createQuestionCard(i);
        fillQuestionCard(questionCard, question, i);
        questionList.appendChild(questionCard);

        const button = document.getElementById("save-question" + i);
        button.textContent = "Edit Question";
        button.id = "edit-question" + i;

        const inputs = getInputIds(i);
        inputOnReadOnly(inputs);


        if (index < quizData.questions.length - 1) {
    addQuestionButton();
   


}

 const btn = document.getElementById("showQuestion" + (index + 1));
    btn.classList.remove("btn-danger");
    btn.classList.add("btn-success");

    });


}
}


function createTableRow(quiz) {
    var row = document.createElement("tr");

    if (!quiz) {
        var noDataCell = document.createElement("td");
        noDataCell.setAttribute("colspan", "3");
        noDataCell.textContent = "No quizzes have been created yet";
        noDataCell.className = "text-center";
        row.appendChild(noDataCell);
    } else {
        var nameCell = document.createElement("td");
        var nameLink = document.createElement("p");
        //nameLink.href = "#";
        nameLink.textContent = quiz.title;
        nameCell.appendChild(nameLink);
        row.appendChild(nameCell);

        var linkCell = document.createElement("td");
        var inputGroup = document.createElement("div");
        inputGroup.className = "input-group";
        var input = document.createElement("input");
        input.id = quiz.idQuiz;
        input.type = "text";
        input.className = "form-control";
        input.value = quiz.idQuiz;
        var buttonGroup = document.createElement("div");
        buttonGroup.className = "input-group-append";
        var copyButton = document.createElement("button");
        copyButton.className = "btn btn-primary btn-sm copy-link";
        copyButton.textContent = "Copy Link";
        copyButton.onclick = function () {
            copyLink(quiz.idQuiz);
        };

        buttonGroup.appendChild(copyButton);
        inputGroup.appendChild(input);
        inputGroup.appendChild(buttonGroup);
        linkCell.appendChild(inputGroup);
        row.appendChild(linkCell);

        var actionsCell = document.createElement("td");
        var updateButton = document.createElement("button");

        updateButton.className = "btn btn-info btn-sm update-quiz";
        updateButton.textContent = "Update";
        updateButton.id = "updateQuizz-" + quiz.idQuiz;
        updateButton.setAttribute("data-id", quiz.idQuiz);

updateButton.addEventListener("click", function () {
    fetchOneQuiz(quiz.idQuiz);


    
});



        var deleteButton = document.createElement("button");
        deleteButton.className = "btn btn-danger btn-sm delete-quiz";
        deleteButton.textContent = "Delete";
        deleteButton.setAttribute("data-id", quiz.idQuiz);

        function showDeleteModal() {
            deleteModal.style.display="block";
            document.getElementById("deleteQuizzButton").addEventListener("click", function () {
                deleteQuizz(quiz.idLeaderboard, quiz.idQuiz);
            });
        }

        deleteButton.addEventListener("click", showDeleteModal);

        var actionsGroup = document.createElement("div");
        actionsGroup.className = "btn-group";
        actionsGroup.appendChild(updateButton);
        actionsGroup.appendChild(deleteButton);
        actionsCell.appendChild(actionsGroup);
        row.appendChild(actionsCell);
    }

    return row;
}




// Data from database

//
export function UpdateListOfQuizzes() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "database/displayQuizzes.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var tableBody = document.getElementById("quiz-table");
            tableBody.innerHTML = ''; // Clear the current table content

            if (data.length === 0) {
                var noDataRow = document.createElement("tr");
                var noDataCell = document.createElement("td");
                noDataCell.setAttribute("colspan", "3"); // Span across all columns
                noDataCell.textContent = "No quizzes have been created yet";
                noDataCell.className = "text-center"; // Add the class to center the text
                noDataRow.appendChild(noDataCell);
                tableBody.appendChild(noDataRow);
            } else {
                data.forEach(function (quiz) {
                    tableBody.appendChild(createTableRow(quiz));
                });
            }
        }
    };

    xhr.send();
}


// Fetches quiz data based on the provided quiz ID and redirects to the update quiz page.
function fetchOneQuiz(quizId) {
    fetch("database/detailQuizz.php?quizId=" + quizId)
        .then(response => response.json())
        .then(data => {
            const quizData = data;

            const quizDataString = JSON.stringify(quizData);

            window.location.href = "update-quizz.php?quizData=" + encodeURIComponent(quizDataString);
        })
        .catch(error => {
            console.error("Error while retrieving quiz information: " + error);
        });
}

export function fetchAllQuizzes() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "database/displayQuizzes.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var tableBody = document.getElementById("quiz-table");
            tableBody.innerHTML = ''; // Clear the current table content

            if (data.length === 0) {
                // No data to display, add "No data" in a row
                var noDataRow = createTableRow(null); // Call the function with null for No data
                tableBody.appendChild(noDataRow);
            } else {
                data.forEach(function (quiz) {
                    tableBody.appendChild(createTableRow(quiz));
                });
            }
        }
    };

    xhr.send();
}


// Function to add data to the database
export function addNewQuizz() {
    // Create an XMLHttpRequest object to make an AJAX request
    var xhr = new XMLHttpRequest();

    // Configure the request
    xhr.open("POST", "database/addNewQuizz.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
  

    newQuizz.idQuizz = generateIdQuizz(16);
    newQuizz.title = document.getElementById("quizName").value;
    newQuizz.description = document.getElementById("quizDescription").value;
    newQuizz.userName = 'Pere';
    
    // Convert the data to a JSON string
    var jsonData = JSON.stringify(newQuizz);

    // Define a function to execute when the request is complete
    xhr.onload = function () {
        if (xhr.status === 200) {
            // The server responded successfully, you can handle the response here
            var responseText = xhr.responseText;
            afficherConfirmationModal(newQuizz.idQuizz);


        } else {
            // Handle request errors here
            console.error("Request error: " + xhr.status);
        }
    };

    // Send the data to the server
    xhr.send(jsonData);

}


export function UpdateQuizData(updatedQuiz){
                updatedQuiz.title = document.getElementById("quizName").value;
                updatedQuiz.description = document.getElementById("quizDescription").value;



        const transformedQuiz = transformQuizStructure(updatedQuiz);


    // Send an AJAX request to the PHP script for updating the quiz
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "database/updateQuizz.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText;
            window.location.href = "list-quizzes.php?updated=true";


        } else {
            console.error("Error updating quiz: " + xhr.status);
        }
    };

    // Convert the updated quiz data to JSON and send it to the server
    const updatedQuizJSON = JSON.stringify(transformedQuiz);
    xhr.send(updatedQuizJSON);


}





export function deleteQuizz(leaderboardId, quizId) {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define the URL for the deleteQuizz.php file, including the quizId
    var url = "database/deleteQuizz.php?leaderboardId=" + leaderboardId + "&quizId=" + quizId;

    // Configure the request as a DELETE request
    xhr.open("DELETE", url, true);

    // Set the content type 
    xhr.setRequestHeader("Content-Type", "application/json");

    // Define a function to execute when the request is complete
    xhr.onload = function () {
        if (xhr.status === 200) {
            // The server responded successfully, you can handle the response here
            var responseText = xhr.responseText;
            confirmationMessage.textContent = "Quiz deleted successfully!";
            confirmationMessage.style.display = "block";

            deleteModal.style.display="none";


            setTimeout(() => {
                confirmationMessage.style.display = "none";

            }, 3000); // 3000 millisecondes (3 secondes)

            UpdateListOfQuizzes();
        } else {
            // Handle request errors here
            console.error("Request error: " + xhr.status);
        }
    };

    // Send the DELETE request to delete the quiz
    xhr.send();
}






