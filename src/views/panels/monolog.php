<h2>Logs</h2>

<?php if (empty($logs)): ?>
    <h3>This panel has no log items.</h3>
<?php else: ?>
    <table class="op-table">
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php $logger->getLevelName($log['level']) ?></td>
                <td> <?php nl2br(print_r($log['message'], true)) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
