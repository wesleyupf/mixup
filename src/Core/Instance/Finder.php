<?php

namespace UPFlex\MixUp\Core\Instance;

abstract class Finder
{
    // Directory that contains composer.json
    const APP_ROOT = __DIR__ . '/../../../../../';
    const SEPARATOR = '\\';

    /**
     * @param $namespace
     * @return array
     */
    public static function getClassesInNamespace($namespace): array
    {
        $namespace_dir = self::getNamespaceDirectory($namespace);

        if ($namespace_dir) {
            $files = scandir($namespace_dir);

            return array_map(function ($file) use ($namespace) {
                return $namespace . self::SEPARATOR . str_replace('.php', '', $file);
            }, $files);
        }

        return [];
    }

    /**
     * @return array
     */
    private static function getDefinedNamespaces(): array
    {
        $directory = self::APP_ROOT . 'composer.json';
        $config = json_decode(file_get_contents($directory), true);

        return $config['autoload']['psr-4'] ?? [];
    }

    /**
     * @param $namespace
     * @return string
     */
    private static function getNamespaceDirectory($namespace): string
    {
        $namespaces = self::getDefinedNamespaces();

        if ($namespaces) {
            $fragments = explode(self::SEPARATOR, $namespace);
            $undefinedFragments = [];

            while ($fragments) {
                $possibleNamespace = implode(self::SEPARATOR, $fragments) . self::SEPARATOR;

                if (array_key_exists($possibleNamespace, $namespaces)) {
                    $space = self::APP_ROOT . $namespaces[$possibleNamespace];
                    $fragment = implode('/', $undefinedFragments);

                    return realpath($space . $fragment);
                }

                array_unshift($undefinedFragments, array_pop($fragments));
            }
        }

        return false;
    }
}
