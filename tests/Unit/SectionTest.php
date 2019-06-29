<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionTest extends TestCase
{
    public function testAddedSectionCanBeFoundInAllCollection()
    {
        $section = $this->createSimpleSection();
        $section->add($inner = $this->createSimpleSection());

        $collection = $section->all();
        $this->assertTrue(in_array($inner, $collection->toArray()));

    }

    public function testAddedQuestionCanBeFoundInAllCollection()
    {
        $section = $this->createSimpleSection();
        $section->add($question = $this->createQuestion());

        $collection = $section->all();
        $this->assertTrue(in_array($question, $collection->toArray()));
    }

    public function testSectionTotalMultipliedOnItsWeight()
    {
        $section = $this->createSimpleSection(10 );
        $section->add($question = $this->createQuestion());

        $this->assertEquals($question->total() * 10, $section->total());
    }

    public function testSectionActualMultipliedOnItsWeight()
    {
        $section = $this->createSimpleSection(10 );
        $section->add($question = $this->createQuestion());

        $this->assertEquals($question->actual() * 10, $section->actual());

    }

    public function testSectionTotalEqualsSumOfAllItsElems()
    {
        $section = $this->createSimpleSection(1);
        $section->add($question1 = $this->createQuestion());
        $section->add($question2 = $this->createQuestion());

        $this->assertEquals($question1->total() + $question2->total(), $section->total());

    }

    public function testSectionActualEqualsSumOfAllItsElems()
    {
        $section = $this->createSimpleSection(1);
        $section->add($question1 = $this->createQuestion());
        $section->add($question2 = $this->createQuestion());

        $this->assertEquals($question1->actual() + $question2->actual(), $section->actual());

    }


}
