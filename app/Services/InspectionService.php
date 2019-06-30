<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:13
 */

namespace App\Services;

use App\Contracts\Scoreable;
use App\Models\Answer;
use App\Models\Element;
use Illuminate\Support\Collection;

class InspectionService
{
    /** @var Collection $items */
    private $items;
    /** @var  boolean $filled */
    private $filled;

    public function __construct()
    {
        $this->items = collect();
        $this->filled = false;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function fill(string $json): bool
    {
        if($this->filled) throw new \RuntimeException('Object was already filled');

        $data = \json_decode($json, true);
        if(0 !== \json_last_error()) return false;


        $this->process(
            $data,
            $this->prepareResponseSet($data['params']['response_sets'])
        );


        $this->filled = true;
        return true;
    }

    private function prepareResponseSet(array $arr): Collection
    {
        $collection = collect();

        foreach ($arr as $set) {

            ['uuid' => $uuid, 'responses' => $responses] = $set;
            $collection->put($uuid, collect());

            foreach($responses as $response) {
                $collection->get($uuid)->add(new Answer($response));
            }
        }

        return $collection;
    }


    private function process(array $data, Collection $responses)
    {
        foreach ($data['items'] as $page) {

            $elem = Element::create($page['type'], $page, $responses);
            $this->items->add($elem);
        }

    }


    public function results(): array
    {

    }

}