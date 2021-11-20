<?php

namespace UPFlex\MixUp\Core;

abstract class SelfInstance
{
    /**
     * @param string $namespace
     * @param string $parent_class
     * @param array $classes_array [variableNameInFunction => $class]
     * @return bool
     * @throws \ReflectionException
     */
    public static function run(string $namespace, string $parent_class, array $classes_array = []): bool
    {
        $namespaces = Finder::getClassesInNamespace($namespace);

        $classes = self::filter($namespaces);

        if (!$classes) {
            return false;
        }

        foreach ($classes as $class) {
            $class_child_params = [];

            if (is_subclass_of($class, $parent_class)) {
                if (call_user_func([$class, 'isSelfInstance'])) {

                    // Get info class
                    $reflection = new \ReflectionClass($class);
                    $constructor = $reflection->getConstructor();
                    $const_params = $constructor->getParameters();

                    // Define parameters
                    foreach ($const_params as $param) {
                        $class_child_params[] = $classes_array[$param->name] ?? null;
                    }

                    // Filter
                    $class_child_params = array_filter($class_child_params);

                    // Check parameters
                    if (count($const_params) <= count($class_child_params)) {
                        new $class(...$class_child_params);
                    } elseif (defined('WP_DEBUG') && true === WP_DEBUG) { // Write log
                        error_log(sprintf('%s %s', __('Parameters were not set correctly. Class:'), $class));
                    }
                }
            }
        }

        return true;
    }

    /**
     * @param array $namespaces
     * @return array
     */
    private static function filter(array $namespaces): array
    {
        $classes = [];

        foreach ($namespaces as $namespace) {
            $classes[] = Finder::getClassesInNamespace($namespace);
        }

        $classes = call_user_func('array_merge', $classes);
        return array_filter($classes, fn($class) => class_exists($class));
    }
}