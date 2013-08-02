<?php namespace Onigoetz\Profiler\Tools;

class Config {

    protected static $instance;

    protected $values;

    public function __construct($path = null)
    {
        $default_path = __DIR__ . "/../../../config/profiler.php";

        if($path == null) {
            $path = $default_path;
        }

        //I know ! this should not be done
        //TODO :: add some kind of security
        $this->values = include $path;

        //still include the default file in order to avoid problems with missing default values
        if ($path != $default_path) {
            $this->values += include $default_path;
        }

        Config::$instance = $this;
    }

    public static function init($path = null)
    {
        if (static::$instance == null) {
            new static($path);
        }
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
