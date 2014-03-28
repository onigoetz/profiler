<?php namespace Onigoetz\Profiler\Support\Laravel\DataCollector;

use DB;
use Onigoetz\Profiler\DataCollector\DataCollector;
use Onigoetz\Profiler\Tools\Config;
use Onigoetz\Profiler\Utils;

class DatabaseDataCollector extends DataCollector
{
    public function provides()
    {
        return array('database');
    }

    /**
     * @return mixed get the data to be serialized
     */
    public function getData()
    {
        $queries = $duplicates = array();
        $queryTotals = array(
            'count' => 0,
            'time' => 0
        );

        if (count(DB::getConnections())) {

            $threshold = Config::get('slow_query');

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
        }

        foreach ($duplicates as $query => $duplicate) {
            if ($duplicate['qty'] == 1) {
                unset($duplicates[$query]);
            }
        }

        return array(
            'database' => array(
                'queries' => $queries,
                'duplicates' => $duplicates,
                'popup' => array(
                    'Total Queries' => $queryTotals['count'],
                    'Total Time' => Utils::getReadableTime($queryTotals['time'])
                )
            )
        );
    }

    private function simplifiedQuery($sql)
    {
        return preg_replace("/(\([\?, ]*\?\))/", "(?...)", $sql);
    }
}
