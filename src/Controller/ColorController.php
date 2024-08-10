<?php

namespace ofernandoavila\SpaceshipPlugin\Controller;

use ofernandoavila\SpaceshipPlugin\Service\ColorService;
use WP_REST_Request;

class ColorController extends Controller
{
    private ColorService $service;

    public function __construct()
    {
        $this->service = new ColorService();
    }

    public function GetAllColors (WP_REST_Request $request)
    {
        $colors = $this->service->getColors();

        return $this->EnviarResponse($colors);
    }
}
