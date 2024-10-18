export let newQuizz = {
    "idQuizz": null,
    "title": null,
    "description": null,
    "userName": null,
    "questions": [
        {
            "question": null,
            "answers": [],
        }
    ]
};

//export let newQuizz = {};

export function getInputIds(questionNumber) {
    const inputs = [
        'questionText' + questionNumber,
        "option1Text" + questionNumber,
        "option2Text" + questionNumber,
        "option3Text" + questionNumber,
        "option4Text" + questionNumber,
        "correctAnswer" + questionNumber
    ];
    return inputs;
}


