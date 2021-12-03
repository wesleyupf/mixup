<?php

namespace UPFlex\MixUp\Utils\Fields;

use UPFlex\MixUp\Core\Base;
use UPFlex\MixUp\Core\Traits\Response;

abstract class Sanitize extends Base
{
    use Response;

    /**
     * @return array
     */
    abstract protected static function setFields(): array;

    protected static function getFields(): array
    {
        $class = get_class((object)self::$instance);
        return call_user_func([$class, 'getFields']);
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
                $value = $_POST[$field[0]] ?? null;
                $data[$field[0]] = self::sanitizeTypeInput($value, $field);
            }
        }

        return $data;
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
