<?php

namespace UPFlex\MixUp\Core\Traits;

trait GroupingType
{
    protected array $args = [];
    protected bool $male = true;
    protected string $name;
    protected string $plural;
    protected string $singular;
    protected string $slug = '';

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlural(): string
    {
        return $this->plural;
    }

    public function getSingular(): string
    {
        return $this->singular;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isMale(): bool
    {
        return $this->male;
    }

    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    public function setMale(bool $male): void
    {
        $this->male = $male;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPlural(string $plural): void
    {
        $this->plural = $plural;
    }

    public function setSingular(string $singular): void
    {
        $this->singular = $singular;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    abstract public static function register(): void;
}
