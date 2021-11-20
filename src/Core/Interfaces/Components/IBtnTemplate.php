<?php

namespace UPFlex\MixUp\Core\Interfaces\Components;

interface IBtnTemplate
{
    /**
     * @param array $args
     */
    static function params(array $args = []): void;

    /**
     * @param string $filename
     */
    static function render(string $filename): void;
}
