<?php namespace Onigoetz\Profiler\Output;

use Onigoetz\Profiler\DataContainer;

interface OutputInterface {

    public function __construct(DataContainer $data);

    public function render();
}
