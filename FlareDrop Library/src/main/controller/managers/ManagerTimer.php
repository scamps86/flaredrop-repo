<?php

/**
 * Timer utilities
 */
class ManagerTimer
{

    private $_initialTime = [];


    /**
     * Initialize or override the timer
     *
     * @param string $id The timer id
     *
     */
    public function start($id)
    {
        $this->_initialTime[$id] = round(microtime(true), 3) * 1000;
    }


    /**
     * Get the current time in milliseconds. If the timer not exists, it will return a -1 value
     * @return int
     */
    public function get($id)
    {
        return !isset($this->_initialTime[$id]) ? -1 : round(microtime(true), 3) * 1000 - $this->_initialTime[$id];
    }


    /**
     * Sleep until the time is the same or more than the specified
     *
     * @param string $id The timer id
     * @param int $time The time to sleep in milliseconds
     */
    public function sleepUntil($id, $time)
    {
        $sleepingTime = $time + $this->_initialTime[$id] - (round(microtime(true), 3) * 1000);
        if ($sleepingTime > 0) {
            usleep($sleepingTime * 1000);
        }
    }
}