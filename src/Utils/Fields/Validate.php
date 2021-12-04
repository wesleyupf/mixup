<?php

namespace UPFlex\MixUp\Utils\Fields;

trait Validate
{
    use Sanitize;

    protected static array $counters = [
        'array' => 'count',
        'list' => 'count',
        'lower' => 'strlen',
        'string' => 'strlen',
        'space' => 'strlen',
        'upper' => 'strlen',
        'xdigit' => 'strlen',
    ];

    protected static array $validators = [
        'array' => 'is_array',
        'bool' => 'is_bool',
        'boolean' => 'is_bool',
        'float' => 'is_float',
        'int' => 'is_int',
        'integer' => 'is_int',
        'null' => 'is_null',
        'object' => 'is_object',
        'resource' => 'is_resource',
        'scalar' => 'is_scalar',
        'string' => 'is_string',
    ];

    protected static function checkExpecteds($value, string $expected, $field = ''): array
    {
        foreach (explode('|', $expected) as $item) {
            [$type] = $item = explode(':', $item, 2);

            $type = static::$validators[$type] ?? 'string';

            if (!static::$validators[$type]($value)) {
                self::setalerts($field, $item[0]);

                continue;
            }

            if (isset($item[1])) {
                $length = $value;

                if (isset(static::$counters[$type])) {
                    $length = static::$counters[$type]($value);
                }

                $range = explode(':', $item[1]);

                if (($range[0] === '' || ($item[0] === 'max' ? $length >= $range[0] : $length < $range[0]))) {
                    self::setalerts($field, $item[0]);
                    continue;
                }
            }
        }

        self::$response['success'] = !(isset(self::$response['alerts']) && strpos($expected, 'required') !== false);

        return self::$response;
    }

    /**
     * @return array|bool
     */
    protected static function getFieldsValidated($request = 'post')
    {
        $fields = static::getFields();
        $values = self::sanitizeFields($request);

        if ($fields) {
            foreach ($fields as $key => $requires) {
                $field = is_string($requires) ? $requires : '';
                $response = self::checkExpecteds($values[$key] ?? null, $field, $key);

                if (!$response['success']) {
                    return $response;
                } elseif (isset($response['alerts'])) {
                    $values['alerts'][$key] = $response['alerts'] ?? null;
                }
            }

            return $values;
        }

        return false;
    }

    /**
     * @param $field
     * @param $item
     * @return void
     */
    protected static function setalerts($field, $item): void
    {
        var_dump($field);
        var_dump($item);
        self::$response['alerts'][] = [
            'key' => $field,
            'type' => $item,
        ];
    }
}
