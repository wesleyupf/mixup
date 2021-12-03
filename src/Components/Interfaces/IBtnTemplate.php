<?php

namespace UPFlex\MixUp\Components\Interfaces;

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
