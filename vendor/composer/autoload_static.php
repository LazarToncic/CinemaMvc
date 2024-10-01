<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf303d603ad258a921ea3d9a37aa35308
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf303d603ad258a921ea3d9a37aa35308::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf303d603ad258a921ea3d9a37aa35308::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf303d603ad258a921ea3d9a37aa35308::$classMap;

        }, null, ClassLoader::class);
    }
}
