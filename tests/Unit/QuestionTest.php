<?php

namespace Tests\Unit;

use App\Models\Question;
use Tests\TestCase;

class QuestionTest extends TestCase
{

    public function testToArrayReturnsSameData()
    {
        [$params, $answers] = $this->createQuestion()->toArray();

        $question = new Question($params, $answers);

        $this->assertEquals([$params, $answers], $question->toArray());
    }

    public function testMultipleSelectionEqualsGivenFalse()
    {
        $question = $this->createQuestion(false);
        $this->assertFalse($question->isMultiple());
    }

    public function testTotalEqualsAnswersSumForMultipleSelection()
    {
        $question = $this->createQuestion(true);
        [, $answers] = $question->toArray();

        $total = 0;

        $answers->each(function($answer) use(&$total) {
            $total += $answer->score();
        });

        $this->assertEquals($total, $question->total());
    }

    public function testTotalEqualsMaxAnswerValueForSingleSelection()
    {
        $question = $this->createQuestion();
        [, $answers] = $question->toArray();

        $max = $answers->map(function ($answer) { return $answer->score(); })->max();

        $this->assertEquals($max, $question->total());

    }

    public function testSingleSelectionActualEqualsGivenValue()
    {
        $question = $this->createQuestion();
        [$params, $answers] = $question->toArray();

        $given = $answers->filter(function($answer) use($params) {
            return $answer->uuid() == $params['response'][0];
        })->first();

        $this->assertEquals($given->score(), $question->actual());
    }

    public function testMultipleSelectionActualEqualsGivenValue()
    {
        $question = $this->createQuestion(true);
        [$params, $answers] = $question->toArray();

        $ids = $params['response'];

        $actual = $answers->filter(function ($answer) use ($ids) {
            return in_array($answer->uuid(), $ids);
        })->map(function ($answer) { return $answer->score(); })->sum();

        $this->assertEquals($actual, $question->actual());

    }

    /*
    public function testSingleSelectionUndeterminesReturnsZeroTotal()
    {

    }

    public function testMultipleSelectionUndeterminesReturnsZeroTotal()
    {

    }

    public function testAnswerNotFromSetThrowsException()
    {

    }
*/

}
