<?php

namespace ofernandoavila\SpaceshipPlugin\Metabox;

class Metabox {

    public string $id;
    public string $title;
    public string $type = 'post';
    public string $context = 'side';
    public string $priority = 'low';

    public function OnCreateMetaboxField($post) {
        throw new \Exception("Not implemented 'OnCreateMetaboxField' on Metabox class");
    }

    public function OnSaveMetabox($post_id) {
        throw new \Exception("Not implemented 'OnSaveMetabox' on Metabox class");
    }
    
    public function OnCreateMetabox() {
        return add_meta_box(
            $this->id,          // ID da meta box
            $this->title,                           // Título da meta box
            fn($post_id) => $this->OnSaveMetabox($post_id),          // Função de callback
            $this->type,                                     // Tipo de tela (post)
            $this->context,                                     // Contexto (lateral)
            $this->priority                                      // Prioridade
        );
    }

    public function install() {
        add_action('save_post', fn($post_id) => $this->OnSaveMetabox($post_id));
        add_action('add_meta_boxes', fn() => $this->OnCreateMetabox());
    }

}