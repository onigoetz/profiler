<?php namespace Onigoetz\Profiler;


class Panels {

    public static $panels = array();

    public static function register($data) {
        self::$panels[$data['name']] = $data;
    }
}
