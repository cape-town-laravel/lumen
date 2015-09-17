<?php

class ConfigurationTest extends TestCase
{
    public function testBasicExample()
    {
        app()->configure('options');
        $custom = config('options.custom');
        $this->assertTrue($custom);
    }
}
