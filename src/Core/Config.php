<?php

namespace ofernandoavila\SpaceshipPlugin\Core;

use ofernandoavila\SpaceshipPlugin\Command\Command;
use ofernandoavila\SpaceshipPlugin\Command\MakerCommand;
use ofernandoavila\SpaceshipPlugin\Metabox\DificuldadeMetabox;
use ofernandoavila\SpaceshipPlugin\Metabox\Metabox;
use ofernandoavila\SpaceshipPlugin\Metabox\ThemeMetabox;
use ofernandoavila\SpaceshipPlugin\Service\ColorService;
use ofernandoavila\SpaceshipPlugin\Service\ThemeService;

class Config {
    public static function GetServices() {
        return [
            ColorService::class,
            ThemeService::class,
        ];
    }

    public static function GetServicesUninstall() {
        return [
            ThemeService::class,
            ColorService::class,
        ];
    }
    
    public static function GetMetaboxes() {
        return [
            ThemeMetabox::class,
            DificuldadeMetabox::class,
        ];
    }
    
    public static function GetCommands() {
        return [
            Command::class,
            MakerCommand::class
        ];
    }
}