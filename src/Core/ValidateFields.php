<?php

namespace UPFlex\MixUp\Core;

use UPFlex\MixUp\Core\Interfaces\Components\IValidateFields;

abstract class ValidateFields extends Base implements IValidateFields
{
    protected static string $message = '';
    protected static array $response = [];
    protected static bool $success = false;

    /**
     * @return array
     */
    public static function getFields(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected static function getResponse(): array
    {
        if (!self::$response) {
            self::$response = [
                'success' => self::$success,
                'message' => self::$message,
            ];
        }

        return self::$response;
    }

    /**
     * @return bool
     */
    protected static function requiredFields(): bool
    {
        $required = self::getFields();
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

        return true;
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

    /**
     * @param string $message
     */
    protected static function setMessage(string $message): void
    {
        self::$message = $message;
    }

    /**
     * @param array $response
     */
    protected static function setResponse(array $response): void
    {
        self::$response = $response;
    }
}
