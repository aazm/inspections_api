<?php

namespace Tests\Unit;

use App\Models\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    public function testQuestionToArrayReturnsIndexes()
    {
        $params = range('a','z');
        $question = new Question($params, $answers = collect(1,2));

        $this->assertArrayHasKey('params', $question->toArray());
        $this->assertArrayHasKey('answers', $question->toArray());
    }

    public function testQuestionToArrayReturnsSameData()
    {
        $params = range('a','z');
        $question = new Question($params, $answers = collect(1,2));

        $this->assertEquals(compact('params', 'answers'), $question->toArray());
    }



}
