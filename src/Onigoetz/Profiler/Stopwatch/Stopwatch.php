<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Onigoetz\Profiler\Stopwatch;

/**
 * Stopwatch provides a way to profile code.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Stopwatch
{
    /**
     * @var StopwatchEvent[]
     */
    private $events = array();

    /**
     * @var null|float
     */
    private $origin;

    /**
     * Constructor.
     *
     * @param float|null $origin Set the origin of the events in this section, use null to set their origin to their start time
     */
    public function __construct($origin = null)
    {
        $this->origin = is_numeric($origin) ? $origin : null;
    }

    /**
     * Starts an event.
     *
     * @param string $name     The event name
     * @param string $category The event category
     *
     * @return StopwatchEvent A StopwatchEvent instance
     */
    public function start($name, $category = null)
    {
        if (!isset($this->events[$name])) {
            $this->events[$name] = new StopwatchEvent($this->origin ?: microtime(true) * 1000, $category);
        }

        return $this->events[$name]->start();
    }

    /**
     * Checks if the event was started
     *
     * @param string $name The event name
     *
     * @return bool
     */
    public function isStarted($name)
    {
        return isset($this->events[$name]) && $this->events[$name]->isStarted();
    }

    /**
     * Stops an event.
     *
     * @param string $name The event name
     *
     * @return StopwatchEvent A StopwatchEvent instance
     *
     * @throws \LogicException When the event has not been started
     */
    public function stop($name)
    {
        if (!isset($this->events[$name])) {
            throw new \LogicException(sprintf('Event "%s" is not started.', $name));
        }

        return $this->events[$name]->stop();
    }

    /**
     * Stops then restarts an event.
     *
     * @param string $name The event name
     *
     * @return StopwatchEvent A StopwatchEvent instance
     *
     * @throws \LogicException When the event has not been started
     */
    public function lap($name)
    {
        return $this->stop($name)->start();
    }

    public function getEvents()
    {
        return $this->events;
    }
}
