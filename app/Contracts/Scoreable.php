<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:04
 */

namespace App\Contracts;

interface Scoreable
{
    public function total();

    public function actual();
}

