<?php namespace Onigoetz\Profiler\Panel;

use Onigoetz\Profiler\Panel;
use Onigoetz\Profiler\PanelTitle;
use Session;
use View;

class Variables extends Panel
{
    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        $this->data = array(
            'GET Data' => $_GET,
            'POST Data' => $_POST,
            'Files' => $_FILES,
            'Cookies' => $_COOKIE,
            'Session' => Session::all(),
            'Server/Request Data' => $_SERVER,
            'Environment Variables' => $_ENV
        );

        return $this->data;
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'variables';
    }

    /**
     * Render the panel
     */
    function render()
    {
        // $e -> cleanup output, optionally preserving URIs as anchors:
        $e = function ($_, $allowLinks = false) {
            $escaped = htmlspecialchars($_, ENT_QUOTES, 'UTF-8');

            // convert URIs to clickable anchor elements:
            if ($allowLinks) {
                $escaped = preg_replace(
                    '@([A-z]+?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@',
                    "<a href=\"$1\" target=\"_blank\">$1</a>",
                    $escaped
                );
            }

            return $escaped;
        };

        return View::make('profiler::panels/variables', array('variables' => $this->data, 'e' => $e));
    }

    function renderTitle()
    {
        return new PanelTitle('Variables');
    }
}
