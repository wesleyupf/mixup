<?php

namespace UPFlex\MixUp\Utils\Fields;

trait Validate
{
    use Sanitize;

    /**
     * @return array|bool
     */
    protected static function getFieldsValidated()
    {
        $fields = static::getFields();
        $values = self::sanitizeFields();

        if ($fields) {
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
