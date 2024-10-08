<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb051214460699665eace603c52760cd3
{
    public static $prefixLengthsPsr4 = array (
        'o' => 
        array (
            'ofernandoavila\\SpaceshipPlugin\\' => 31,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ofernandoavila\\SpaceshipPlugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb051214460699665eace603c52760cd3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb051214460699665eace603c52760cd3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb051214460699665eace603c52760cd3::$classMap;

        }, null, ClassLoader::class);
    }
}
