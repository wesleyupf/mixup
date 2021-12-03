<?php

namespace UPFlex\MixUp\Utils\Fields;

abstract class Validate extends Sanitize
{
    /**
     * @return array|false
     */
    protected static function requiredFields()
    {
        $required = static::getFields();
        $values = self::sanitizeFields();

        if (!empty($values ?? null) && !empty($required ?? null)) {
            foreach ($required as $field) {
                if (in_array('required', $field)) {
                    if (strlen(trim($values[$field[0]] ?? null)) <= 0) {
                        return false;
                    }
                }
            }
        }

        return $values;
    }
}
