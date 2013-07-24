<?php namespace Onigoetz\Profiler\Storage;

interface StorageInterface {
    public function get($id = null, $last = null);

    public function put($request);
}
