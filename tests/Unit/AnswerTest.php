<?php

namespace Tests\Unit;

use App\Models\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerTest extends TestCase
{
    public function testAnswerToArrayGetsUnchangedArray()
    {
        $arr = range('a', 'z');
        $answer = new Answer($arr);

        $this->assertEquals($arr, $answer->toArray());
    }

    public function testScoreTheSameAsGiven()
    {
        $given = factory(Answer::class)->make()->toArray();
        $answer = new Answer($given);

        $this->assertEquals($given['score'], $answer->score());
    }

    public function testNullScoreReturnUndeterminedAnswerTrue()
    {
        $given = factory(Answer::class)->make()->toArray();
        $given['score'] = null;
        $answer = new Answer($given);

        $this->assertTrue($answer->undetermined());

    }

    public function testNotNullScoreReturnUndeterminedAnswerFalse()
    {
        $given = factory(Answer::class)->make()->toArray();
        $answer = new Answer($given);
        $this->assertFalse($answer->undetermined());
    }

    public function testNullScoreReturnsAsZeroScore()
    {
        $given = factory(Answer::class)->make()->toArray();
        $given['score'] = null;
        $answer = new Answer($given);

        $this->assertEquals(0, $answer->score());

    }

}
