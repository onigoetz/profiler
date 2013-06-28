<?php namespace Onigoetz\Profiler\Panel;

use DB;
use Onigoetz\Profiler\Panel;
use Onigoetz\Profiler\PanelTitle;
use Onigoetz\Profiler\Utils;
use View;
use Config;

class Database extends Panel
{

    protected $icon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAEYSURBVBgZBcHPio5hGAfg6/2+R980k6wmJgsJ5U/ZOAqbSc2GnXOwUg7BESgLUeIQ1GSjLFnMwsKGGg1qxJRmPM97/1zXFAAAAEADdlfZzr26miup2svnelq7d2aYgt3rebl585wN6+K3I1/9fJe7O/uIePP2SypJkiRJ0vMhr55FLCA3zgIAOK9uQ4MS361ZOSX+OrTvkgINSjS/HIvhjxNNFGgQsbSmabohKDNoUGLohsls6BaiQIMSs2FYmnXdUsygQYmumy3Nhi6igwalDEOJEjPKP7CA2aFNK8Bkyy3fdNCg7r9/fW3jgpVJbDmy5+PB2IYp4MXFelQ7izPrhkPHB+P5/PjhD5gCgCenx+VR/dODEwD+A3T7nqbxwf1HAAAAAElFTkSuQmCC";

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {

        $queries = $duplicates = array();
        $queryTotals = array(
            'count' => 0,
            'time' => 0
        );

        $threshold = Config::get('profiler::profiler.slow_query');

        foreach (DB::getQueryLog() as $query) {
            $queryTotals['count'] += 1;

            //base informations
            $query['sql'] = str_replace("\n", '', $query['query']);
            $queryTotals['time'] += $query['time'];

            //duplicate queries
            $query['sql_simplified'] = $this->simplifiedQuery($query['sql']);
            if (array_key_exists($query['sql_simplified'], $duplicates)) {
                $duplicates[$query['sql_simplified']]['time'] += $query['time'];
                $duplicates[$query['sql_simplified']]['qty']++;
            } else {
                $duplicates[$query['sql_simplified']] = array('time' => $query['time'], 'qty' => 1);
            }

            if ($query['time'] >= $threshold) {
                $query['slow'] = 'slow';
            }

            //TODO :: slow query threshold
            //TODO :: implement "explain"

            $queries[] = $query;
        }

        foreach ($duplicates as $query => $duplicate) {
            if ($duplicate['qty'] == 1) {
                unset($duplicates[$query]);
            }
        }

        $this->data = array(
            'queries' => $queries,
            'duplicates' => $duplicates,
            'popup' => array(
                'Total Queries' => $queryTotals['count'],
                'Total Time' => Utils::getReadableTime($queryTotals['time'])
            )
        );
    }

    private function simplifiedQuery($sql)
    {
        return preg_replace("/(\([\?, ]*\?\))/", "(?...)", $sql);
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
        return View::make('profiler::panels/database', $this->data);
    }

    function renderTitle()
    {
        return new PanelTitle($this->data['popup']['Total Queries'], $this->icon, $this->data['popup']);
    }
}
