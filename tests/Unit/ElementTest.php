<?php

namespace Tests\Unit;

use App\Models\Element;
use App\Models\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElementTest extends TestCase
{
    public function testCreateQuestionRetunrsQuestionObject()
    {
        [$data, $answers] = $this->createQuestionData();
        $question = Element::create($data['type'], [$data, $answers]);

        $this->assertInstanceOf(Question::class, $question);
    }
}
