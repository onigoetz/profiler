<?php namespace Onigoetz\Profiler\Tools;

class View
{

    public static function render($__path, $__data = array())
    {
        ob_start();

        extract($__data);

        // We'll evaluate the contents of the view inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try {
            include $__path;
        } catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        return ob_get_clean();
    }
}
