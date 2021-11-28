<?php

namespace UPFlex\MixUp\Core;

abstract class Shortcode extends Base
{
    private static array $callback = [];
    private static string $tag;

    /**
     * @return array
     */
    public static function getCallback(): array
    {
        return self::$callback;
    }

    /**
     * @return string
     */
    public static function getTag(): string
    {
        return self::$tag;
    }

    public static function run(): void
    {
        add_shortcode(self::getTag(), self::getCallback());
    }

    /**
     * @param array $callback
     */
    public static function setCallback(array $callback): void
    {
        self::$callback = $callback;
    }

    /**
     * @param string $tag
     */
    public static function setTag(string $tag): void
    {
        self::$tag = $tag;
    }
}
