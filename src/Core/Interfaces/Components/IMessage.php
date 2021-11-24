<?php

namespace UPFlex\MixUp\Core\Interfaces\Components;

interface IMessage
{

    public static function send();

    public static function sendEmail($fields);
}
