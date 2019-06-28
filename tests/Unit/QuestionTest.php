<?php

namespace Tests\Unit;

use App\Models\Question;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function testQuestionToArrayReturnsIndexes()
    {
        $question = $this->createQuestion();

        $this->assertArrayHasKey('params', $question->toArray());
        $this->assertArrayHasKey('answers', $question->toArray());
    }

    public function testQuestionToArrayReturnsSameData()
    {
        ['params' => $params, 'answers' => $answers] = $this->createQuestion()->toArray();

        $question = new Question($params, $answers);

        $this->assertEquals(compact('params', 'answers'), $question->toArray());
    }

    public function testQuestionTotalEqualsAnswersSum()
    {
        $question = $this->createQuestion(false, true, 3);
        
    }


}
