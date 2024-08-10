<?php

namespace ofernandoavila\SpaceshipPlugin\Core;

use ofernandoavila\SpaceshipPlugin\Controller\ColorController;
use ofernandoavila\SpaceshipPlugin\Controller\ThemeController;
use ofernandoavila\SpaceshipPlugin\Service\ColorService;
use ofernandoavila\SpaceshipPlugin\Service\ThemeService;
use WP_REST_Request;
use WP_REST_Response;

class Core {
    public function init() {

    }

    public static function install() {
        $color = new ColorService();
        $theme = new ThemeService();

        $color->install();
        $theme->install();

        self::register_api_routes();
    }
    
    public static function uninstall() {
        $color = new ColorService();
        $theme = new ThemeService();

        $theme->uninstall();
        $color->uninstall();
    }

    public static function register_api_routes() {
        $router = new Router();

        $router->register_route('/status', 'GET', function (WP_REST_Request $request) {
            return new WP_REST_Response([ "version" => '1.0.0', 'status' => 'running' ], 200);
        });
        
        $router->register_route('/colors', 'GET', function (WP_REST_Request $request) {
            $colorController = new ColorController();

            return $colorController->GetAllColors($request);
        });
        
        $router->register_route('/themes', 'GET', function (WP_REST_Request $request) {
            $controller = new ThemeController();

            return $controller->GetAllThemes($request);
        });
        
        $router->register_route('/themes', 'POST', function (WP_REST_Request $request) {
            $controller = new ThemeController();

            return $controller->CreateTheme($request);
        });
        
        $router->register_route('/themes', 'PATCH', function (WP_REST_Request $request) {
            $controller = new ThemeController();

            return $controller->EditTheme($request);
        });
        
        $router->register_route('/themes/(?P<id>\d+)', 'DELETE', function (WP_REST_Request $request) {
            $controller = new ThemeController();

            return $controller->DeleteTheme($request);
        });

        $router->publish();
    }
}