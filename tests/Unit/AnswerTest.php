<?php

namespace Tests\Unit;

use App\Models\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerTest extends TestCase
{
    public function testAnwerToArrayGetsUnchangedArray()
    {
        $arr = range('a', 'z');
        $answer = new Answer($arr);

        $this->assertEquals($arr, $answer->toArray());
    }
}
