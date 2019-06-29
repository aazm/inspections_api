<?php

namespace Tests;

use App\Models\Answer;
use App\Models\Question;
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
            'negative' => (bool) rand(0,1),
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
        $answers = $this->createAnswersCollection($answersTotal);

        $responses = $answers
            ->random(1 + $multiple)
            ->map(function($answer){ return $answer->uuid(); })
            ->toArray();

        return new Question([
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

        ], $answers);
    }

}
