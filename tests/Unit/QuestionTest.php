<?php

namespace Tests\Unit;

use App\Models\Question;
use Tests\TestCase;

class QuestionTest extends TestCase
{

    public function testQuestionToArrayReturnsSameData()
    {
        [$params, $answers] = $this->createQuestion()->toArray();

        $question = new Question($params, $answers);

        $this->assertEquals([$params, $answers], $question->toArray());
    }

    public function testQuestionMultipleSelectionEqualsGivenFalse()
    {
        $question = $this->createQuestion(false);
        $this->assertFalse($question->multipleSelectionAllowed());
    }

    public function testQuestionTotalEqualsAnswersSumForMultipleSelection()
    {
        $question = $this->createQuestion(true);
        [, $answers] = $question->toArray();

        $total = 0;

        $answers->each(function($answer) use(&$total) {
            $total += $answer->score();
        });

        $this->assertEquals($total, $question->total());
    }

    public function testQuestionTotalEqualsMaxAnswerValueForSingleSelection()
    {
        $question = $this->createQuestion();
        [, $answers] = $question->toArray();

        $max = $answers->map(function ($answer) { return $answer->score(); })->max();

        $this->assertEquals($max, $question->total());



    }

/*
    public function testQuestionActualEqualsGivenValue()
    {
        $question = $this->createQuestion();
        [$params, $answers] = $question->toArray();

        $given = $answers->filter(function($answer) use($params) {
            return $answer->uuid() == $params['response'][0];
        })->first();


        $this->assertEquals($given->score(), $question->actual());

    }
*/

}
