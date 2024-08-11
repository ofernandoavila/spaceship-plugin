<?php

namespace ofernandoavila\SpaceshipPlugin\Metabox;

use ofernandoavila\SpaceshipPlugin\Interface\IAddOnPostResponse;

class DificuldadeMetabox extends Metabox implements IAddOnPostResponse {

    public function __construct()
    {
        $this->id = 'spaceship_plugin_dificuldade_meta_box';
        $this->title = 'Spaceship dificuldade';
        $this->metaboxId = 'ssp_dificuldade';
        $this->valueId = 'spaceship_plugin_dificuldade_value';
    }

    public function OnCreateMetaboxField($post) {
        // To-Do: Implement on create metabox field
        $selected = get_post_meta($post->ID, $this->metaboxId, true);
        ?>
        <div class="SSP_SpaceshipRating">
            <input type="hidden" name="<?= $this->valueId ?>" id="<?= $this->valueId ?>" value="<?= $selected ?>">
            <i data-value="1" class="fa-regular fa-star"></i>
            <i data-value="2" class="fa-regular fa-star"></i>
            <i data-value="3" class="fa-regular fa-star"></i>
        </div>
        <?php
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

    public function addToPostResponse($response, $post, $context) : mixed {
        $theme = get_post_meta($post->ID, $this->metaboxId, true);
        if ($theme) {
            $response->data['dificuldade'] = $theme;
        }
        return $response;
    }
}