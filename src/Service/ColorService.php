<?php

namespace ofernandoavila\SpaceshipPlugin\Service;

use ofernandoavila\SpaceshipPlugin\Model\Color;
use ofernandoavila\SpaceshipPlugin\Repository\ColorRepository;

class ColorService extends Service {
    public ColorRepository $repository;

    public function __construct()
    {
        $this->repository = new ColorRepository();
    }

    public function install() {
        return $this->repository->install();
    }
    
    public function uninstall() {
        return $this->repository->uninstall();
    }

    public function getColors() {
        $data = $this->repository->getColors();
        $colors = [];

        foreach($data as $row) {
            $color = new Color();

            $color->id = $row->id;
            $color->description = $row->description;
            $color->value = $row->value;
        
            $colors[] = $color;
        }

        return $colors;
    }

    public function getColorById(int $id) {
        $data = $this->repository->getColorById($id);
        $color = new Color();

        $color->id = $data->id;
        $color->description = $data->description;
        $color->value = $data->value;

        unset($color->table_name);

        return $color;
    }
}