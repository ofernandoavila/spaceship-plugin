<?php

namespace ofernandoavila\SpaceshipPlugin\Controller;

use ofernandoavila\SpaceshipPlugin\Model\Theme;
use ofernandoavila\SpaceshipPlugin\Service\ThemeService;
use WP_REST_Request;

class ThemeController extends Controller
{
    private ThemeService $service;

    public function __construct()
    {
        $this->service = new ThemeService();
    }

    public function GetAllThemes (WP_REST_Request $request)
    {
        $themes = $this->service->getThemes();

        return $this->EnviarResponse($themes);
    }
    
    public function CreateTheme (WP_REST_Request $request)
    {
        $theme = json_decode($request->get_body(), true);

        $tema = new Theme();
        
        $tema->name = $theme['name'];
        $tema->description = $theme['description'];
        $tema->colorId = $theme['colorId'];        

        $this->service->createTheme($tema);

        return $this->EnviarResponse(['msg' => 'Theme created!'], 201);
    }
    
    public function EditTheme (WP_REST_Request $request)
    {
        $theme = json_decode($request->get_body(), true);

        $tema = new Theme();
        
        $tema->id = $theme['id'];
        $tema->name = $theme['name'];
        $tema->description = $theme['description'];
        $tema->colorId = $theme['colorId'];        

        $this->service->editTheme($tema);

        return $this->EnviarResponse(['msg' => 'Theme edited!'], 200);
    }
    
    public function DeleteTheme (WP_REST_Request $request)
    {
        $this->service->deleteTheme($request['id']);

        return $this->EnviarResponse(['msg' => 'Theme deleted!'], 200);
    }
}
