<h2>Files</h2>

<?php if (empty($files)): ?>
    <h3>No loaded files.</h3>
<?php else: ?>
    <table class="op-table">
    <?php foreach ($files as $file): ?>
        <tr><td><span class="indicator"><?= \Onigoetz\Profiler\Utils::getReadableSize($file['size']) ?></span> <?= $file['name'] ?></td></tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
