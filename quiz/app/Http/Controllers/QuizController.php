<?php

namespace App\Http\Controllers;

use App\DTO\AnswerDTO;
use App\DTO\AnswersDTO;
use App\DTO\ChoiceDTO;
use App\DTO\QuestionDTO;
use App\DTO\QuizDTO;
use App\Models\Quiz;
use App\Service\QuizResultService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public int $indexQuestion = 0;

    public function homePage(Request $request)
    {
        $request->session()->forget('indexQuestion');
        $request->session()->forget('arrayAnswers');
        $quizzes_base = Quiz::all();
        $quizzes_dto = array();

        foreach ($quizzes_base as $quiz_base) {
            $quizzes_dto[] = new QuizDTO($quiz_base->id, $quiz_base->title);
        }

        return view('home', [
            'list_quizzes' => $quizzes_dto
        ]);
    }

    public function getQuiz(Request $request)
    {
        $quiz_base = Quiz::find($request->input('quiz_id'));
        $questions_base = $quiz_base->getQuestions()->first()->get();

        $quiz_dto = new QuizDTO($quiz_base->id, $quiz_base->title);
        if ($request->session()->has('indexQuestion')) {
            $this->indexQuestion = $request->session()->get('indexQuestion', 0);
        } else {
            $this->indexQuestion = 0;
            $request->session()->put('indexQuestion', $this->indexQuestion);
        }

        if ($request->has('choice')) {
            $this->setAnswers($request->input('choice'),
                $request,
                $this->indexQuestion,
                $questions_base[$this->indexQuestion]['id']);
        }

        if (request('button') == 'end_quiz') {
            return $this->getResult($request);
        }

        $this->getQuestion(count($questions_base));
        $request->session()->put('indexQuestion', $this->indexQuestion);

        $question_dto = new QuestionDTO($questions_base[$this->indexQuestion]['id'], $questions_base[$this->indexQuestion]['text']);
        $choices_base = $questions_base[$this->indexQuestion]->getChoices()->get();

        foreach ($choices_base as $choice_base) {
            $question_dto->addChoice(new ChoiceDTO($choice_base['id'], $choice_base['text'], false));
        }

        $quiz_dto->addQuestion($question_dto);

        $answers = $this->getAnswers($request, $this->indexQuestion);

        return view('quiz', [
            'quiz' => $quiz_dto,
            'question' => $question_dto,
            'answers' => $answers
        ]);
    }

    private function getAnswers(Request $request, $indexQuestion)
    {
        $list_answer = array();

        if ($request->session()->has('arrayAnswers')) {
            $arrayAnswers = $request->session()->get('arrayAnswers', array());
            if (isset($arrayAnswers[$indexQuestion])) {
                foreach ($arrayAnswers[$indexQuestion] as $answer) {
                    if (isset($answer['choice_id']) && (!empty($answer['choice_id']))) {
                        $list_answer[$answer['choice_id']] = 'cheked';
                    }
                }
            }
        }

        return $list_answer;
    }

    private function setAnswers(array $list_answers, Request $request, $indexQuestion, $question_id)
    {
        $arrayAnswers = array();
        if ($request->session()->has('arrayAnswers')) {
            $arrayAnswers = $request->session()->get('arrayAnswers', array());
        }

        $answers = array();
        foreach ($list_answers as $answer) {
            $str_answer = [
                'question_id' => $question_id,
                'choice_id' => $answer
            ];
            $answers[] = $str_answer;
        }
        $arrayAnswers[$indexQuestion] = $answers;

        $request->session()->put('arrayAnswers', $arrayAnswers);
    }

    private function getQuestion($max)
    {
        switch (request('button')) {
            case 'prev_question':
                $this->indexQuestion--;
                break;
            case 'next_question':
                $this->indexQuestion++;
                break;
        }

        if ($this->indexQuestion < 0) $this->indexQuestion = 0;
        if ($this->indexQuestion >= $max) $this->indexQuestion = --$max;
    }

    private function getResult(Request $request)
    {
        $quiz_id = $request->input('quiz_id');
        $quiz_base = Quiz::find($quiz_id);
        $questions_base = $quiz_base->getQuestions()->first()->get();
        $quiz_dto = new QuizDTO($quiz_base->id, $quiz_base->title);
        $answers_dto = new AnswersDTO($quiz_id);
        $arrayAnswers = array();

        if ($request->session()->has('arrayAnswers')) {
            $arrayAnswers = $request->session()->get('arrayAnswers', array());
        }

        foreach ($questions_base as $question) {
            $question_dto = new QuestionDTO($question['id'], $question['text']);
            $choices_base = $question->getChoices()->get();
            $answer_dto = new AnswerDTO($question['id']);
            foreach ($choices_base as $choice_base) {
                $choice_dto = new ChoiceDTO($choice_base['id'], $choice_base['text'], (bool)$choice_base['is_сorrect']);
                $question_dto->addChoice($choice_dto);

                foreach ($arrayAnswers as $answer) {

                    foreach ($answer as $choice) {
                        if (isset($choice['choice_id']) && $choice['choice_id'] == $choice_base['id']) {
                            $answer_dto->addChoiceUUID($choice_base['id']);
                        }
                    }
                }
            }
            $answers_dto->addAnswer($answer_dto);
            $quiz_dto->addQuestion($question_dto);
        }

        $quizResultService = new QuizResultService(
            $quiz_dto,
            $answers_dto
        );

        $result = $quizResultService->getResult() * 100;

//        $request->session()->forget('indexQuestion');
//        $request->session()->forget('arrayAnswers');

        return view('result', [
            'result' => $result
        ]);
    }
}
