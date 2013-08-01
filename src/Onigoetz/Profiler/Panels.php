<?php namespace Onigoetz\Profiler;


class Panels {

    public static $panels = array();

    public static function register($data) {
        self::$panels[$data['name']] = $data;
    }

    public static function getValidPanels($config_panels, array $collectors) {
        $panels = array();
        foreach ($config_panels as $panel_name) {

            $panel = self::$panels[$panel_name];

            $panel_ok = true;
            foreach ($panel['datasource'] as $source) {
                if (!in_array($source, $collectors)) {
                    $panel_ok = false;
                }
            }

            if ($panel_ok) {
                $panels[$panel_name] = $panel;
            }
        }
        return $panels;
    }
}
