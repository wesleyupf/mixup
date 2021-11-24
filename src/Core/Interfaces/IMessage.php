<?php

namespace UPFlex\MixUp\Core\Interfaces;

interface IMessage
{

    public static function send();

    public static function sendEmail($fields);
}
