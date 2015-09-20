<?php

class RouteTest extends TestCase
{
    public function testGetFast()
    {
        $this->visit('/fast')
            ->see('Faster');
    }

    public function testGetFastId()
    {
        $this->visit('/fast/1')
            ->see('Faster with id:1');
    }
}
