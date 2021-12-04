<?php

namespace UPFlex\MixUp\Utils;

trait GroupingType
{
    protected static array $args = [];
    protected static bool $male = true;
    protected static string $name = '';
    protected static string $plural;
    protected static string $singular;
    protected static string $slug = '';

    public static function getName(): string
    {
        $class = get_called_class();
        return $class::$name;
    }

    public function setArgs(array $args): void
    {
        self::$args = $args;
    }

    public function setMale(bool $male): void
    {
        self::$male = $male;
    }

    public function setPlural(string $plural): void
    {
        self::$plural = $plural;
    }

    public function setSingular(string $singular): void
    {
        self::$singular = $singular;
    }

    public function setSlug(string $slug): void
    {
        self::$slug = $slug;
    }

    abstract public static function register(): void;
}
