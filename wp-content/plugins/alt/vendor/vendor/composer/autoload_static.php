<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita99e677b0bbffd988ffaba167013e01b
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Annotations\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Doctrine\\Common\\Annotations\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/annotations/lib/Doctrine/Common/Annotations',
        ),
    );

    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Doctrine\\Common\\Lexer\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/lexer/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita99e677b0bbffd988ffaba167013e01b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita99e677b0bbffd988ffaba167013e01b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita99e677b0bbffd988ffaba167013e01b::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
