<?php

namespace ofernandoavila\SpaceshipPlugin\Mock;

class Mock {
    public function ReplaceInMock($patterns, string $mock) {
        $content = $mock;
        foreach($patterns as $key => $value) {
            $pattern = sprintf('#{%s}#', $key);
            $content = str_replace($pattern, $value, $content);
        }
    
        return $content;
    }

    public function GetMock($name) {
        return file_get_contents(__DIR__ . "/models/$name.mock.ssp");
    }
}