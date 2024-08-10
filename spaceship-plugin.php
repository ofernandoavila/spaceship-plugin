<?php
/*
    Plugin Name: Spaceship Plugin
    Description: Plugin para adicionar campos personalizados em posts.
    Version: 1.0
    Author: Fernando Avila
*/

use ofernandoavila\SpaceshipPlugin\Service\ThemeService;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

#region Installation

function SpaceshipPlugin_OnPluginInstall() {    
    \ofernandoavila\SpaceshipPlugin\Core\Core::install();
}

register_activation_hook(__FILE__, 'SpaceshipPlugin_OnPluginInstall');

function SpaceshipPlugin_OnPluginUninstall() {
    \ofernandoavila\SpaceshipPlugin\Core\Core::uninstall();
}

register_deactivation_hook(__FILE__, 'SpaceshipPlugin_OnPluginUninstall');

#endregion

#region ADMIN PAGE CONFIG

function SpaceshipPlugin_AddMenuPage() {
    add_menu_page(
        'Themes',                       // Título da página
        'Spaceship',                    // Texto do menu
        'manage_options',               // Capacidade
        'spaceship-plugin-page',        // Slug da página
        'SpaceshipPlugin_RenderPage',   // Função de callback
        'dashicons-admin-generic',      // Ícone do menu (opcional)
        20                              // Posição do menu (opcional)    
    );

}

add_action('admin_menu', 'SpaceshipPlugin_AddMenuPage');

// Registra um menu personalizado
function SpaceshipPlugin_RegisterMenus() {
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu' ),
        )
    );
}
add_action( 'init', 'SpaceshipPlugin_RegisterMenus' );

function SpaceshipPlugin_RenderPage() {
    echo '<div id="spaceship_plugin_root_element"></div>';
}

function SpaceshipPlugin_Enqueue_Scripts($hook) {
    $SpaceshipPluginPageScriptPath = "main.js";

    SpaceshipPlugin_ReplaceAdminPageBaseURL($SpaceshipPluginPageScriptPath);

    if($hook == "toplevel_page_spaceship-plugin-page") {
        wp_enqueue_script('spaceship-plugin-page-script', plugins_url("assets/js/$SpaceshipPluginPageScriptPath", __FILE__), array(), null, true);
    }
    
    if($hook == "toplevel_page_spaceship-plugin-page" || $hook == 'post.php') {
        wp_enqueue_style('spaceship-plugin-page-style', plugins_url('assets/css/main.css', __FILE__));
    }
    
    if($hook == 'post.php') {
        wp_enqueue_script('spaceship-plugin-admin-script', plugins_url('assets/js/spaceship-plugin.js', __FILE__), array(), null, true);
    }   
}

add_action('admin_enqueue_scripts', 'SpaceshipPlugin_Enqueue_Scripts');

#endregion

#region POST METABOX

// Adiciona uma meta box ao editor de post
function SpaceshipPlugin_PostMetabox() {
    add_meta_box(
        'spaceship_plugin_theme_meta_box',          // ID da meta box
        'Spaceship Theme',                           // Título da meta box
        'SpaceshipPlugin_AddMetaboxField',          // Função de callback
        'post',                                     // Tipo de tela (post)
        'side',                                     // Contexto (lateral)
        'high'                                      // Prioridade
    );
}
add_action('add_meta_boxes', 'SpaceshipPlugin_PostMetabox');

// Função de callback para a meta box
function SpaceshipPlugin_AddMetaboxField($post) {
    $themeService = new ThemeService();

    // Obtém a lista de temas
    $themes = $themeService->getThemes();
    $selected_theme = get_post_meta($post->ID, 'ssp_theme', true);

    $selected_theme = $selected_theme ? $themeService->getThemeById($selected_theme) : $themes[0];

    ?>
    <div class="spaceship-picker">
        <div class="spaceship-select" onclick="SSP_SpaceshipPicker_ToggleList()">
            <input type="hidden" name="spaceship_plugin_value" id="spaceship_plugin_value" value="0" />
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

function SpaceshipPlugin_Metabox_Save($post_id) {
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
add_action('save_post', 'SpaceshipPlugin_Metabox_Save');

#endregion

#region API REST


// Adiciona o tema selecionado ao JSON de resposta da API REST
function SSP_add_theme_to_rest_api($response, $post, $context) {
    $themeService = new ThemeService();

    $theme = get_post_meta($post->ID, 'ssp_theme', true);
    if ($theme) {
        $response->data['theme'] = $themeService->getThemeById(intval($theme));
    }
    return $response;
}
add_filter('rest_prepare_post', 'SSP_add_theme_to_rest_api', 10, 3);

function ssp_register_api_routes() {
    \ofernandoavila\SpaceshipPlugin\Core\Core::register_api_routes();
}

add_action('rest_api_init', 'ssp_register_api_routes');

#endregion


function SpaceshipPlugin_ReplaceAdminPageBaseURL($file_name) {
    $file_path = WP_PLUGIN_DIR . "/spaceship-plugin/assets/js/$file_name";
    $content = file_get_contents($file_path);
    $pattern = sprintf('#{%s}#', 'BASE_URL');
    $content = str_replace($pattern, get_site_url(), $content);

    file_put_contents($file_path, $content);
}