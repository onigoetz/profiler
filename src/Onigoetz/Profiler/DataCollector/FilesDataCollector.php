<?php namespace Onigoetz\Profiler\DataCollector;

use Onigoetz\Profiler\Utils;

class FilesDataCollector extends DataCollector
{

    public function provides()
    {
        return array('files');
    }

    /**
     * @return mixed get the data to be serialized
     */
    public function getData()
    {
        $files = get_included_files();
        $fileList = array();
        $largestFile = 0;
        $totalSize = 0;

        foreach ($files as $file) {
            if (file_exists($file)) {
                $size = filesize($file);
            } else {
                $size = 0;
            }
            $fileList[] = array(
                'name' => Utils::path($file),
                'size' => $size
            );
            $totalSize += $size;
            if ($size > $largestFile) {
                $largestFile = $size;
            }
        }

        return array(
            'files' => array(
                'list' => $fileList,
                'popup' => array(
                    "Total Files" => count($files),
                    "Total Size" => Utils::getReadableSize($totalSize),
                    "Largest File" => Utils::getReadableSize($largestFile),
                )
            )
        );
    }
}
