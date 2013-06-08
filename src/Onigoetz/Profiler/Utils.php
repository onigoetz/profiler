<?php namespace Onigoetz\Profiler;

class Utils {
    /**
     * Get file size with correct extension
     *
     * @param  int    $size
     * @param  string $retstring
     * @return string
     */
    public static function getReadableSize($size, $retstring = null)
    {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if ($retstring === null) {
            $retstring = '%01.2f %s';
        }

        $lastsizestring = end($sizes);

        foreach ($sizes as $sizestring) {
            if ($size < 1024) {
                break;
            }
            if ($sizestring != $lastsizestring) {
                $size /= 1024;
            }
        }
        if ($sizestring == $sizes[0]) {
            $retstring = '%01d %s';
        } // Bytes aren't normally fractional

        return sprintf($retstring, $size, $sizestring);
    }

    /**
     * Format time
     *
     * @param  integer $time
     * @return string
     */
    public static function getReadableTime($time)
    {
        $ret = $time;
        $formatter = 0;
        $formats = array('ms', 's', 'm');
        if ($time >= 1000 && $time < 60000) {
            $formatter = 1;
            $ret = ($time / 1000);
        }
        if ($time >= 60000) {
            $formatter = 2;
            $ret = ($time / 1000) / 60;
        }
        $ret = number_format((float) $ret, 3, '.', '') . ' ' . $formats[$formatter];

        return $ret;
    }

    /**
     * Get a short version of a path, with placeholders for some common paths
     *
     * @param string $file A path to a file
     * @return string A cleaner version of the path
     */
    public static function path($file)
    {
        static $path;

        if($path == null) {
            $path = array(
                'STORAGE' => realpath(app('path.storage')).'/',
                'APP' => realpath(app('path')).'/',
                'PUBLIC' => realpath(app('path.public')).'/',
                'VENDOR' => realpath(app('path.base')).'/vendor/',
                'WORKBENCH' => realpath(app('path.base')).'/workbench/',
                'ROOT' => realpath(app('path.base')).'/'
            );
        }

        //TODO :: get composer path automatically
        //TODO :: get workbench path automatically

        if (strpos($file, $path['STORAGE']) !== false) {
            $file = str_replace($path['STORAGE'], 'STORAGE' . DIRECTORY_SEPARATOR, $file);
        } elseif (strpos($file, $path['APP']) !== false) {
            $file = str_replace($path['APP'], 'APP' . DIRECTORY_SEPARATOR, $file);
        } elseif (strpos($file, $path['PUBLIC']) !== false) {
            $file = str_replace($path['PUBLIC'], 'PUBLIC' . DIRECTORY_SEPARATOR, $file);
        } elseif (strpos($file, $path['VENDOR']) !== false) {
            $file = str_replace($path['VENDOR'], 'VENDOR' . DIRECTORY_SEPARATOR, $file);
        } elseif (strpos($file, $path['WORKBENCH']) !== false) {
            $file = str_replace($path['WORKBENCH'], 'WORKBENCH' . DIRECTORY_SEPARATOR, $file);
        } elseif (strpos($file, $path['ROOT']) !== false) {
            $file = str_replace($path['ROOT'], 'ROOT' . DIRECTORY_SEPARATOR, $file);
        }

        return $file;
    }
}
