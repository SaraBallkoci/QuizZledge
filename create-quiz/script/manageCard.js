import { newQuizz} from './globals.js';
import { toggleTrashIconOnFirstCard} from './utils.js';

//  -- card
let questionData = []; 
let questionCounter = 1;
let maxCard=10;
let confirmationMessage = document.getElementById("confirmationMessage");


// manage card
function getQuestionCard(questionId) {
    var existingCard = document.getElementById(`question-card-${questionId}`);
    if (existingCard) {
        return existingCard;
    }

    var questionCard = createQuestionCard(questionId);
    questionCard.id = `question-card-${questionId}`;
    var questionList = document.querySelector(".question-list");
    questionList.appendChild(questionCard);
    return questionCard;
}


export function showQuestionCard(questionId) {
    var questionCards = document.querySelectorAll(".question-card");
    questionCards.forEach(function(card) {
        card.style.display = "none"; 
    });

    var questionCard = getQuestionCard(questionId);
    questionCard.style.display = "block"; 
    loadQuestionData(questionId);
    
}



export function createQuestionCard(questionId) {
    var questionCard = document.createElement("div");
    questionCard.className = "card mt-4 question-card";
    questionCard.id="question-card-"+questionId;
    questionCard.innerHTML = `
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">Question ${questionId}</h5>
                <button class="fas fa-trash" id="deleteQuestionCard${questionId}"></button>
            </div>
            <form>
                <div class="form-group">
                    <input type="text" class="form-control" id="questionText${questionId}" placeholder="What is my zodiac sign?">
                    <small style="display: none;" id="questionTextError${questionId}" class="form-text text-danger">This field is required.</small>
                </div>
                <h6 class="card-subtitle mt-4">Answer Options:</h6>
                <div class="form-group">
                    <div class="form-check mb-2">
                        <input type="text" class="form-control" id="option1Text${questionId}" placeholder="Aries">
                        <small style="display: none;" id="option1TextError${questionId}" class="form-text text-danger">This field is required.</small>
                    </div>
                    <div class="form-check mb-2">
                        <input type="text" class="form-control" id="option2Text${questionId}" placeholder="Gemini">
                        <small style="display: none;" id="option2TextError${questionId}" class="form-text text-danger">This field is required.</small>
                    </div>
                    <div class="form-check mb-2">
                        <input type="text" class="form-control" id="option3Text${questionId}" placeholder="Scorpio">
                        <small style="display: none;" id="option3TextError${questionId}" class="form-text text-danger">This field is required.</small>
                    </div>
                    <div class="form-check mb-2">
                        <input type="text" class="form-control" id="option4Text${questionId}" placeholder="Pisces">
                        <small style="display: none;" id="option4TextError${questionId}" class="form-text text-danger">This field is required.</small>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label for="correctAnswer${questionId}">Correct Answer:</label>
                    <select class="form-control" id="correctAnswer${questionId}">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                    </select>
                </div>
                <button class="btn btn-primary" id="save-question${questionId}">Save Question</button>
            </form>
        </div>
    `;

    var questionList = document.querySelector(".question-list");
    questionList.appendChild(questionCard);

    // Create a function to update answer options based on user input
function updateAnswerOptions() {
for (var i = 1; i <= 4; i++) {
var optionInput = document.getElementById(`option${i}Text${questionId}`);
var optionValue = optionInput.value;
var optionElement = document.querySelector(`#correctAnswer${questionId}`);

if (optionElement) {
    var option = optionElement.querySelector(`option[value="${i}"]`);

    if (option) {
        if (optionValue.trim() === "") {
            option.textContent = `Option ${i}`;
        } else {
            option.textContent = optionValue;
        }
    }
}
}
}

// Add an event listener to each option input to update options dynamically
for (var i = 1; i <= 4; i++) {
var optionInput = document.getElementById(`option${i}Text${questionId}`);
optionInput.addEventListener("input", updateAnswerOptions);
}


    return questionCard;
}



