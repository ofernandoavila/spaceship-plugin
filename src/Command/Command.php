<?php

namespace ofernandoavila\SpaceshipPlugin\Command;

class Command {
    public string $trigger = '';
    public array $commands = [];

    public function __construct()
    {
        $this->commands[] = [ 'help' => fn($args) => $this->help($args) ];
    }

    public function index($args) {
        if(isset($args['function'])) {
            foreach($this->get_commands() as $action) {
                $key = array_keys($action)[0];
                if($args['function'] == $key) {
                    return $action[$key]($args['arguments']);
                }
            }
        }

        return $this->help();
    }
    
    public function help() {
        printf("Type 'help' or use the flag '-h | --help' to get help about a command.");
    }

    public function get_commands() {
        return $this->commands;
    }
    
    public function append_command(string $trigger, $callback) {
        return $this->commands[] = [ $trigger => $callback ];
    }
}