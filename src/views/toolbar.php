<div id="profiler-container" class="op-container op-container--hide">
    <div class="op-panels">

        <?php foreach ($panels as $name => $panel): ?>
        <!-- <?= $name ?> -->
        <div id="op-panel-<?= $name ?>" class="op-panel op-panel-<?= $name ?>">
            <?= $panel['panel']($data) ?>
        </div>
        <?php endforeach ?>

    </div>
    <div class="op-tabs">
        <div class="op-tab close">
            <a href="#">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2OtPlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSvX+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65WhbmrnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7uKS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg==" />
            </a>
        </div>

        <?php foreach ($panel_titles($panels) as $panel => $title): ?>
        <div class="op-tab <?= $panel ?>" data-name="<?= $panel ?>">
            <div class="op-tab-content">
                <?php if (!empty($title->icon)): ?>
                    <img src="<?= $title->icon ?>" />
                <?php endif ?>
                <?= $title->title ?>
            </div>
            <?php if (count($title->popup) > 0): ?>
            <div class="op-tab-panel">
                <?php foreach ($title->popup as $key => $value): ?>
                <div><strong><?= $key ?></strong><var><?= $value ?></var></div>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>
        <?php endforeach ?>
    </div>
</div>

<?php if(Config::get('profiler::profiler.assets_auto', true)): ?>

    <?php if(Config::get('profiler::profiler.assets_minified', true)): ?>
        <script src="<?= asset('packages/onigoetz/profiler/js/script.min.js') ?>"> </script>
        <link rel="stylesheet" href="<?= asset('packages/onigoetz/profiler/css/style.min.css') ?>" />
    <?php else: ?>
        <script src="<?= asset('packages/onigoetz/profiler/js/script.js') ?>"> </script>
        <link rel="stylesheet" href="<?= asset('packages/onigoetz/profiler/css/style.css') ?>" />
    <?php endif ?>

<?php endif ?>
