<?php

namespace UPFlex\MixUp\Core;

abstract class Base
{
    /**
     * @param bool $authorized
     * @return bool
     */
    public static function isSelfInstance(bool $authorized = true): bool
    {
        return $authorized;
    }

    public function getInstance(): string
    {
        return get_class($this);
    }
}
