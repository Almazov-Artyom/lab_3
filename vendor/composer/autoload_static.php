<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8994a5c2e1cab6463b9c8207dcb719cd
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit8994a5c2e1cab6463b9c8207dcb719cd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8994a5c2e1cab6463b9c8207dcb719cd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8994a5c2e1cab6463b9c8207dcb719cd::$classMap;

        }, null, ClassLoader::class);
    }
}
