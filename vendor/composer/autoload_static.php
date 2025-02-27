<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit21308bc21b225e85ab7d5c98250ee81d
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UserTestPlugin\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UserTestPlugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'UserTestPlugin\\Admin\\AdminMenu' => __DIR__ . '/../..' . '/Includes/Admin/AdminMenu.php',
        'UserTestPlugin\\Assets' => __DIR__ . '/../..' . '/Includes/Assets.php',
        'UserTestPlugin\\Bootstrap' => __DIR__ . '/../..' . '/Includes/Bootstrap.php',
        'UserTestPlugin\\Database\\UserDatabase' => __DIR__ . '/../..' . '/Includes/Database/UserDatabase.php',
        'UserTestPlugin\\Traits\\Singleton' => __DIR__ . '/../..' . '/Includes/Traits/Singleton.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit21308bc21b225e85ab7d5c98250ee81d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit21308bc21b225e85ab7d5c98250ee81d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit21308bc21b225e85ab7d5c98250ee81d::$classMap;

        }, null, ClassLoader::class);
    }
}
