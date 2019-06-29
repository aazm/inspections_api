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
}
