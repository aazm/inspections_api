<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:14
 */


namespace App\Models;

use App\Contracts\Scoreable;
use App\Contracts\Containable;
use Illuminate\Support\Collection;

class Page extends Element implements Containable
{
    /** @var Collection $items */
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
        $actual = 0;
        foreach ($this->items as $scoreable) {
            $actual += $scoreable->actual();
        }

        return $actual;
    }

    public function total(): float
    {
        $total = 0;
        foreach ($this->items as $scoreable) {
            $total += $scoreable->total();
        }

        return $total;
    }

}
