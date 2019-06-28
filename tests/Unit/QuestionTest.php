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

    public function testQuestionTotalEqualsAnswersSum()
    {
        $question = $this->createQuestion();
        [, $answers] = $question->toArray();

        $total = 0;
        $answers->each(function($answer) use(&$total) {
            $total += $answer->score();
        });

        $this->assertEquals($total, $question->total());

    }


}
