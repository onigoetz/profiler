<h2>Database</h2>

<?php if (count($queries)): ?>
    <table class="op-table">
        <?php foreach ($queries as $query): ?>
            <tr>
                <td class="query <?= (array_key_exists('slow', $query) ? $query['slow'] : '') ?>">
                    <span class="indicator"><?= \Onigoetz\Profiler\Utils::getReadableTime($query['time']) ?></span>
                    <pre><?= $query['sql'] ?></pre>

                    <?php if (array_key_exists('bindings', $query) && !empty($query['bindings'])): ?>
                        <ol class=sql-bindings>
                            <?php foreach ($query['bindings'] as $value): ?>
                                <li>
                                    <pre><?= $value ?></pre>
                                </li>
                            <?php endforeach ?>
                        </ol>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>

    <h3>Duplicates</h3>
    <?php if (count($duplicates)): ?>
        <table class="op-table">
            <?php foreach ($duplicates as $sql => $query): ?>
                <tr>
                    <td class="query <?php (array_key_exists('slow', $query)? $query['slow'] : '') ?>>
                    <span class=" indicator"><?= $query['qty'] ?>&times; (Total <?= \Onigoetz\Profiler\Utils::getReadableTime($query['time']) ?>)</span>
                    <pre><?= $sql ?></pre>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p class=empty>No duplicated queries, good job !</p>
    <?php endif ?>

<?php else: ?>
    <p class=empty>No queries on this page</p>
<?php endif ?>
