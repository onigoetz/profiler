<?php namespace Onigoetz\Profiler\Panel;

use Onigoetz\Profiler\Panel;
use Onigoetz\Profiler\PanelTitle;
use Onigoetz\Profiler\Utils;
use View;

class Files extends Panel
{
    protected $icon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGsSURBVDjLjZNLSwJRFICtFv2AgggS2vQLDFvVpn0Pi4iItm1KItvWJqW1pYsRemyyNILARbZpm0WtrJ0kbmbUlHmr4+t0z60Z7oSSAx935txzvrlPBwA4EPKMEVwE9z+ME/qtOkbgqtVqUqPRaDWbTegE6YdQKBRkJazAjcWapoGu6xayLIMoilAoFKhEEAQIh8OWxCzuQwEmVKtVMAyDtoiqqiBJEhSLRSqoVCqAP+E47keCAvfU5sDQ8MRs/OYNtr1x2PXdwuJShLLljcFlNAW5HA9khLYp0TUhSYMLHm7PLEDS7zyw3ybRqyfg+TyBtwl2sDP1nKWFiUSazFex3tk45sXjL1Aul20CGTs+syVY37igBbwg03eMsfH9gwSsrZ+Doig2QZsdNiZmMkVrKmwc18azHKELyQrOMEHTDJp8HXu1hostG8dY8PiRngdWMEq467ZwbDxwlIR8XrQLcBvn5k9Gpmd8fn/gHlZWT20C/D4k8eTDB3yVFKjX6xSbgD1If8G970Q3QbvbPehAyxL8SibJEdaxo5dikqvS28sInCjp4Tqb4NV3fgPirZ4pD4KS4wAAAABJRU5ErkJggg==";

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
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

        $this->data = array(
            'list' => $fileList,
            'popup' => array(
                "Total Files" => count($files),
                "Total Size" => Utils::getReadableSize($totalSize),
                "Largest File" => Utils::getReadableSize($largestFile),
            )
        );

        return $this->data;
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'files';
    }

    /**
     * Render the panel
     */
    function render()
    {
        return View::make('profiler::panels/files', array('files' => $this->data['list']));
    }

    function renderTitle()
    {
        return new PanelTitle($this->data['popup']["Total Files"], $this->icon, $this->data['popup']);
    }
}
