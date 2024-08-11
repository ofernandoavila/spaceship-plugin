<?php

namespace ofernandoavila\SpaceshipPlugin\Core;

use ofernandoavila\SpaceshipPlugin\Command\Command;
use ofernandoavila\SpaceshipPlugin\Controller\ColorController;
use ofernandoavila\SpaceshipPlugin\Controller\ThemeController;
use ofernandoavila\SpaceshipPlugin\Interface\IAddOnPostResponse;
use ofernandoavila\SpaceshipPlugin\Service\ColorService;
use ofernandoavila\SpaceshipPlugin\Service\ThemeService;
use WP_REST_Request;
use WP_REST_Response;

class Core {
    // trigger function arguments
    public function cli($arguments) {
        $arguments = $this->extractCommand($arguments);

        $controller = new Command();
        $commands = Config::GetCommands();

        if($arguments['trigger'] == '') {
            return $controller->index([]);
        }

        foreach($commands as $command) {
            $instance = new $command();

            if($arguments['trigger'] == $instance->trigger) {
                $controller = $instance;
                break;
            }
        }

        return $controller->index($arguments);
    }

    private function extractCommand($args) {
        array_shift($args);

        $command = [];
        $command['trigger'] = '';
        $command['function'] = '';
        $command['arguments'] = $args;        

        if(sizeof($args) > 0) {
            $trigger = explode(':', $args[0]);

            if(sizeof($trigger) == 2) {
                $command['trigger'] = $trigger[0];
                $command['function'] = $trigger[1];
                
                array_shift($args);
            } else {
                $command['trigger'] = $args[0];
            }

            $command['arguments'] = $args;
        }

        if(!isset($command['function'])) {
            if(sizeof($args) > 0) {
                $command['function'] = $args[0];
                array_shift($args);
                $command['arguments'] = $args;
            }
            
            if(sizeof($args) > 0) {
                $command['function'] = $args[0];
                array_shift($args);
                $command['arguments'] = $args;
            }
        }
        
        $output = [];
        $teste = $args;

        for($i = 0; $i < sizeof($teste); $i++) {
            if(strpos($teste[$i], '--') === 0) {
                $output[str_replace('--', '', $teste[$i])] = $teste[$i + 1];
                array_shift($teste);
            } else {
                $output[] = $teste[$i];
            }
        }

        $command['arguments'] = $output;
        
        return $command;
    }

    public function init() {
        register_activation_hook(__FILE__, fn() => $this->install());
        register_deactivation_hook(__FILE__, fn() => $this->uninstall());
        
        
        add_action('rest_api_init', fn() => $this->register_api_routes());
        add_action('admin_menu', fn() => $this->addMenuPage());
        add_action( 'init', fn() => $this->registerMenus());
        add_action('admin_enqueue_scripts', fn($hook) => $this->loadAssets($hook));

        $this->installMetaboxes();
    }

    public function install() {
        $services = Config::GetServices();

        foreach($services as $service) {
            $instance = new $service();
            $instance->install();
        }
    }
    
    public static function uninstall() {
        $services = Config::GetServices();

        foreach($services as $service) {
            $instance = new $service();
            $instance->uninstall();
        }
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

    public function loadAssets($hook) {
        $file_js = "main.js";

        $this->__replaceEnvironmentsVariables($file_js);

        if($hook == "toplevel_page_spaceship-plugin-page") {
            wp_enqueue_script('spaceship-plugin-page-script', plugins_url("../../assets/js/$file_js", __FILE__), array(), null, true);
        }
        
        if($hook == "toplevel_page_spaceship-plugin-page" || $hook == 'post.php') {
            wp_enqueue_style('spaceship-plugin-page-style', plugins_url('../../assets/css/main.css', __FILE__));
        }
        
        if($hook == 'post.php') {
            wp_enqueue_script('spaceship-plugin-admin-script', plugins_url('../../assets/js/spaceship-plugin.js', __FILE__), array(), null, true);
        }
    }

    private function __replaceEnvironmentsVariables($file_name) {
        $file_path = WP_PLUGIN_DIR . "/spaceship-plugin/assets/js/$file_name";
        $content = file_get_contents($file_path);
        $pattern = sprintf('#{%s}#', 'BASE_URL');
        $content = str_replace($pattern, get_site_url(), $content);
    
        file_put_contents($file_path, $content);
    }

    public function addMenuPage() {
        return add_menu_page(
            'Themes',                       // Título da página
            'Spaceship',                    // Texto do menu
            'manage_options',               // Capacidade
            'spaceship-plugin-page',        // Slug da página
            fn() => $this->renderPage(),   // Função de callback
            'dashicons-admin-generic',      // Ícone do menu (opcional)
            20                              // Posição do menu (opcional)    
        );
    }

    public function renderPage() {
        echo '<div id="spaceship_plugin_root_element"></div>';
    }

    public function registerMenus() {
        return register_nav_menus(
            array(
                'main-menu' => __( 'Main Menu' ),
            )
        );
    }

    public function installMetaboxes() {
        $metaboxes = Config::GetMetaboxes();

        foreach($metaboxes as $metabox) {
            $instance = new $metabox();
            $instance->install();

            $interfaces = class_implements($metabox);

            foreach($interfaces as $interface) {
                if($interface == IAddOnPostResponse::class) {
                    $this->addFilterPostResponse($instance);
                }
            }
        }
    }

    public function addFilterPostResponse($class) {
        add_filter('rest_prepare_post', fn($response, $post, $context) => $class->addToPostResponse($response, $post, $context), 10, 3);
    }
}