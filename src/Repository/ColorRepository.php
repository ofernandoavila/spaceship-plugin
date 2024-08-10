<?php

namespace ofernandoavila\SpaceshipPlugin\Repository;

use ofernandoavila\SpaceshipPlugin\Model\Color;

class ColorRepository extends Repository {
    public string $table_name;

    public function __construct()
    {
        $this->table_name = Color::GetTableName();
    }

    public function install() {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
                    id int NOT NULL AUTO_INCREMENT,
                    description varchar(255) NOT NULL,
                    value varchar(255) NOT NULL,
                    PRIMARY KEY (id)
                );";
        
        $this->executeQuery($sql);

        $sql = "INSERT INTO $this->table_name (`description`, `value`) VALUES " . "\n";
        $sql .=                               "('Red', '#fe3152')," . "\n";
        $sql .=                               "('Orange', '#f39c11')," . "\n";
        $sql .=                               "('Yellow', '#ffd011')," . "\n";
        $sql .=                               "('Green', '#27ae61')," . "\n";
        $sql .=                               "('Light Blue', '#3598db')," . "\n";
        $sql .=                               "('Blue', '#297fb8')," . "\n";
        $sql .=                               "('Purple', '#9a59b5')," . "\n";
        $sql .=                               "('Dark', '#333333')," . "\n";
        $sql .=                               "('Gray', '#d2d2d2')," . "\n";
        $sql .=                               "('White', '#ecf0f1')," . "\n";
        $sql .=                               "('Gold', '#ffc225');";

        return $this->executeQuery($sql);
    }

    public function uninstall() {
        return $this->executeQuery("drop table wp_spaceship_colors");
    }

    public function getColorById(int $id) : object | null {
        return $this->getContent("SELECT * FROM $this->table_name WHERE `id` = $id;")[0];
    }

    public function getColors() {
        return $this->getContent("SELECT * FROM $this->table_name");
    }
}