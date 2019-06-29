<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    public function testAddedSectionCanBeFoundInAllCollection()
    {
        $page = $this->createSimplePage();
        $page->add($inner = $this->createSimpleSection());

        $collection = $page->all();
        $this->assertTrue(in_array($inner, $collection->toArray()));

    }

    public function testAddedQuestionCanBeFoundInAllCollection()
    {
        $page = $this->createSimplePage();
        $page->add($question = $this->createQuestion());

        $collection = $page->all();
        $this->assertTrue(in_array($question, $collection->toArray()));
    }

    public function testpageTotalEqualsSumOfAllItsElems()
    {
        $page = $this->createSimplePage();
        $page->add($question1 = $this->createQuestion());
        $page->add($question2 = $this->createQuestion());

        $this->assertEquals($question1->total() + $question2->total(), $page->total());

    }

    public function testpageActualEqualsSumOfAllItsElems()
    {
        $page = $this->createSimplePage();
        $page->add($question1 = $this->createQuestion());
        $page->add($question2 = $this->createQuestion());

        $this->assertEquals($question1->actual() + $question2->actual(), $page->actual());

    }

}
