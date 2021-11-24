<?php

namespace UPFlex\MixUp\Core;

use UPFlex\MixUp\Core\Interfaces\IMessage;
use WP_Site;

abstract class SendMessage extends ValidateFields implements IMessage
{
    protected static bool $error = true;
    protected static string $message = '';
    protected static array $response = [];

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
                'error' => self::$error,
                'message' => self::$message,
            ];
        }

        return self::$response;
    }

    /**
     * @return array
     */
    public static function send(): array
    {
        return self::sanitizeFields();
    }

    /**
     * @param $fields
     * @return false|WP_Site
     */
    public static function sendEmail($fields)
    {
        global $blog_id;

        return get_blog_details(['blog_id' => $blog_id]);
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
