<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:05
 */

namespace App\Contracts;

use Illuminate\Support\Collection;

interface Containable
{
    /**
     * Add item inside.
     *
     * @param Scoreable $obj
     */
    public function add(Scoreable $obj): void;

    /**
     * Get Collection of all added objects.
     *
     * @return Collection
     */
    public function all(): Collection;
}
