<?php
/*
    Plugin Name: Spaceship Plugin
    Description: Plugin para adicionar campos personalizados em posts.
    Version: 1.0
    Author: Fernando Avila
*/

use ofernandoavila\SpaceshipPlugin\Core\Core;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

$core = new Core();

$core->init();