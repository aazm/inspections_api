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

    public function __construct(array $params, Collection $answers)
    {
        $this->params = $params;
        $this->answers = $answers;
    }

    public function toArray(): array
    {
        return [$this->params, $this->answers];
    }

    public function actual()
    {

    }

    public function total()
    {
        $total = 0;

        $this->answers->each(function ($answer) use (&$total) {
            $total += $answer->score();
        });

        return $total;
    }

}