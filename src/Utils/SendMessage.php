<?php

namespace UPFlex\MixUp\Utils;

use UPFlex\MixUp\Utils\Fields\Validate;
use UPFlex\MixUp\Utils\Interfaces\IMessage;
use UPFlex\MixUp\Core\Traits\Response;
use WP_Site;

abstract class SendMessage extends Validate implements IMessage
{
    use Response;

    /**
     * @return array
     */
    abstract protected static function send(): array;

    /**
     * @param $fields
     * @return false|WP_Site
     */
    public static function sendEmail($fields)
    {
        global $blog_id;

        return get_blog_details(['blog_id' => $blog_id]);
    }
}
