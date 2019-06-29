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

class Section implements Scoreable, Containable
{
    /** @var Collection  */
    private $items;
    /** @var array $params */
    private $params;
    /** @var double $weight */
    private $weight;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->items = collect();
        $this->weight = $params['weight'] ?? 1;
    }

    public function add(Scoreable $obj)
    {
        // TODO: Implement add() method.
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public function total(): double
    {
        // TODO: Implement total() method.
    }

    public function actual(): double
    {
        // TODO: Implement actual() method.
    }
}