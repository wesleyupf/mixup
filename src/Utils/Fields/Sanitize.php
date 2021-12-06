<?php

namespace UPFlex\MixUp\Utils\Fields;

use UPFlex\MixUp\Utils\Response;

trait Sanitize
{
    use Response;

    /**
     * @return array
     */
    protected static function getFields(): array
    {
        $class = get_called_class();
        return call_user_func([$class, 'setFields']);
    }

    /**
     * @return string[][]
     */
    abstract protected static function setFields(): array;

    /**
     * @param string $request
     * @return array
     */
    protected static function sanitizeFields(string $request = 'post'): array
    {
        $allow_methods = ['get' => $_GET, 'post' => $_POST];

        $fields = self::getFields();
        $data = [];

        foreach ($fields as $key => $expected) {
            $method = array_key_exists($request, $allow_methods)
                ? $allow_methods[$request]
                : $allow_methods['post'];

            $value = !is_string($key) ? $method[$expected] ?? null : $method[$key] ?? null;
            $key = !is_string($key) ? $expected : $key;

            $data[$key] = $value ? self::sanitizeTypeInput($value, $expected, $key) : null;
        }

        return array_filter($data);
    }

    /**
     * @param string $value
     * @param $args
     * @param string $key
     * @return string
     */
    protected static function sanitizeTypeInput(string $value, $args, string $key = ''): string
    {
        if (strlen(trim($value)) <= 0) {
            return '';
        }

        if (strpos($args, 'email') !== false || strpos($key, 'email') !== false) {
            $value = sanitize_email($value);
        } elseif (strpos($args, 'password') === false) {
            $value = sanitize_text_field($value);
        }

        return $value;
    }
}
