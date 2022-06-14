<?php

namespace App;

final class Config
{
    private array $configurations = [];

    public function __construct()
    {
        return $this->load();
    }

    private function load()
    {
        $path = $_SERVER["DOCUMENT_ROOT"] . CONFIG_DIR;
        $arrFiles = $this->listFiles($path);
        foreach ($arrFiles as $file) {
            $fileName = pathinfo($file)['filename'];
            $this->configurations[$fileName] = require $path . $file;
        }
    }

    public function getConfig(string $config, $default = null)
    {
        return array_get($this->configurations, $config, $default);
    }

    public function listFiles($path)
    {
        if ($path[mb_strlen($path) - 1] != '/') {
            $path .= '/';
        }

        $files = array();
        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..' && !is_dir($path.$file) && $file[0] != '.') {
                $files[] = $file;
            }
        }

        closedir($dh);

        return ($files);
    }
}
