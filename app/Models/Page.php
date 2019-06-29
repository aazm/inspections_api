<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:14
 */


namespace App\Models;

use App\Contracts\Containable;
use App\Contracts\Scoreable;
use Illuminate\Support\Collection;

class Page implements Scoreable, Containable
{
    private $params;
    private $items;


    public function __construct(array $params)
    {
        $this->params = $params;
        $this->items = collect();
    }

    public function all(): Collection
    {
        return $this->items;
    }

    public function add(Scoreable $obj): void
    {
        $this->items->add($obj);
    }
    public function actual(): float
    {
        // TODO: Implement actual() method.
    }
    public function total(): float
    {
        // TODO: Implement total() method.
    }

}
