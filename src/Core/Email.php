<?php

namespace UPFlex\MixUp\Core;

abstract class Email
{
    /**
     * @param string $template
     * @param string|null $name
     * @param array $args
     * @return false|string
     */
    public static function getTemplate(string $template, string $name = null, array $args = [])
    {
        ob_start();
        get_template_part($template, $name, $args);
        return ob_get_clean();
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @param $headers
     * @return bool[]
     */
    public static function sendMessage($to, $subject, $body, $headers): array
    {
        if (wp_mail($to, $subject, $body, $headers)) {
            $response = [
                'success' => true,
            ];
        } else {
            $response = [
                'error' => true,
            ];
        }

        return $response;
    }
}
