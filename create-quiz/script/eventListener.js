import { addNewQuizz, deleteQuizz,UpdateListOfQuizzes ,displayQuizInfos,UpdateQuizData} from './manageData.js';
import { validateInputs,inputOnReadOnly,toggleInputReadOnly,addQuestionToList,finishCreation} from './utils.js';
import { getInputIds,newQuizz} from './globals.js';
import { showQuestionCard,saveQuestionData,addQuestionButton,deleteQuestionCard} from './manageCard.js';



let actualQuestion;


/* This function dynamically controls the behavior of a button based on its text content,
invoking specific actions such as saving, editing, or updating a question*/

export function switchButtonState(event,buttonId,questionNumber) {
    const button = document.getElementById(buttonId);

    if (button.textContent === "Save Question") {
    handleSaveQuestion(event,button);  

    } 
    else if (button.textContent === "Edit Question") {
    handleEditQuestion(event,button);

    } 
    else if (button.textContent === "Update Question") {
    handleUpdateQuestion(event,button);

    }
}


function handleEditQuestion(event,button){
    const buttonId = event.target.id;
    const questionNumber = buttonId[buttonId.length - 1];
    button.textContent = "Update Question";
    button.id = 'update-question' + questionNumber;
    var question = document.getElementById("questionText" + questionNumber);
    actualQuestion = question.value;


}
export function handleUpdateQuestion(event,button){


    const buttonId = event.target.id;
    const questionNumber = buttonId[buttonId.length - 1];

    if (buttonId && buttonId.startsWith("update-question")) {
        var question = document.getElementById("questionText" + questionNumber);
        let valid_card = validateInputs(questionNumber);
        const inputs = getInputIds(questionNumber);

        if(valid_card){
            inputOnReadOnly(inputs);
            newQuizz.questions = newQuizz.questions.filter(q => q.question !== actualQuestion);
            button.textContent = "Edit Question";
            button.id = 'edit-question' + questionNumber;
    
         }
    }
    addQuestionToList(questionNumber);

}


function handleSaveQuestion(event,button) {
    event.preventDefault(); // Prevent any default behavior

    const buttonId = event.target.id;
    if (buttonId && buttonId.startsWith("save-question")) {
        // retriev indice of question card
        const questionNumber = buttonId[buttonId.length - 1];
        
        let valid_card = validateInputs(questionNumber);
        
        // add of input in list
        const inputs = getInputIds(questionNumber);
        
             
        if(valid_card){
        inputOnReadOnly(inputs);
        button.textContent = "Edit Question";
        button.id = 'edit-question' + questionNumber;
        addQuestionToList(questionNumber);
        const btn = document.getElementById("showQuestion"+questionNumber);
        btn.classList.remove("btn-danger");
        btn.classList.add("btn-success");
            
        }
    }
}



// Function to delete a row from the quiz preview table
function deleteRow(index) {
    const table = document.querySelector("#quizPreview table tbody");
    table.deleteRow(index);
}

// go to new quizz page

function goToNewQuizzPage() {
    // Sélectionnez le bouton "Add New Quiz"
    var addQuizButton = document.querySelector(".add-quiz-button");

    if (addQuizButton) {
        addQuizButton.addEventListener("click", function () {
            window.location.href = "new-quizz.php";
        });
    }
}

function goToListQuizzesPage() {
    var listQuizzesButton = document.getElementById("cancelCreation");
    var finalisationCreation = document.getElementById("finalisationCreation");

    if (listQuizzesButton) {
        listQuizzesButton.addEventListener("click", function () {
            window.location.href = "list-quizzes.php";
        });
    }

    if (finalisationCreation) {
        finalisationCreation.addEventListener("click", function () {
            window.location.href = "list-quizzes.php?added=true"
        });
    }
}





// Define a function to handle quiz deletion
function handleQuizDeletion() {
    const deleteModal = document.getElementById("deleteModal");

    // Handle click event on the "Cancel" button
    $("#cancelDelete").click(function() {
        // Hide the modal when the "Cancel" button is clicked
        deleteModal.style.display = "none";
    });

    // Handle click event on the "Delete" button
    $(".delete-quiz").click(function() {
        var quizId = $(this).data("id");
        // Set the "data-id" attribute of the modal for the quiz ID
        $("#deleteModal").setAttribute("data-id", quizId);
        // Show the confirmation modal
        deleteModal.style.display = "block";
    });

    // Handle click event on the confirmation button for deletion
    $("#deleteQuizzButton").click(function() {
var quizId = $("#deleteModal").data("id");
        $("#" + quizId).closest("tr").remove();
        // Hide the modal
        deleteModal.style.display = "none";

        // Reset the "data-id" attribute
        deleteModal.removeAttribute("data-id");
    });
}



// Function to handle the deletion of a question when the "Delete Question" button is clicked
function handleQuestionDeletion() {
    $(document).ready(function () {
        $(".question .btn-danger").click(function () {
            $(this).closest('.question').remove();
        });
    });
}







document.addEventListener("DOMContentLoaded", function () {
    const currentPage = document.body.id;
    if (currentPage === "list-quizzes") {
        UpdateListOfQuizzes();
        goToNewQuizzPage();
        $(document).ready(function() {
            handleQuizDeletion();
        });
        handleQuestionDeletion();
        
        

    } else if (currentPage === "new-quizz") {
        goToListQuizzesPage();
        document.getElementById("finishCreation").addEventListener("click", finishCreation);
        document.getElementById("addQuestion").addEventListener("click", addQuestionButton);
        document.getElementById("showQuestion1").addEventListener("click", function() {
        showQuestionCard("1");
        
          });
        showQuestionCard("1");
        document.getElementById("validateQuizzButton").addEventListener("click", function() {
        addNewQuizz(); 
    });



    }

    else if (currentPage === "update-quizz"){
                goToListQuizzesPage();
                        displayQuizInfos();


            
        showQuestionCard("1");
                document.getElementById("addQuestion").addEventListener("click", addQuestionButton);


 document.getElementById("showQuestion1").addEventListener("click", function() {
        showQuestionCard("1");
        
          });

        goToListQuizzesPage();
            document.getElementById("finishCreation").addEventListener("click", finishCreation);


          document.getElementById("UpdateQuizzButton").addEventListener("click", function() {
        UpdateQuizData(newQuizz);
    });





    }
});





document.addEventListener("click", function (event) {
    event.preventDefault();
    const buttonId = event.target.id;
    const questionNumber = buttonId[buttonId.length - 1];
    const inputs = getInputIds(questionNumber);

    if (buttonId && (buttonId.startsWith("save-question") || buttonId.startsWith("edit-question") || buttonId.startsWith("update-question"))) {

        switchButtonState(event,buttonId,questionNumber);
    }

if (buttonId.startsWith("deleteQuestionCard")){
    var deleteButton = document.getElementById(buttonId);

       deleteQuestionCard(deleteButton);
    }

    if (buttonId.startsWith("edit-question")){
                    toggleInputReadOnly(inputs);

    }

   
    

    
});










