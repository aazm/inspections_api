<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 30/06/2019
 * Time: 11:32
 */

namespace App\Models;

use App\Contracts\Scoreable;
use Illuminate\Support\Collection;

abstract class Element implements Scoreable
{
    private const PAGE = 'page';
    private const SECTION = 'section';
    private const QUESTION = 'question';

    /** @var array $params */
    protected $params;


    /**
     * Basic factory method for Scoreable Objects.
     *
     * @param string $type
     * @param array $params
     * @param Collection|null $responses
     * @return Scoreable
     */
    public static function create(string $type, array $params, Collection $responses): Scoreable
    {
        switch ($type) {
            case self::PAGE:
                return new Page($params);
            case self::SECTION:
                return new Section($params);
            case self::QUESTION:

                return new Question($params, $responses->get($params['params']['response_set']));
            default:
                throw new \RuntimeException("unable to instantiate unknown class: {$type}");
        }
    }

    /**
     * Object given properties.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->params;
    }
}