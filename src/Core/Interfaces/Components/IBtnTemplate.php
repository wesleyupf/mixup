<?php

namespace UPFlex\MixUp\Core\Interfaces\Components;

interface IBtnTemplate
{
    /**
     * @param array $args
     */
    public static function params(array $args = []): void;

    /**
     * @param string $filename
     */
    public static function render(string $filename): void;
}
