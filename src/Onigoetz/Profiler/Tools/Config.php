<?php namespace Onigoetz\Profiler\Tools;

class Config {

    protected static $instance;

    protected $values;

    public function __construct($path = null)
    {
        if($path == null) {
            $path = __DIR__ . "/../../../config/profiler.php";
        }

        $this->values = include $path;


        Config::$instance = $this;
    }

    public static function get($key)
    {
        if (static::$instance == null) {
            new static;
        }

        $values = static::$instance->values;

        if (array_key_exists($key, $values)) {
            return $values[$key];
        }
    }
}
