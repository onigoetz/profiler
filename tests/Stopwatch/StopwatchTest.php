<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Onigoetz\Profiler\Stopwatch\Stopwatch;

/**
 * StopwatchTest
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StopwatchTest extends \PHPUnit_Framework_TestCase
{
    const DELTA = 20;

    public function testStart()
    {
        $stopwatch = new Stopwatch();
        $event = $stopwatch->start('foo', 'cat');

        $this->assertInstanceof('Onigoetz\Profiler\Stopwatch\StopwatchEvent', $event);
        $this->assertEquals('cat', $event->getCategory());
    }

    public function testIsStarted()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('foo', 'cat');

        $this->assertTrue($stopwatch->isStarted('foo'));
    }

    public function testIsNotStarted()
    {
        $stopwatch = new Stopwatch();

        $this->assertFalse($stopwatch->isStarted('foo'));
    }

    public function testStop()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('foo', 'cat');
        usleep(200000);
        $event = $stopwatch->stop('foo');

        $this->assertInstanceof('Onigoetz\Profiler\Stopwatch\StopwatchEvent', $event);
        $this->assertEquals(200, $event->getDuration(), null, self::DELTA);
    }

    public function testLap()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('foo', 'cat');
        usleep(100000);
        $event = $stopwatch->lap('foo');
        usleep(100000);
        $stopwatch->stop('foo');

        $this->assertInstanceof('Onigoetz\Profiler\Stopwatch\StopwatchEvent', $event);
        $this->assertEquals(200, $event->getDuration(), null, self::DELTA);
    }

    /**
     * @expectedException \LogicException
     */
    public function testStopWithoutStart()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->stop('foo');
    }
}
