define(["require", "exports", "tslib", "WoltLabSuite/Core/Dom/Util", "WoltLabSuite/Core/Language"], function (require, exports, tslib_1, Util_1, Language_1) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    exports.QuestionView = void 0;
    Util_1 = tslib_1.__importDefault(Util_1);
    // buttons
    const button1 = document.createElement('button');
    const button2 = document.createElement('button');
    const button3 = document.createElement('button');
    const button4 = document.createElement('button');
    const buttons = [button1, button2, button3, button4];
    // question
    const question = document.createElement('p');
    const explanation = document.createElement('p');
    // next button
    const nextButton = document.createElement('button');
    // options
    const options = ['A', 'B', 'C', 'D'];
    // internal templates
    function buildButtonField() {
        const buttonList = document.createElement('ul');
        buttonList.classList.add('optionButtons');
        buttons.forEach((button) => {
            const li = document.createElement('li');
            li.appendChild(button);
            buttonList.appendChild(li);
        });
        return buttonList;
    }
    function buildQuestionField() {
        const questionContainer = document.createElement('div');
        questionContainer.classList.add('question');
        questionContainer.appendChild(question);
        return questionContainer;
    }
    function buildExplanationField() {
        explanation.classList.add('explanation');
        const explanationContainer = document.createElement('div');
        explanationContainer.appendChild(explanation);
        return explanationContainer;
    }
    function buildNextField() {
        nextButton.textContent = Language_1.get('wcf.quizCreator.game.button.next');
        nextButton.classList.add('next');
        const nextContainer = document.createElement('div');
        nextContainer.appendChild(nextButton);
        return nextContainer;
    }
    class QuestionView {
        constructor(registerAnswer, nextCallback) {
            this.registerAnswer = registerAnswer;
            this.goToNextQuestion = nextCallback;
            this.viewContainer = document.createElement('div');
            this.viewContainer.classList.add('questionView');
            Util_1.default.hide(this.viewContainer);
            this.viewContainer.append(buildQuestionField(), buildButtonField(), buildExplanationField(), buildNextField());
            this.prepareButtons();
        }
        getView() {
            return this.viewContainer;
        }
        prepareFor(newQuestion, callback) {
            this.question = newQuestion;
            question.textContent = this.question.question;
            // update buttons
            buttons.sort(() => 0.5 - Math.random());
            options.forEach((option, index) => {
                buttons[index].setAttribute('data-option', option.toLowerCase());
                buttons[index].textContent = this.question.options[option];
                buttons[index].classList.remove('correct', 'incorrect');
                buttons[index].disabled = false;
            });
            if (callback) {
                nextButton.textContent = Language_1.get('wcf.quizCreator.game.button.last');
                this.goToNextQuestion = callback;
            }
        }
        checkAnswer(clickedButton) {
            var _a;
            const target = clickedButton.target;
            if (target !== null && target instanceof HTMLElement) {
                this.selectedOption = (_a = target.getAttribute('data-option')) !== null && _a !== void 0 ? _a : '';
                this.selectedOption = this.selectedOption.toLowerCase();
                this.updateField(this.registerAnswer(this.selectedOption));
            }
        }
        nextQuestion() {
            // next button
            nextButton.disabled = true;
            nextButton.classList.remove('show');
            // explanation
            explanation.classList.remove('show');
            // execute callback for next question
            this.goToNextQuestion();
        }
        updateField(isCorrect) {
            // update and disable buttons
            buttons.forEach((button) => {
                var _a;
                let option = (_a = button.getAttribute('data-option')) !== null && _a !== void 0 ? _a : '';
                option = option.toLowerCase();
                if (isCorrect && option == this.selectedOption) {
                    button.classList.add('correct');
                }
                else {
                    if (option == this.selectedOption) {
                        button.classList.add('incorrect');
                    }
                }
                button.disabled = true;
            });
            // explanation
            explanation.textContent = this.question.explanation;
            explanation.classList.add('show');
            // next buttons
            nextButton.disabled = false;
            nextButton.classList.add('show');
        }
        prepareButtons() {
            buttons.forEach((button) => {
                button.addEventListener('click', (ev) => {
                    this.checkAnswer(ev);
                });
            });
            nextButton.addEventListener('click', () => {
                this.nextQuestion();
            });
        }
    }
    exports.QuestionView = QuestionView;
});
