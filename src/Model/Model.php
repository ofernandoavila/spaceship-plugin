<?php

namespace ofernandoavila\SpaceshipPlugin\Model;

use ofernandoavila\SpaceshipPlugin\Interface\IRegisteredInDatabase;

abstract class Model implements IRegisteredInDatabase {
    public string $table_name;
}