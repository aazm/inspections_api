<?php
/**
 * Created by PhpStorm.
 * User: aborovkov
 * Date: 30/06/2019
 * Time: 11:32
 */

namespace App\Models;

use App\Contracts\Scoreable;

abstract class Element implements Scoreable
{
    private const PAGE = 'page';
    private const SECTION = 'section';
    private const QUESTION = 'question';

    /** @var array $params */
    protected $params;


    /**
     * Basic factory method for Scoreable Objects.s
     *
     * @param string $type
     * @param array $params
     * @return Scoreable
     */
    public static function create(string $type, array $params): Scoreable
    {
        switch ($type) {
            case self::QUESTION:
                return new Question($params[0], $params[1]);
            case self::PAGE:
                return new Page($params);
            case self::SECTION:
                return new Section($params);
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