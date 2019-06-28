<?php

namespace App\Models;

class Answer
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function uuid(): string
    {
        return $this->params['uuid'];
    }

    public function score(): int
    {
        return (int) $this->params['score'];
    }

    public function undetermined(): bool
    {
        return is_null($this->params['score']);
    }

    public function toArray(): array
    {
        return $this->params;
    }
}
