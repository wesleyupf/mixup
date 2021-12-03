<?php

namespace UPFlex\MixUp\Components;

use UPFlex\MixUp\Core\Base;

abstract class BtnTemplate extends Base
{
    protected static array $attrs = [];
    protected static string $classes = '';
    protected static string $href = '#';

    /**
     * @param array $args
     */
    abstract protected static function params(array $args = []): void;

    /**
     * @param string $filename
     */
    public static function render(string $filename): void
    {
        get_template_part('template-parts/components/btn', $filename, [
            'attrs' => self::$attrs,
            'classes' => self::$classes,
            'url' => self::$href,
        ]);
    }
}
