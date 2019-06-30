<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:13
 */

namespace App\Services;

use App\Contracts\Scoreable;
use Illuminate\Support\Collection;

class InspectionService
{
    private $items;

    public function __construct()
    {
        $this->items = collect();
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function fill(string $json): bool
    {
        return true;
    }

    public function process(): array
    {

    }

}