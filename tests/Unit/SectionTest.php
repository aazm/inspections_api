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

}
