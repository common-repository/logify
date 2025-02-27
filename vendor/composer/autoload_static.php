<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit16b8125a407f9d0faf4d81c8e484fc04
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'KaizenCoders\\Logify\\' => 20,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'KaizenCoders\\Logify\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lite/includes',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit16b8125a407f9d0faf4d81c8e484fc04::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit16b8125a407f9d0faf4d81c8e484fc04::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit16b8125a407f9d0faf4d81c8e484fc04::$classMap;

        }, null, ClassLoader::class);
    }
}
