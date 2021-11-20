<?php

namespace UPFlex\MixUp\Core;

abstract class SelfInstance
{
    protected static $classes_array;
    protected static $parent_class;

    /**
     * @param string $namespace
     * @param string $parent_class
     * @param array $classes_array [variableNameInFunction => $class]
     * @return bool
     * @throws \ReflectionException
     */
    public static function run(string $namespace, string $parent_class, array $classes_array = []): bool
    {
        // Variáveis
        $classes = [];
        $possibleClass = [];

        // Seta valores
        self::$classes_array = $classes_array;
        self::$parent_class = $parent_class;

        // Pega todos os namespaces
        $namespaces = Finder::getClassesInNamespace($namespace);

        if (!$namespaces) {
            return false;
        }

        // Pega todas as classes
        foreach ($namespaces as $namespace) {
            self::execute($namespace);
            self::getChildClassesNamespaces($namespace);
        }

        return true;
    }

    /**
     * @param $class
     * @return void
     * @throws \ReflectionException
     */
    private static function execute($class): void
    {
        $class_child_params = [];

        if (is_subclass_of($class, self::$parent_class)) {
            if (call_user_func([$class, 'isSelfInstance'])) {

                // Get info class
                $reflection = new \ReflectionClass($class);
                $constructor = $reflection->getConstructor();
                $const_params = $constructor->getParameters();

                // Define parameters
                foreach ($const_params as $param) {
                    $class_child_params[] = self::$classes_array[$param->name] ?? null;
                }

                // Filter
                $class_child_params = array_filter($class_child_params);

                // Check parameters
                if (count($const_params) <= count($class_child_params)) {
                    $instance = new $class(...$class_child_params);
                    $instance->getInstance();
                } elseif (defined('WP_DEBUG') && true === WP_DEBUG) { // Write log
                    error_log(sprintf('%s %s', __('Parameters were not set correctly. Class:'), $class));
                }
            }
        }

    }

    /**
     * @throws \ReflectionException
     */
    private static function getChildClassesNamespaces($namespace): void
    {
        $classes = Finder::getClassesInNamespace($namespace);
        if (!$classes) {
            return;
        }

        $classes = array_filter($classes, fn($class) => class_exists($class));

        if (!$classes) {
            return;
        }

        foreach ($classes as $class) {
            self::execute($class);
        }
    }
}
