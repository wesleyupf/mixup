<?php

namespace UPFlex\MixUp\Core;

abstract class TemplateParts extends Base
{
    protected static string $folder = '';

    /**
     * @param $slug
     * @param null $name
     * @param array $args
     */
    public static function getPart($slug, $name = null, array $args = []): void
    {
        $templates = array();
        if (isset($name)) {
            $templates[] = sprintf("%s-%s.php", $slug, $name);
        }

        $templates[] = sprintf("%s.php", $slug);

        self::getPath($templates, true, false, $args);
    }

    /**
     * @param $template_names
     * @param false $load
     * @param bool $require_once
     * @param array $args
     * @return string
     */
    public static function getPath($template_names, bool $load = false, bool $require_once = true, array $args = []): string
    {
        if (substr(self::$folder, -1) === '/') {
            $folder = self::$folder;
        } else {
            $folder = sprintf('%s/', self::$folder);
        }

        $template_dir = sprintf('%s/', $folder);
        $located = '';

        foreach ((array)$template_names as $template_name) {
            if (!$template_name) {
                continue;
            }

            if (file_exists($template_dir . $template_name)) {
                $located = $template_dir . $template_name;
                break;
            }
        }

        if ($load && '' != $located) {
            load_template($located, $require_once, $args);
        }

        return $located;
    }

    /**
     * @param string $folder
     */
    public static function setFolder(string $folder): void
    {
        self::$folder = $folder;
    }
}
