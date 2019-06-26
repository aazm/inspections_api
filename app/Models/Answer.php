<?php

namespace App\Models;

class Answer
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function toArray(): array
    {
        return $this->params;
    }
}
