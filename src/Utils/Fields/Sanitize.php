<?php

namespace UPFlex\MixUp\Utils\Fields;

use UPFlex\MixUp\Core\Base;
use UPFlex\MixUp\Core\Traits\Response;

abstract class Sanitize extends Base
{
    use Response;

    /**
     * @return string[][]
     */
    abstract protected static function setFields(): array;

    protected static function getFields(): array
    {
        $class = get_called_class();
        return call_user_func([$class, 'setFields']);
    }

    /**
     * @return array
     */
    protected static function sanitizeFields(): array
    {
        $fields = self::getFields();
        $data = [];

        foreach ($fields as $field) {
            if (isset($field[0])) {
                $method = in_array('GET', is_array($field) ? $field : []);
                $method = $method || in_array('GET', $fields);

                $value = $method ? $_GET[$field[0]] ?? '' : $_POST[$field[0]] ?? '';

                $data[$field[0]] = $value ? self::sanitizeTypeInput($value, $field) : null;
            }
        }

        return array_filter($data);
    }

    protected static function sanitizeTypeInput(string $value, array $args = []): string
    {
        if ($value) {
            if (in_array('email', $args)) {
                $value = sanitize_email($value);
            } elseif (in_array('password', $args)) {
                return $value;
            } else {
                $value = sanitize_text_field($value);
            }
        }

        return strlen($value) > 0 ? $value : '';
    }
}
