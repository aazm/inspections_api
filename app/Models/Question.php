<?php

namespace App\Models;

use App\Contracts\Scoreable;
use Illuminate\Support\Collection;

class Question implements Scoreable
{
    /** @var array $params */
    private $params;
    /** @var Collection $answers */
    private $answers;
    /** @var Collection $selected */
    private $selected;

    public function __construct(array $params, Collection $answers)
    {
        $this->params = $params;
        $this->answers = $answers;
        $this->selected = $this->selected();

        $this->checkQuestionState();
    }

    private function checkQuestionState(): void
    {
        if(!$this->selected->count()) throw new \RuntimeException('Not found selected results in answers collection');
    }

    public function toArray(): array
    {
        return [$this->params, $this->answers];
    }

    public function isMultiple(): bool
    {
        return (bool)$this->params['params']['multiple_selection'];
    }

    public function actual(): double
    {
        return $this->selected->map(function ($answer) {
            return $answer->score();
        })->sum();
    }

    public function total(): double
    {
        if ($this->selected->filter(function ($answer) {
                return !$answer->undetermined();
            })->count() == 0) return 0;

        return $this->isMultiple() ? $this->answersSum() : $this->answersMax();
    }

    private function answersMax()
    {
        return $this->answers->map(function ($answer) {
            return $answer->score();
        })->max();
    }

    private function answersSum()
    {
        $total = 0;

        $this->answers->each(function ($answer) use (&$total) {
            $total += $answer->score();
        });

        return $total;
    }

    private function selected()
    {
        $ids = $this->params['response'];

        return $this->answers->filter(function ($answer) use ($ids) {
            return in_array($answer->uuid(), $ids);
        });
    }

}
