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
    /** @var int $actual */
    private $actual;

    public function __construct(array $params, Collection $answers)
    {
        $this->params = $params;
        $this->answers = $answers;
    }

    public function toArray(): array
    {
        return [$this->params, $this->answers];
    }

    public function multipleSelectionAllowed(): bool
    {
        return (bool) $this->params['params']['multiple_selection'];
    }

    public function actual()
    {

    }

    public function total()
    {
        return $this->multipleSelectionAllowed() ? $this->answersSum() : $this->answersMax();
    }

    private function answersMax()
    {
        return $this->answers->map(function ($answer) { return $answer->score(); })->max();
    }

    private function answersSum()
    {
        $total = 0;

        $this->answers->each(function ($answer) use (&$total) {
            $total += $answer->score();
        });

        return $total;

    }

}
