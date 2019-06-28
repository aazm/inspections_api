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
        $params = $this->params;
        $answers = $this->answers;

        return compact('params', 'answers');
    }

    public function actual()
    {
        // TODO: Implement actual() method.
    }

    public function total()
    {
        // TODO: Implement total() method.
    }

}
