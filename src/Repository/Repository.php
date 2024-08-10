<?php

namespace ofernandoavila\SpaceshipPlugin\Repository;

use ofernandoavila\SpaceshipPlugin\Model\Model;

class Repository {
    public string $table_name;

    public function executeQuery(string $query) {
        global $wpdb;

        return $wpdb->query($query);
    }
    
    public function getContent(string $query) {
        global $wpdb;

        return $wpdb->get_results($query);
    }

    public function getById(int $id) {
        return $this->getContent("SELECT * FROM $this->table_name WHERE `id` = $id;")[0];
    }
}