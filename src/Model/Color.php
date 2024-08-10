<?php

namespace ofernandoavila\SpaceshipPlugin\Model;

class Color extends Model {
    public string $table_name;
    public int $id;
    public string $description;
    public string $value;
    
    public function __construct()
    {
        global $wpdb;
        
        $this->table_name = $wpdb->prefix . 'spaceship_colors';
    }
    
    public static function GetTableName() : string {
        global $wpdb;

        return $wpdb->prefix . 'spaceship_colors';
    }
}