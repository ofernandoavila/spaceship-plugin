<?php

namespace ofernandoavila\SpaceshipPlugin\Helper;

class FileHelper {
    public static function SaveFile(string $name, string $path, string $content) {
        return file_put_contents($path . '/' . $name, $content);
    }
}