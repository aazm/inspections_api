<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 28/06/2019
 * Time: 20:13
 */

namespace App\Services;

use App\Contracts\Containable;
use App\Contracts\Scoreable;
use App\Models\Answer;
use App\Models\Element;
use App\Models\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
        if ($this->filled) throw new \RuntimeException('Object was already filled');

        $data = \json_decode($json, true);
        if (0 !== \json_last_error()) return false;


        $this->process($data, $this->prepareResponseSet($data['params']['response_sets']));

        $this->filled = true;
        return true;
    }

    public function inspect(): array
    {
        $total = 0;
        $actual = 0;

        foreach ($this->items as $item) {

            $total += $item->total();
            $actual += $item->actual();


            print_r($item);
        }

        if(!$total) {
            return [0,0,0];
        }

        return [$actual, $total, round($actual / $total * 100, 0)];
    }

    private function prepareResponseSet(array $arr): Collection
    {
        $collection = collect();

        foreach ($arr as $set) {

            ['uuid' => $uuid, 'responses' => $responses] = $set;
            $collection->put($uuid, collect());

            foreach ($responses as $response) {
                $collection->get($uuid)->add(new Answer($response));
            }
        }

        return $collection;
    }

    private function process(array $data, Collection $responses)
    {
        $pages = $data['items'] ?? [];

        foreach ($pages as $page) {

            $element = Element::create($page['type'], Arr::except($page, 'items'), $responses);
            $this->items->push($element);

            $this->processPage($element, $page['items'], $responses);
        }
    }

    private function processPage(Page $page, array $items, Collection $responses)
    {
        $stack = new \SplStack();

        $stack->push([$page, $items]);

        while (!$stack->isEmpty()) {

            [$root, $items] = $stack->pop();

            for($i = 0; $i < count($items); $i++) {

                $item = $items[$i];
                $element = Element::create($item['type'], Arr::except($item, 'items'), $responses);

                $root->add($element);

                if($element instanceof Containable) {
                    $stack->push([$element, $item['items']]);
                }
            }
        }
    }

}