<?php

namespace ofernandoavila\SpaceshipPlugin\Service;

use ofernandoavila\SpaceshipPlugin\Model\Theme;
use ofernandoavila\SpaceshipPlugin\Repository\ThemeRepository;

class ThemeService extends Service {
    public ThemeRepository $repository;
    public ColorService $colorService;

    public function __construct()
    {
        $this->repository = new ThemeRepository();
        $this->colorService = new ColorService();
    }

    public function install() {
        return $this->repository->install();
    }
    
    public function uninstall() {
        return $this->repository->uninstall();
    }

    public function getThemes() {
        $themes = $this->repository->getThemes();
        $data = [];

        foreach($themes as $theme) {
            $tema = new Theme();

            $tema->id = $theme->id;
            $tema->name = $theme->name;
            $tema->description = $theme->description;
            $tema->color = $this->colorService->getColorById($theme->colorId);
        
            $data[] = $tema;
        }
        
        return $data;
    }

    public function createTheme(Theme $theme) {
        return $this->repository->createTheme($theme->name, $theme->description, $theme->colorId);
    }
    
    public function editTheme(Theme $theme) {
        return $this->repository->editTheme($theme->id, $theme->name, $theme->description, $theme->colorId);
    }
    
    public function deleteTheme(int $id) {
        return $this->repository->deleteTheme($id);
    }
    
    public function getThemeById(int $id) {
        $data = $this->repository->getById($id);

        $theme = new Theme();
        unset($theme->table_name);

        $theme->id = $data->id;
        $theme->name = $data->name;
        $theme->description = $data->description;
        $theme->color = $this->colorService->getColorById($data->colorId);

        return $theme;
    }
}