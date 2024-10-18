import {newQuizz,getInputIds} from './globals.js';



// widget
export function inputOnReadOnly(inputs) {
    // Iterate through the list of input IDs
    for (const id of inputs) {
        // Get the DOM element with the specified ID
        const element = document.getElementById(id);
        if (element) {
            // Check if the element is a SELECT element
            if (element.tagName === 'SELECT') {
                // For a SELECT element, use 'disabled' instead of 'readOnly'
                element.disabled = true;
            } else {
                // For other elements, use 'readOnly'
                element.readOnly = true;
            }
        }
    }
}



export function toggleInputReadOnly(inputs) {
    for (const id of inputs) {
        const element = document.getElementById(id);
        if (element) {
            if (element.tagName === 'SELECT') {
                // Toggle the 'disabled' state for SELECT elements
                element.disabled = false;
            } else {
                // Toggle the 'readOnly' state for other elements
                element.readOnly = false;
            }
        }
    }
}

export function copyLink(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            document.execCommand("copy");
        }


// verification
function verify_input(text,error_label){
    if (text.trim() === '') {
            error_label.style.display = 'block';
        return false;
        } else {
            error_label.style.display = 'none';
            return true;
        }
}


export function validateInputs(questionNumber) {
    const inputFields = [
        { id: 'questionText', label: 'questionTextError' },
        { id: 'option1Text', label: 'option1TextError' },
        { id: 'option2Text', label: 'option2TextError' },
        { id: 'option3Text', label: 'option3TextError' },
        { id: 'option4Text', label: 'option4TextError' }
    ];

    const errors = []; 

    for (const field of inputFields) {
        const input = document.getElementById(field.id + questionNumber);
        const errorLabel = document.getElementById(field.label + questionNumber);

        if (input) {
            if (!verify_input(input.value, errorLabel)) {
                errors.push(`This field is required: ${field.id}`);
            }
        }
    }

    for (const error of errors) {
        console.log(error);
    }

    return errors.length === 0; 
}



// add data to the list
        
export function addQuestionToList(questionNumber) {


    // Get the input IDs associated with the questionNumber
    const inputIds = getInputIds(questionNumber);

    // Create a dictionary to store the values with the questionNumber as the key
    const values = {};

    // Iterate through the input IDs and retrieve their values
    for (const inputId of inputIds) {
        const inputElement = document.getElementById(inputId);
        if (inputElement) {
            values[inputId] = inputElement.value;
        }
        

    }


    // Add the values for this question to the newQuizz dictionary
     let newQuestion = {
        question: values["questionText" + questionNumber],
        answers: [
            values["option1Text" + questionNumber],
            values["option2Text" + questionNumber],
            values["option3Text" + questionNumber],
            values["option4Text" + questionNumber]
        ],
        correctAnswer: document.getElementById("correctAnswer" + questionNumber).selectedIndex,

    };
 
 
 if (newQuizz.questions && newQuizz.questions.length > 0) {
    // Il y a au moins une question dans le tableau
    if (newQuizz.questions[0].question === null) {
        newQuizz.questions[0] = newQuestion;
    } else {
        newQuizz.questions.push(newQuestion);
    }
} else {
    // Le tableau est vide, ajoutez directement la nouvelle question
    newQuizz.questions = [newQuestion];
}



/*if (newQuizz.questions[0].question === null) {
    newQuizz.questions[0] = newQuestion;

} else {

    newQuizz.questions.push(newQuestion);
}*/


    
}


export function transformQuizStructure(updatedQuiz) {
    const transformedQuiz = {
        idQuizz: updatedQuiz.idQuizz,
        title: updatedQuiz.title,
        description: updatedQuiz.description,
        userName: updatedQuiz.userName,
        questions: updatedQuiz.questions.map(question => ({
            question: question.question,
            answers: question.answers, // Utiliser la bonne propriété "answers"
            correctAnswer: question.correctAnswer
        }))
    };

    return transformedQuiz;
}




// ----

export function generateIdQuizz(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomString = '';
    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        randomString += characters.charAt(randomIndex);
    }
    return randomString;
}



