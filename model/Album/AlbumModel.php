<?php
/* Generated by neoan3-cli */

namespace Neoan3\Model\Album;

use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\Model\Model;
use Neoan3\Provider\MySql\Transform;

/**
 * Class AlbumModel
 * @package Neoan3\Model\Album
 * @method static get(string $id)
 * @method static create(array $modelArray)
 * @method static update(array $modelArray)
 * @method static find(array $conditionArray)
 * @method static delete(string $id, bool $hard = false)
 */

class AlbumModel implements Model{

    /**
     * @var Database|null
     */
    private static ?Database $db = null;

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if(!method_exists(self::class, $method)){
            $transform = new Transform('album', self::$db);
            return $transform->$method(...$args);
        } else {
            return self::$method(...$args);
        }
    }

    /**
     * @param array $providers
     */
    public static function init(array $providers)
    {
        foreach ($providers as $key => $provider){
            if($key === 'db'){
                self::$db = $provider;
            }
        }
    }

}