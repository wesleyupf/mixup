<?php

namespace UPFlex\MixUp\Core;

abstract class Base
{
    /**
     * @return bool
     */
    public static function isSelfInstance(): bool
    {
        return true;
    }

    public function getInstance(): string
    {
        return get_class($this);
    }
}
