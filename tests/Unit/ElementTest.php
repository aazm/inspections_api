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
        $question = Element::create($data['type'], [$data, $answers]);

        $this->assertInstanceOf(Question::class, $question);
    }

    public function testCreateThrowsExceptionIfClassIsUnknown()
    {
        $this->expectException(\RuntimeException::class);
        Element::create($this->faker->sentence(1), []);
    }

    public function testCreatePageReturnsPageObject()
    {
        $data = $this->createSimplePage()->toArray();
        $page = Element::create($data['type'], $data);

        $this->assertInstanceOf(Page::class, $page);
    }

    public function testCreateSectionReturnsSectionObject()
    {
        $data = $this->createSimpleSection()->toArray();
        $page = Element::create($data['type'], $data);

        $this->assertInstanceOf(Section::class, $page);

    }

}
