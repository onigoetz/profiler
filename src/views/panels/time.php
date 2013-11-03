<form id="timeline-control" class="op-control" action="" method="get">
    <input type="hidden" name="panel" value="time">
    Threshold <input type="number" size="3" name="threshold" value="1" min="0"> ms
</form>
<h2>Time</h2>

<?php
$token = 'laravel';
$profile = null;
$colors = array(
    'default' =>                '#aacd4e',
    'section' =>                '#666',
    'event_listener' =>         '#3dd',
    //'event_listener_loading' => '#add',
    'template' =>               '#dd3',
    //'doctrine' =>               '#d3d',
    //'propel' =>                 '#f4d',
    //'child_sections' =>         '#eed',
);

echo display_timeline('timeline_' . $token, $colors);


// no child requests in laravel
/*
foreach ($profile->children as $child) {
    $events = $child->getcollector('time')->getEvents();
    echo '<h3>' .
        'Sub-request " . $child->getcollector("request")->requestattributes->get("_controller")' .
        '<small> - ' . $events['__section__']->getDuration() . ' ms</small>' .
        '</h3>';
}
*/
?>

<script>

    window.onigoetz_profiler = {};
    window.onigoetz_profiler.colors = <?php echo json_encode($colors); ?>;
    window.onigoetz_profiler.requests_data = <?php

        $end_events = array(
            "max" => sprintf("%F", $events['__section__']->getEndtime()),
            "requests" => array(dump_request_data($token, $profile, $events, $events['__section__']->getOrigin()))
        );

        // no child requests in laravel
        /*
        foreach ($profile->children as $child) {
            $events["requests"][] = dump_request_data($child->token, $child, $child->getcollector('time')->getEvents(), $events['__section__']->getOrigin());
        }
        */

        echo json_encode($end_events); ?>
</script>

<?php
/* Used to debug the time output
echo '<table>
    <tr>
        <th>name</th>
        <th>category</th>
        <th>origin</th>
        <th>starttime</th>
        <th>endtime</th>
    </tr>';

foreach ($events as $name => $event) {
    echo '<tr>';
    echo '<td>' . str_replace("\\", "\\\\", $name) . '</td>';
    echo '<td>' . $event->getCategory() . '</td>';
    echo '<td>' . sprintf("%F", $event->getOrigin()) . '</td>';
    echo '<td>' . sprintf("%F", $event->getStarttime()) . '</td>';
    echo '<td>' . sprintf("%F", $event->getEndtime()) . '</td>';
    echo '</tr>';
}
echo '</table>';/**/


function dump_request_data($token, $profile, $events, $origin)
{
    return array(
        "id" => $token,
        "left" => sprintf("%F", $events['__section__']->getOrigin() - $origin),
        "events" => dump_events($events)
    );
}

function dump_events($events)
{

    $treated = array();
    foreach ($events as $name => $event) {
        if ('__section__' != $name) {
            $entry = array(
                "name" => str_replace("\\", "\\\\", $name),
                "category" => $event->getCategory(),
                "origin" => sprintf("%F", $event->getOrigin()),
                "starttime" => sprintf("%F", $event->getStarttime()),
                "endtime" => sprintf("%F", $event->getEndtime()),
                "duration" => sprintf("%F", $event->getDuration()),
                "memory" => sprintf("%.1F", $event->getMemory() / 1024 / 1024),
                "periods" => null
            );

            foreach ($event->getPeriods() as $period) {
                $entry["periods"][] = array(
                    "start" => sprintf("%F", $period->getStarttime()),
                    "end" => sprintf("%F", $period->getEndtime())
                );
            }

            $treated[] = $entry;
        }
    }

    return $treated;
}

function display_timeline($id, $colors)
{
    ?>
    <div class="sf-profiler-timeline">
        <div class="legends">
            <?php foreach ($colors as $category => $color): ?>
            <span data-color="<?=$color ?>"><?= $category ?></span>
            <?php endforeach ?>
        </div>
        <canvas width="680" height="" id="<?= $id ?>" class="timeline"></canvas>
    </div>
    <?php
}
