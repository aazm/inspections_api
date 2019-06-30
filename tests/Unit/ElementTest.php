<?php

namespace Tests\Unit;

use App\Models\Element;
use App\Models\Page;
use App\Models\Question;
use App\Models\Section;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElementTest extends TestCase
{
    public function testCreateQuestionRetunrsQuestionObject()
    {
        [$data, $answers] = $this->createQuestionData();

        $collection = collect();
        $collection->put($data['params']['response_set'], $answers);

        $question = Element::create($data['type'], $data, $collection);

        $this->assertInstanceOf(Question::class, $question);
    }

    public function testCreateThrowsExceptionIfClassIsUnknown()
    {
        $this->expectException(\RuntimeException::class);
        Element::create($this->faker->sentence(1), [], collect());
    }

    public function testCreatePageReturnsPageObject()
    {
        $data = $this->createSimplePage()->toArray();
        $page = Element::create($data['type'], $data, collect());

        $this->assertInstanceOf(Page::class, $page);
    }

    public function testCreateSectionReturnsSectionObject()
    {
        $data = $this->createSimpleSection()->toArray();
        $page = Element::create($data['type'], $data, collect());

        $this->assertInstanceOf(Section::class, $page);

    }

}