export function deleteQuestionCard(button) {
    var questionCardId = button.id.replace("deleteQuestionCard", "");
    var elements = document.querySelectorAll(".btn-question");
    var questionCard = document.getElementById("question-card-" + questionCardId);
    var showButton = document.getElementById("showQuestion"+questionCardId);
    var question = document.getElementById("questionText" + questionCardId);

    if (questionCard) {

        if (newQuizz.questions && newQuizz.questions.length > 0) {
            newQuizz.questions = newQuizz.questions.filter(q => q.question !== question.value);
        }

        questionCard.remove();


       if (showButton) {
            showButton.remove();
            questionCounter--;

            // Incrémentation pour les boutons restants
            for (var i = 0; i < elements.length; i++) {
                var currentButtonId = elements[i].id.replace("showQuestion", "");
                var currentCardId = elements[i].id.replace("question-card-", "");
                if (parseInt(currentButtonId) > parseInt(questionCardId)) {
                    var newId = "showQuestion" + (parseInt(currentButtonId) - 1);
                    elements[i].id = newId;
                    elements[i].textContent = (parseInt(currentButtonId) - 1).toString();
                    showQuestionCard(currentButtonId );
                    showQuestionCard(elements[i].textContent );

                   document.getElementById("questionText"+elements[i].textContent ).value = document.getElementById("questionText"+currentButtonId).value;
                 if (document.getElementById("questionText"+currentButtonId).readOnly) {
                    document.getElementById("questionText"+elements[i].textContent ).readOnly = true;
                } else {
                    document.getElementById("questionText"+elements[i].textContent ).readOnly = false;
                }
                                                       
                   document.getElementById("option1Text"+elements[i].textContent ).value = document.getElementById("option1Text"+currentButtonId).value;
                   if (document.getElementById("option1Text"+currentButtonId).readOnly) {
                    document.getElementById("option1Text"+elements[i].textContent ).readOnly = true;
                } else {
                    document.getElementById("option1Text"+elements[i].textContent ).readOnly = false;
                }

                   document.getElementById("option2Text"+elements[i].textContent ).value = document.getElementById("option2Text"+currentButtonId).value;
                   if (document.getElementById("option2Text"+currentButtonId).readOnly) {
document.getElementById("option2Text"+elements[i].textContent ).readOnly = true;
} else {
document.getElementById("option2Text"+elements[i].textContent ).readOnly = false;
}
                   document.getElementById("option3Text"+elements[i].textContent ).value = document.getElementById("option3Text"+currentButtonId).value;
                   if (document.getElementById("option3Text"+currentButtonId).readOnly) {
document.getElementById("option3Text"+elements[i].textContent ).readOnly = true;
} else {
document.getElementById("option3Text"+elements[i].textContent ).readOnly = false;
}
                   document.getElementById("option4Text"+elements[i].textContent ).value = document.getElementById("option4Text"+currentButtonId).value;
                   if (document.getElementById("option4Text"+currentButtonId).readOnly) {
document.getElementById("option4Text"+elements[i].textContent ).readOnly = true;
} else {
document.getElementById("option4Text"+elements[i].textContent ).readOnly = false;
}
                   document.getElementById("correctAnswer"+elements[i].textContent ).innerHTML = document.getElementById("correctAnswer"+currentButtonId).innerHTML;
                   document.getElementById("correctAnswer"+elements[i].textContent ).value = document.getElementById("correctAnswer"+currentButtonId).value;

if (document.getElementById("correctAnswer"+currentButtonId).disabled) {
document.getElementById("correctAnswer"+elements[i].textContent ).disabled = true;
} else {
document.getElementById("correctAnswer"+elements[i].textContent ).disabled = false;
}




const sourceButton = document.getElementById("question-card-" + currentButtonId).querySelector("button.btn.btn-primary");
const targetButton = document.getElementById("question-card-" + elements[i].textContent).querySelector("button.btn.btn-primary");



// Cloner le bouton source pour conserver une référence à l'original
const clonedSourceButton = sourceButton.cloneNode(true);

// Utiliser une expression régulière pour extraire le numéro de l'identifiant du bouton source
const sourceButtonIdMatch = sourceButton.id.match(/([a-zA-Z-]+)(\d+)/);
const sourceButtonPrefix = sourceButtonIdMatch[1]; // Préfixe
const sourceButtonNumber = sourceButtonIdMatch[2]; // Numéro

// Utiliser le numéro du bouton cible pour mettre à jour le bouton cloné
const newNumber = elements[i].textContent;
clonedSourceButton.id = sourceButtonPrefix + newNumber;

// Remplacer le bouton cible par le bouton source cloné
targetButton.parentNode.replaceChild(clonedSourceButton, targetButton);



document.getElementById("questionText"+currentButtonId).value = ""
document.getElementById("questionText"+currentButtonId).readOnly = false;

document.getElementById("option1Text"+currentButtonId).value = ""
document.getElementById("option1Text"+currentButtonId).readOnly = false;


document.getElementById("option2Text"+currentButtonId).value = ""
document.getElementById("option2Text"+currentButtonId).readOnly = false;


document.getElementById("option3Text"+currentButtonId).value = ""
document.getElementById("option3Text"+currentButtonId).readOnly = false;


document.getElementById("option4Text"+currentButtonId).value = ""
document.getElementById("option4Text"+currentButtonId).readOnly = false;


//document.getElementById("correctAnswer"+currentButtonId).innerHTML = ""
document.getElementById("correctAnswer"+currentButtonId).disabled = false;




                }


                
            }

           
            }





    }

}



