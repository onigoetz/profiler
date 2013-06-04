<?php

namespace Onigoetz\Profiler\Panels;

use DB;
use Onigoetz\Profiler\Utils;
use View;

class Database extends Panel
{

    protected $icon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAEYSURBVBgZBcHPio5hGAfg6/2+R980k6wmJgsJ5U/ZOAqbSc2GnXOwUg7BESgLUeIQ1GSjLFnMwsKGGg1qxJRmPM97/1zXFAAAAEADdlfZzr26miup2svnelq7d2aYgt3rebl585wN6+K3I1/9fJe7O/uIePP2SypJkiRJ0vMhr55FLCA3zgIAOK9uQ4MS361ZOSX+OrTvkgINSjS/HIvhjxNNFGgQsbSmabohKDNoUGLohsls6BaiQIMSs2FYmnXdUsygQYmumy3Nhi6igwalDEOJEjPKP7CA2aFNK8Bkyy3fdNCg7r9/fW3jgpVJbDmy5+PB2IYp4MXFelQ7izPrhkPHB+P5/PjhD5gCgCenx+VR/dODEwD+A3T7nqbxwf1HAAAAAElFTkSuQmCC";
    protected $handler;

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {

        $queries = array();
        $queryTotals = array(
            'count' => 0,
            'time' => 0
        );

        foreach (DB::getQueryLog() as $query) {
            $queryTotals['count'] += 1;

            $query['sql'] = str_replace("\n", '', $query['query']);
            $queryTotals['time'] += $query['time'];

            //TODO :: slow query threshold
            //TODO :: implement "explain"

            $queries[] = $query;
        }

        $this->data = array(
            'queries' => $queries,
            'popup' => array(
                'Total Queries' => $queryTotals['count'],
                'Total Time' => Utils::getReadableTime($queryTotals['time'])
            )
        );
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'database';
    }

    /**
     * Render the panel
     */
    function render()
    {
        $this->getData();
        return View::make('profiler::panels/database', $this->data);
    }

    function renderTitle()
    {
        return new PanelTitle($this->data['popup']['Total Queries'], $this->icon, $this->data['popup']);
    }
}
