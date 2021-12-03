<?php

namespace UPFlex\MixUp\Utils\Fields;

abstract class Validate extends Sanitize
{
    /**
     * @return array|bool
     */
    protected static function requiredFields()
    {
        $fields = static::getFields();
        $values = self::sanitizeFields();

        if (is_array($fields)) {

            foreach ($fields as $field) {
                $field = is_array($field) ? $field : [];

                if (in_array('required', $field)) {
                    if (strlen(trim($values[$field[0]] ?? null)) <= 0) {
                        return false;
                    }
                }
            }

            return $values;
        }

        return false;
    }
}
