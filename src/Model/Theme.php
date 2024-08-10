<?php

namespace ofernandoavila\SpaceshipPlugin\Model;

class Theme extends Model {
    public int $id;
    public string $name;
    public string $description;
    
    // Color
    public Color $color;
    public int $colorId;

    public function __construct()
    {
        global $wpdb;
        
        $this->table_name = $wpdb->prefix . 'spaceship_themes';
    }
    
    public static function GetTableName() : string {
        global $wpdb;
        
        return $wpdb->prefix . 'spaceship_themes';
    }
}