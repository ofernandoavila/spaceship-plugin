<?php

namespace ofernandoavila\SpaceshipPlugin\Interface;

interface IRepository {
    public function uninstall();

    public function executeQuery(string $query);
    
    public function getContent(string $query);

    public function getById(int $id);
}