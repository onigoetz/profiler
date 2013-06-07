<?php

namespace Onigoetz\Profiler\Panels;

use View;
use Session;

class Variables extends Panel
{
    protected $icon;

    /**
     * Register the panel to the application
     */
    function register()
    {

    }

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        $this->data = array(
            'Server/Request Data'   => $_SERVER,
            'GET Data'              => $_GET,
            'POST Data'             => $_POST,
            'Files'                 => $_FILES,
            'Cookies'               => $_COOKIE,
            'Session'               => Session::all(),
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
        $this->getData();

        // $e -> cleanup output, optionally preserving URIs as anchors:
        $e = function($_, $allowLinks = false) {
            $escaped = htmlspecialchars($_, ENT_QUOTES, 'UTF-8');

            // convert URIs to clickable anchor elements:
            if($allowLinks) {
                $escaped = preg_replace(
                    '@([A-z]+?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@',
                    "<a href=\"$1\" target=\"_blank\">$1</a>", $escaped
                );
            }

            return $escaped;
        };

        // $slug -> sluggify string (i.e: Hello world! -> hello-world)
        $slug = function($_) {
            $_ = str_replace(" ", "-", $_);
            $_ = preg_replace('/[^\w\d\-\_]/i', '', $_);
            return strtolower($_);
        };

        return View::make('profiler::panels/variables', array('variables' => $this->data, 'e' => $e, 'slug' => $slug));
    }

    function renderTitle()
    {
        return new PanelTitle('Variables');
    }
}
