<?php

namespace ofernandoavila\SpaceshipPlugin\Metabox;

class DificuldadeMetabox extends Metabox {

    public function __construct()
    {
        $this->id = 'spaceship_plugin_dificuldade_meta_box';
        $this->title = 'Spaceship dificuldade';
        $this->metaboxId = 'ssp_dificuldade';
        $this->valueId = 'spaceship_plugin_dificuldade_value';
    }

    public function OnCreateMetaboxField($post) {
        // To-Do: Implement on create metabox field
        $selected_theme = get_post_meta($post->ID, $this->metaboxId, true);
        echo '<input type="hidden" name="' . $this->valueId . '" id="' . $this->valueId . '" value="' . $selected_theme .'" />';
    }

    public function OnSaveMetabox($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
        if (!current_user_can('edit_post', $post_id)) { return; }

        if (isset($_POST[$this->valueId])) {
            update_post_meta(
                $post_id, 
                $this->metaboxId, 
                sanitize_text_field(
                    $_POST[$this->valueId]
                )
            );
        }
    }
}