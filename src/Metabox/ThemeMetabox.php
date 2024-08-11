<?php

namespace ofernandoavila\SpaceshipPlugin\Metabox;

use ofernandoavila\SpaceshipPlugin\Service\ThemeService;

class ThemeMetabox extends Metabox {

    public function __construct()
    {
        $this->id = 'spaceship_plugin_theme_meta_box';
        $this->title = 'Spaceship Theme';
    }

    public function OnCreateMetaboxField($post) {
        $themeService = new ThemeService();

        // Obtém a lista de temas
        $themes = $themeService->getThemes();
        $selected_theme = get_post_meta($post->ID, 'ssp_theme', true);
    
        $selected_theme = $selected_theme ? $themeService->getThemeById($selected_theme) : $themes[0];
    
        ?>
        <div class="spaceship-picker">
            <div class="spaceship-select" onclick="SSP_SpaceshipPicker_ToggleList()">
                <input type="hidden" name="spaceship_plugin_value" id="spaceship_plugin_value" value="<?= $selected_theme->id ?>" />
                <div class="spaceship-color-sample" style="background-color: <?= $selected_theme->color->value ?>"></div>
                <span class="spaceship-name"><?= $selected_theme->name ?></span>
            </div>
            <ul class="spaceship-list inativo">
                <?php foreach ($themes as $theme): ?>
                    <li class="spaceship-list-item" onclick="SSP_SpaceshipPicker_OnItemSelect(<?= $theme->id ?>, '<?= $theme->name ?>', '<?= $theme->color->value ?>')">
                        <div class="spaceship-color-sample" style="background-color: <?= $theme->color->value ?>"></div>
                        <span class="spaceship-name"><?= $theme->description ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    public function OnSaveMetabox($post_id) {
        // Verifica se a requisição é uma auto-salvamento
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Verifica se o usuário tem permissões
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Verifica e salva o campo personalizado
        if (isset($_POST['spaceship_plugin_value'])) {
            update_post_meta($post_id, 'ssp_theme', sanitize_text_field($_POST['spaceship_plugin_value']));
        }
    }
}