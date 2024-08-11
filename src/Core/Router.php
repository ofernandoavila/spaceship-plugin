<?php

namespace ofernandoavila\SpaceshipPlugin\Core;

class Router {
    public string $endpoint = 'spaceship-plugin';
    public string $version = 'v1';

    public array $routes = [];

    public function register_route(string $route, string $method, $callback) {
        return $this->routes[] = [
            "route" => $route,
            "method" => $method,
            "callback" => $callback
        ];
    }

    public function publish() {
        foreach($this->routes as $rota) {
            register_rest_route("$this->endpoint/$this->version", $rota['route'], array(
                'methods'  => $rota['method'],
                'callback' => $rota['callback'],
                'permission_callback' => function() { return ''; }
            ));
        }
    }
}