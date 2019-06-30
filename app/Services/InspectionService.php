<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:13
 */

namespace App\Services;

use App\Contracts\Scoreable;

class InspectionService
{
    private $items;

    public function __construct()
    {
        $this->items = collect();
    }

    public function fill(array $data)
    {

    }

    public function process(): array
    {

    }

}