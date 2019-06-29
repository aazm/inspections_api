<?php

namespace Tests;

use App\Models\Answer;
use App\Models\Page;
use App\Models\Question;
use App\Models\Section;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    protected function createAnswer(bool $undetermined = false): Answer
    {
        return new Answer([
            'title' => $this->faker->sentence(),
            'color' => $this->faker->hexColor,
            'score' => $undetermined ? null : rand(0, 10),
            'negative' => (bool)rand(0, 1),
            'uuid' => $this->faker->uuid

        ]);
    }

    protected function createAnswersCollection(int $total, bool $undetermined = false): Collection
    {
        $collection = collect();
        for ($i = 0; $i < $total; $i++) {
            $collection->add($this->createAnswer($undetermined));
        }

        return $collection;
    }

    protected function createQuestion(bool $multiple = false, bool $required = true, $answersTotal = 10): Question
    {
        [$question, $answers] = $this->createQuestionData(...func_get_args());
        return new Question($question, $answers);
    }

    protected function createQuestionData(bool $multiple = false, bool $required = true, $answersTotal = 10): array
    {

        $answers = $this->createAnswersCollection($answersTotal);

        $responses = $answers
            ->random(1 + $multiple)
            ->map(function ($answer) {
                return $answer->uuid();
            })
            ->toArray();

        $qdata = [
            'type' => 'question',
            'title' => $this->faker->sentence(),
            'required' => $required,
            'response_type' => 'list',
            'params' => [
                'response_set' => $this->faker->uuid,
                'multiple_selection' => $multiple
            ],
            'check_conditions_for' => [],
            'categories' => [],
            'uuid' => $this->faker->uuid,
            'response' => $responses,
            'responded' => true,

        ];

        return [$qdata, $answers];
    }

    protected function createSimpleSection(int $weight = null): Section
    {
        return new Section([
            'type' => 'section',
            'title' => $this->faker->sentence(),
            'required' => (bool)rand(0, 1),
            'weight' => $weight ?? rand(1, 10),
            'repeat' => (bool)rand(0, 1),
            'uuid' => $this->faker->uuid

        ]);
    }

    protected function createSimplePage(): Page
    {
        return new Page([
            'uuid' => $this->faker->uuid,
            'type' => 'page',
            'title' => $this->faker->sentence(),
        ]);
    }

}