export function toggleTrashIconOnFirstCard(addIcon) {
    var firstCard = document.querySelector(".question-card"); 
    if (firstCard) {
        var titleElement = firstCard.querySelector(".card-title"); 
        var trashIcon = firstCard.querySelector(".fas.fa-trash"); 

        if (addIcon) {
            if (!trashIcon) {
                var trashIcon = document.createElement("button");
                trashIcon.className = "fas fa-trash";
                trashIcon.id = "deleteQuestionCard1";
                var trashIconContainer = document.createElement("div"); 
                trashIconContainer.className = "d-flex align-items-center"; 
                trashIconContainer.appendChild(trashIcon);
                titleElement.insertAdjacentElement("afterend", trashIconContainer); 
            }
        } else {
            if (trashIcon) {
                trashIcon.parentElement.remove(); 
            }
        }
    }
}



// quizz preview
export function finishCreation() {
    const questionCards = document.querySelectorAll(".question-card");
    let quizPreview = document.getElementById("quizPreview");
    confirmationMessage.textContent = "You must add at least one question before finishing!";



if(document.getElementById("quizName").value !== "" )

    {

    document.getElementById("quizzNameError").style.display = "none";



if (newQuizz.questions.length>0){
    

if (newQuizz.questions[0].question !== null) {


   
    // Get the body of the table inside the "quizPreview" element
    const modalBody = quizPreview.querySelector(".modal-body tbody");
    // Clear the existing content of the table
    modalBody.innerHTML = '';

    if (questionCards.length > 0) {
        const table = document.createElement("table");
        table.classList.add("table");
        table.style.borderCollapse = "collapse";



        questionCards.forEach(function (questionCard) {
    const questionTextElement = questionCard.querySelector(".form-control");
    if (questionTextElement) {
        const questionText = questionTextElement.value;
        const questionId = questionCard.id.split("-")[2];

        const correctAnswerSelect = questionCard.querySelector(`#correctAnswer${questionId}`);
        if (correctAnswerSelect && correctAnswerSelect.selectedIndex >= 0) {
            const correctAnswerText = correctAnswerSelect.options[correctAnswerSelect.selectedIndex].text;

            const matchingQuestion = newQuizz.questions.find(q => q.question === questionText);

            if (matchingQuestion) {
                const row = table.insertRow();
                const cell1 = row.insertCell(0);
                const cell2 = row.insertCell(1);
                const cell3 = row.insertCell(2);

                cell1.classList.add("col-4", "align-middle", "text-center");
                cell2.classList.add("col-4", "align-middle", "text-center");
                cell3.classList.add("col-4", "align-middle", "text-center");

                cell1.textContent = questionText;
                cell2.textContent = correctAnswerText;
            }
        }
    }
});




        const thead = table.createTHead();
        const headerRow = thead.insertRow(0);
        headerRow.innerHTML = '<th class="col-4 text-center">Question</th><th class="col-4 text-center">Correct Answer</th><th class="col-4 text-center"></th>';

        quizPreview.querySelector(".modal-body tbody").appendChild(table);
         $('#quizPreview').modal('show'); 
    } else {
        confirmationMessage.style.display = "block";

            setTimeout(function () {
                confirmationMessage.style.display = "none";
            }, 3000);


    }

}

else {
        $('#quizPreview').modal('hide');

            confirmationMessage.style.display = "block";

            setTimeout(function () {
                confirmationMessage.style.display = "none";
            }, 3000);

    }


}

else {

    confirmationMessage.style.display = "block";

            setTimeout(function () {
                confirmationMessage.style.display = "none";
            }, 3000);
   
}

} 
else 
{
    document.getElementById("quizzNameError").style.display = "block";

    $('#quizPreview').modal('hide');

}
}



export function afficherConfirmationModal(quizLink) {
    // Fermez le modal existant
    $('#quizPreview').modal('hide');
    
    // Récupérez le champ d'entrée du lien
    var quizLinkInput = document.getElementById("quizLink");
    // Remplacez la valeur du champ d'entrée avec le lien passé en paramètre
    quizLinkInput.value = quizLink;

    // Affichez le modal de confirmation
    $('#confirmationModal').modal('show');

    // Sélectionnez le bouton "Copier le lien" par son ID
    var copyButton = document.getElementById("copyLinkButton");

    // Ajoutez un gestionnaire d'événements au bouton
    copyButton.addEventListener("click", function () {
        // Appelez la fonction copyLink avec l'ID du quiz
        copyLink("quizLink");
    });
}



