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

    public function testSingleSelectionEqualsGivenFalse()
    {
        $question = $this->createQuestion(false);
        $this->assertFalse($question->isMultiple());
    }

    public function testTotalEqualsAnswersSumForMultipleSelection()
    {
        $question = $this->createQuestion(true);
        [, $answers] = $question->toArray();

        $total = 0;

        $answers->each(function ($answer) use (&$total) {
            $total += $answer->score();
        });

        $this->assertEquals($total, $question->total());
    }

    public function testTotalEqualsMaxAnswerValueForSingleSelection()
    {
        $question = $this->createQuestion(false);
        [, $answers] = $question->toArray();

        $max = $answers->map(function ($answer) {
            return $answer->score();
        })->max();

        $this->assertEquals($max, $question->total());

    }

    public function testSingleSelectionActualEqualsGivenValue()
    {
        $question = $this->createQuestion();
        [$params, $answers] = $question->toArray();

        $given = $answers->filter(function ($answer) use ($params) {
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
        })->map(function ($answer) {
            return $answer->score();
        })->sum();

        $this->assertEquals($actual, $question->actual());

    }

    public function testSingleSelectionUndeterminedReturnsZeroTotal()
    {
        [$qdata, $answers] = $this->createQuestionData(false, true, 10);
        $answers->add($undetermined = $this->createAnswer(true));

        $qdata['response'] = [$undetermined->uuid()];
        $question = new Question($qdata, $answers);


        $this->assertEquals(0, $question->total());

    }

    public function testMultipleSelectionUndeterminedReturnsZeroTotal()
    {
        [$qdata, $answers] = $this->createQuestionData(true, true, 10);
        $answers->add($undetermined = $this->createAnswer(true));

        $qdata['response'] = [$undetermined->uuid()];
        $question = new Question($qdata, $answers);


        $this->assertEquals(0, $question->total());

    }

    public function testMultipleSelectionMultipleUndeterminedReturnsZeroTotal()
    {
        [$qdata, $answers] = $this->createQuestionData(true, true, 10);
        $answers->add($undetermined1 = $this->createAnswer(true));
        $answers->add($undetermined2 = $this->createAnswer(true));

        $qdata['response'] = [$undetermined1->uuid(), $undetermined2->uuid()];
        $question = new Question($qdata, $answers);


        $this->assertEquals(0, $question->total());

    }

    public function testMultipleSelectionUndeterminedReturnsZeroActual()
    {
        [$qdata, $answers] = $this->createQuestionData(true, true, 10);
        $answers->add($undetermined = $this->createAnswer(true));

        $qdata['response'] = [$undetermined->uuid()];
        $question = new Question($qdata, $answers);


        $this->assertEquals(0, $question->actual());

    }

    public function testAnswerNotFromSetThrowsException()
    {
        [$qdata, $answers] = $this->createQuestionData(false, true, 10);
        $answer = $this->createAnswer();

        $qdata['response'] = [$answer->uuid()];

        $this->expectException(\RuntimeException::class);

        new Question($qdata, $answers);

    }


}
