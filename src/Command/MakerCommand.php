<?php

namespace ofernandoavila\SpaceshipPlugin\Command;

use ofernandoavila\SpaceshipPlugin\Helper\FileHelper;
use ofernandoavila\SpaceshipPlugin\Mock\Mock;

class MakerCommand extends Command {
    public string $trigger = 'make';

    public function __construct()
    {
        $this->append_command('entity', fn($args) => $this->gerarEntidade($args));
        $this->append_command('metabox', fn($args) => $this->gerarMetabox($args));
        parent::__construct();
    }

    public function help() {
        printf("make:entity \t--nome <nome_entidade> \t--nome_plural <nome_entidade_plural>" . PHP_EOL);
        printf("make:metabox \t--nome <nome_metabox> \t--nome_simples <nome_metabox_simples>" . PHP_EOL);
    }

    public function gerarEntidade($args) {
        // Gerando Controller
        $this->__gerarArquivo([
            'nome' => $args['nome'],
            'mock' => 'Controller',
            'replace' => ['NAME' => $args['nome'], 'PLURAL_NAME' => $args['nome_plural']]
        ]);
        
        // Gerando Model
        $this->__gerarArquivo([
            'nome' => $args['nome'],
            'mock' => 'Model',
            'replace' => ['NAME' => $args['nome'], 'PLURAL_NAME' => $args['nome_plural']]
        ]);
        
        // Gerando Repository
        $this->__gerarArquivo([
            'nome' => $args['nome'],
            'mock' => 'Repository',
            'replace' => ['NAME' => $args['nome'], 'PLURAL_NAME' => $args['nome_plural']]
        ]);
        
        // Gerando Service
        $this->__gerarArquivo([
            'nome' => $args['nome'],
            'mock' => 'Service',
            'replace' => ['NAME' => $args['nome'], 'PLURAL_NAME' => $args['nome_plural']]
        ]);

        return;
    }
    
    public function gerarMetabox($args) {
        // Gerando Metabox
        $this->__gerarArquivo([
            'nome' => $args['nome'],
            'mock' => 'Metabox',
            'replace' => ['NAME' => $args['nome'], 'NAME_SIMPLE' => $args['nome_simples']]
        ]);

        return;
    }

    private function __gerarArquivo($data) {
        $root = __DIR__ . '/../';
        $mock = new Mock();
        $file = new FileHelper();

        $data['path'] = $root . '/' . $data['mock'];

        $data['nome_arquivo'] = $data['nome'] . $data['mock'] . '.php';

        $content = $mock->GetMock($data['mock']);
        $content = $mock->ReplaceInMock($data['replace'], $content);

        return $file->SaveFile($data['nome_arquivo'], $data['path'], $content);
    }
}