<?php

namespace UPFlex\MixUp\Core;

abstract class Base
{
    protected $instance;

    /**
     * @return bool
     */
    public static function isSelfInstance(): bool
    {
        return true;
    }

    public function setInstance($instance): void
    {
        $this->instance = $instance;
    }

    public function getInstance()
    {
        return $this->instance;
    }
}
