<?php namespace Onigoetz\Profiler\Storage;

use Onigoetz\Profiler\DataContainer;

interface StorageInterface {
    public function get($id = null, $last = null);

    public function put(DataContainer $request);
}
