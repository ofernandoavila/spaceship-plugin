<?php

namespace ofernandoavila\SpaceshipPlugin\Repository;

use ofernandoavila\SpaceshipPlugin\Model\Color;
use ofernandoavila\SpaceshipPlugin\Model\Theme;

class ThemeRepository extends Repository
{
    public function __construct()
    {
        $this->table_name = Theme::GetTableName();
    }

    public function install()
    {
        $colorTable = Color::GetTableName();

        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name  (
                    id int NOT NULL AUTO_INCREMENT,
                    name varchar(255) NOT NULL,
                    description varchar(255) NOT NULL,
                    colorId int,
                    PRIMARY KEY (id),
                    FOREIGN KEY (colorId) REFERENCES $colorTable(id)
                )";

        return $this->executeQuery($sql);
    }

    public function getThemes()
    {
        return $this->getContent("SELECT * FROM $this->table_name;");
    }

    public function createTheme(string $name, string $description, int $colorId) {
        return $this->executeQuery("INSERT INTO $this->table_name (`name`, `description`, `colorId`) VALUES ('$name', '$description', $colorId);");
    }
    
    public function editTheme(int $id, string $name, string $description, int $colorId) {
        return $this->executeQuery("UPDATE $this->table_name SET `name` = '$name', `description` = '$description', `colorId` = $colorId WHERE `id` = $id;");
    }
    
    public function deleteTheme(int $id) {
        return $this->executeQuery("DELETE FROM $this->table_name WHERE `id` = $id;");
    }
}