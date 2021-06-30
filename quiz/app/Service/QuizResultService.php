<?php

namespace App\Service;

use App\DTO\QuizDTO;
use App\DTO\QuestionDTO;
use App\DTO\ChoiceDTO;
use App\DTO\AnswersDTO;
use App\DTO\AnswerDTO;

use Exception;

class QuizResultService
{
    private QuizDTO $quiz;
    private AnswersDTO $answers;

    public function __construct(QuizDTO $quiz, AnswersDTO $answers)
    {
        $this->quiz = $quiz;
        $this->answers = $answers;
    }

    public function getResult(): float
    {
        $result = 0.0;
        $number_of_correct_answer = 0;
        $questions = $this->quiz->getQuestions();
        foreach ($this->answers->getAnswers() as $answer) {
            $correct_answer_choices = 0;
            foreach ($questions as $question) {
                if ($question->getUUID() == $answer->getQuestionUUID()) {
                    foreach ($question->getChoices() as $choice) {
                        if ($choice->isCorrect()) {
                            $correct_answer_choices++;
                        }
                    }
                }
            }
            foreach($answer->getСhoices() as $choice) {
                foreach ($questions as $question) {
                    if ($question->getUUID() == $answer->getQuestionUUID()) {
                        foreach ($question->getChoices() as $choice_question) {
                            if ($choice_question->getUUID() == $choice) {
                                if ($choice_question->isCorrect()) {
                                    $correct_answer_choices--;
                                } else {
                                    $correct_answer_choices++;
                                }
                            }
                        }
                    }
                }
            }
            if($correct_answer_choices == 0) {
                $number_of_correct_answer++;
            }

        }

        return $number_of_correct_answer/sizeof($questions);
    }
}
