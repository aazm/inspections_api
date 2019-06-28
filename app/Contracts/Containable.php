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
    public function add(Scoreable $obj);

    public function all(): Collection;
}