// manage questions inside card

export function saveQuestionData(questionId) {
    var question = {
        questionText: document.getElementById(`questionText${questionId}`).value,
        option1Text: document.getElementById(`option1Text${questionId}`).value,
        option2Text: document.getElementById(`option2Text${questionId}`).value,
        option3Text: document.getElementById(`option3Text${questionId}`).value,
        option4Text: document.getElementById(`option4Text${questionId}`).value,
        correctAnswer: document.getElementById(`correctAnswer${questionId}`).value
    };
    questionData[questionId - 1] = question;
}


function loadQuestionData(questionId) {
    if (questionData[questionId - 1]) {
        var question = questionData[questionId - 1];
        document.getElementById(`questionText${questionId}`).value = question.questionText;
        document.getElementById(`option1Text${questionId}`).value = question.option1Text;
        document.getElementById(`option2Text${questionId}`).value = question.option2Text;
        document.getElementById(`option3Text${questionId}`).value = question.option3Text;
        document.getElementById(`option4Text${questionId}`).value = question.option4Text;
        document.getElementById(`correctAnswer${questionId}`).value = question.correctAnswer;
    } 
}




// manage card button
export function addQuestionButton() {
    if (questionCounter < 10) {
        questionCounter++;

        var newButton = createQuestionButton(questionCounter);

        toggleTrashIconOnFirstCard(true);
        

        document.getElementById("addQuestionButtons").appendChild(newButton);

        



    } else {
        confirmationMessage.textContent = "You have reached the limit of 10 questions!";
            confirmationMessage.style.display = "block";

            setTimeout(function () {
                confirmationMessage.style.display = "none";
            }, 3000); 
    }
}

function createQuestionButton(questionId) {
    var newButton = document.createElement("button");
    newButton.textContent = questionId;
    newButton.className = "btn btn-danger ml-2 btn-question";
    newButton.id = "showQuestion"+questionId;
    newButton.addEventListener("click", function() {
        var questionId = this.textContent;
        showQuestionCard(questionId);
    });
    return newButton;
}

export function fillQuestionCard(questionCard, questionData, index) {
    var questionId = questionData.idQuestion;

questionData.answers.forEach(function(answer) {
});           

    var questionText = questionCard.querySelector(`#questionText${index}`);
    var option1Text = questionCard.querySelector(`#option1Text${index}`);
    var option2Text = questionCard.querySelector(`#option2Text${index}`);
    var option3Text = questionCard.querySelector(`#option3Text${index}`);
    var option4Text = questionCard.querySelector(`#option4Text${index}`);
    var correctAnswer = questionCard.querySelector(`#correctAnswer${index}`);

    questionText.value = questionData.question;
    option1Text.value = questionData.answers[0].answer;
    option2Text.value = questionData.answers[1].answer;
    option3Text.value = questionData.answers[2].answer;
    option4Text.value = questionData.answers[3].answer;

while (correctAnswer.firstChild) {
correctAnswer.removeChild(correctAnswer.firstChild);
}

questionData.answers.forEach(function (answer, answerIndex) {
var optionElement = document.createElement("option");
optionElement.value = answerIndex+1;
optionElement.textContent = answer.answer;

if (answer.answer === questionData.correctAnswer) {

optionElement.selected = true; 
}


correctAnswer.appendChild(optionElement);


});





    
}

