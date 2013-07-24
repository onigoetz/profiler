<h2>Variables</h2>

<?php foreach ($variables as $label => $data): ?>
<div>
    <h3><?= $label ?></h3>
    <?php if(!empty($data)): ?>
        <table class=op-table>
            <?php foreach($data as $k => $value): ?>
                <tr>
                    <td><?= $e($k) ?></td>
                    <td><?= $e(print_r($value, true)) ?></td>
                </tr>
        <?php endforeach ?>
        </table>
    <?php else: ?>
        <p class="empty">empty</p>
    <?php endif ?>
</div>
<?php endforeach ?>

